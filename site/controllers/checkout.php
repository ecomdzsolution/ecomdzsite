<?php

/**
 * Checkout Controller
 * 
 * Handles:
 * - Cart validation
 * - Shipping calculation
 * - Form processing
 * - Order creation
 * - Fraud detection
 * - Redirect to thank you page
 */

use Kirby\Cms\App as Kirby;
use Kirby\Database\Database;

return function (Kirby $kirby) {
    // Get cart from session or cookie
    $cart = $kirby->session()->get('cart', []);
    
    // If cart is empty, redirect to home
    if (empty($cart)) {
        go($kirby->url('home'));
    }

    // Get products from cart with full details
    $products = [];
    $subtotal = 0;
    $totalQuantity = 0;
    
    foreach ($cart as $item) {
        $product = $kirby->page('products')->find($item['slug']);
        if ($product) {
            $price = (float)$product->price()->value();
            $quantity = (int)$item['quantity'];
            
            // Check stock if enabled
            if ($product->hasStock() && $product->stock()->toInt() < $quantity) {
                $kirby->session()->set('checkout_error', 'Product out of stock: ' . $product->title());
                go($kirby->url('cart'));
            }
            
            $products[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $price * $quantity
            ];
            
            $subtotal += $price * $quantity;
            $totalQuantity += $quantity;
        }
    }

    // Get shipping settings
    $shippingSettings = $kirby->site()->settingsShipping();
    $wilayas = $shippingSettings->wilayas()->toObject();
    
    // Calculate shipping based on wilaya and delivery type
    $shippingCost = 0;
    $deliveryType = get('delivery_type', 'home');
    $wilayaId = get('wilaya', '');
    
    if ($wilayaId && isset($wilayas[$wilayaId])) {
        $wilayaData = $wilayas[$wilayaId];
        $shippingKey = $deliveryType === 'office' ? 'office_price' : 'home_price';
        $shippingCost = (float)($wilayaData[$shippingKey] ?? 0);
        
        // Check free shipping threshold
        $freeShippingThreshold = (float)$shippingSettings->free_shipping_threshold()->or(999999)->value();
        if ($subtotal >= $freeShippingThreshold) {
            $shippingCost = 0;
        }
    }

    $total = $subtotal + $shippingCost;

    // Process form submission
    if ($kirby->request()->is('POST')) {
        $data = $kirby->request()->data();
        
        // Validate required fields
        $rules = [
            'first_name' => ['required' => true, 'min' => 2],
            'last_name' => ['required' => true, 'min' => 2],
            'phone' => ['required' => true, 'pattern' => '/^((\+|00)?213|\d)?(5|6|7)[0-9]{8}$/'],
            'email' => ['required' => false, 'email' => true],
            'address' => ['required' => true, 'min' => 5],
            'wilaya' => ['required' => true],
            'commune' => ['required' => true],
            'delivery_type' => ['required' => true, 'in' => ['home', 'office']],
        ];
        
        $errors = [];
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            
            if (!empty($rule['required']) && empty($value)) {
                $errors[$field] = 'This field is required';
                continue;
            }
            
            if (!empty($rule['min']) && strlen($value) < $rule['min']) {
                $errors[$field] = 'Minimum length is ' . $rule['min'];
            }
            
            if (!empty($rule['pattern']) && !preg_match($rule['pattern'], $value)) {
                $errors[$field] = 'Invalid format';
            }
            
            if (!empty($rule['email']) && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = 'Invalid email address';
            }
            
            if (!empty($rule['in']) && !in_array($value, $rule['in'])) {
                $errors[$field] = 'Invalid option';
            }
        }

        // Fraud detection (basic rules)
        $fraudScore = 0;
        
        // Check for suspicious patterns
        if (strlen($data['phone'] ?? '') !== 10) {
            $fraudScore += 20;
        }
        
        // Check if same phone placed multiple orders recently
        try {
            $db = new Database([
                'type' => 'sqlite',
                'database' => $kirby->root('storage') . '/db/orders.sqlite'
            ]);
            
            $recentOrders = $db->table('orders')
                ->where('phone', $data['phone'] ?? '')
                ->where('created_at', '>', date('Y-m-d H:i:s', strtotime('-1 hour')))
                ->count();
            
            if ($recentOrders > 2) {
                $fraudScore += 30;
            }
            
            // Check total orders from this phone today
            $todayOrders = $db->table('orders')
                ->where('phone', $data['phone'] ?? '')
                ->where('created_at', '>=', date('Y-m-d 00:00:00'))
                ->count();
            
            if ($todayOrders > 5) {
                $fraudScore += 40;
            }
        } catch (Exception $e) {
            // Log error but continue
            $kirby->logs()->store('orders')->error('Database check failed: ' . $e->getMessage());
        }

        // Block if fraud score too high
        if ($fraudScore >= 70) {
            $kirby->logs()->store('fraud')->alert('High fraud score detected', [
                'score' => $fraudScore,
                'phone' => $data['phone'] ?? '',
                'data' => $data
            ]);
            
            // Still create order but mark as suspicious
            $data['fraud_score'] = $fraudScore;
            $data['fraud_flags'] = 'Multiple orders, suspicious phone';
        }

        if (empty($errors)) {
            // Create order in database
            try {
                $db = new Database([
                    'type' => 'sqlite',
                    'database' => $kirby->root('storage') . '/db/orders.sqlite'
                ]);

                $orderData = [
                    'id' => uniqid('ORD_'),
                    'status' => 'pending',
                    'customer_first_name' => $data['first_name'],
                    'customer_last_name' => $data['last_name'],
                    'customer_email' => $data['email'] ?? '',
                    'customer_phone' => $data['phone'],
                    'shipping_address' => $data['address'],
                    'shipping_wilaya' => $data['wilaya'],
                    'shipping_commune' => $data['commune'],
                    'delivery_type' => $data['delivery_type'],
                    'shipping_cost' => $shippingCost,
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'payment_method' => 'cod',
                    'payment_status' => 'unpaid',
                    'items' => json_encode($products),
                    'utm_source' => $data['utm_source'] ?? '',
                    'utm_medium' => $data['utm_medium'] ?? '',
                    'utm_campaign' => $data['utm_campaign'] ?? '',
                    'utm_term' => $data['utm_term'] ?? '',
                    'utm_content' => $data['utm_content'] ?? '',
                    'fraud_score' => $data['fraud_score'] ?? 0,
                    'fraud_flags' => $data['fraud_flags'] ?? '',
                    'notes' => $data['notes'] ?? '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $db->table('orders')->insert($orderData);

                // Clear cart
                $kirby->session()->remove('cart');

                // Send to webhooks
                $kirby->trigger('order.created', [
                    'order' => $orderData,
                    'products' => $products
                ]);

                // Redirect to thank you page
                go($kirby->page('thank-you')->url([
                    'order_id' => $orderData['id']
                ]));

            } catch (Exception $e) {
                $errors['system'] = 'Failed to create order. Please try again.';
                $kirby->logs()->store('orders')->error('Order creation failed: ' . $e->getMessage());
            }
        }

        // If we have errors, show them
        if (!empty($errors)) {
            return [
                'cart' => $products,
                'subtotal' => $subtotal,
                'shippingCost' => $shippingCost,
                'total' => $total,
                'errors' => $errors,
                'formData' => $data
            ];
        }
    }

    // Pass data to template
    return [
        'cart' => $products,
        'subtotal' => $subtotal,
        'shippingCost' => $shippingCost,
        'total' => $total,
        'totalQuantity' => $totalQuantity,
        'wilayas' => $wilayas,
        'errors' => $kirby->session()->get('checkout_errors', []),
        'formData' => []
    ];
};
