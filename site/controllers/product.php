<?php

/**
 * Product Page Controller
 * 
 * Handles:
 * - Product data retrieval
 * - Related products
 * - Variant selection
 * - Stock checking
 * - Add to cart functionality
 */

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {
    $product = $kirby->site()->find($kirby->path());
    
    if (!$product) {
        go($kirby->url('home'));
    }

    // Get related products from same category
    $category = $product->parent();
    $relatedProducts = [];
    
    if ($category && $category->intendedTemplate() === 'category') {
        $relatedProducts = $category->children()
            ->listed()
            ->not($product)
            ->shuffle()
            ->limit(4);
    }

    // Handle add to cart
    $addedToCart = false;
    $cartError = null;
    
    if ($kirby->request()->is('POST') && get('action') === 'add_to_cart') {
        $quantity = (int)get('quantity', 1);
        $variant = get('variant', '');
        
        // Validate quantity
        if ($quantity < 1) {
            $quantity = 1;
        }
        
        // Check stock
        if ($product->hasStock() && $product->stock()->toInt() < $quantity) {
            $cartError = 'Not enough stock available';
        } else {
            // Get current cart
            $cart = $kirby->session()->get('cart', []);
            
            // Check if product already in cart with same variant
            $found = false;
            foreach ($cart as &$item) {
                if ($item['slug'] === $product->slug() && $item['variant'] === $variant) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $cart[] = [
                    'slug' => $product->slug(),
                    'variant' => $variant,
                    'quantity' => $quantity,
                    'added_at' => time()
                ];
            }
            
            $kirby->session()->set('cart', $cart);
            $addedToCart = true;
            
            // Trigger event for integrations
            $kirby->trigger('cart.item_added', [
                'product' => $product,
                'quantity' => $quantity,
                'variant' => $variant,
                'cart' => $cart
            ]);
        }
    }

    return [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'addedToCart' => $addedToCart,
        'cartError' => $cartError,
        'variants' => $product->variants()->toObject() ?? [],
        'images' => $product->images()->sortBy('sort', 'asc')
    ];
};
