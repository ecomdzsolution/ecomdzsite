<?php

/**
 * Thank You Page Controller
 * 
 * Handles:
 * - Order confirmation display
 * - Order details retrieval
 * - Tracking information
 * - Upsell offers
 */

use Kirby\Cms\App as Kirby;
use Kirby\Database\Database;

return function (Kirby $kirby) {
    $orderId = param('order_id');
    
    if (!$orderId) {
        go($kirby->url('home'));
    }
    
    // Get order from database
    try {
        $db = new Database([
            'type' => 'sqlite',
            'database' => $kirby->root('storage') . '/db/orders.sqlite'
        ]);
        
        $order = $db->table('orders')
            ->where('id', $orderId)
            ->first();
        
        if (!$order) {
            go($kirby->url('home'));
        }
        
        // Decode items
        $items = json_decode($order['items'], true) ?? [];
        
        // Get upsell products (products not in the order)
        $orderedProductSlugs = array_column($items, 'slug');
        $upsellProducts = [];
        
        $productsPage = $kirby->site()->find('products');
        if ($productsPage) {
            $allProducts = $productsPage->children()->listed();
            $upsellProducts = $allProducts->filter(function ($product) use ($orderedProductSlugs) {
                return !in_array($product->slug(), $orderedProductSlugs);
            })->shuffle()->limit(3);
        }
        
        // Fire conversion event for tracking
        $kirby->trigger('order.completed', [
            'order' => $order,
            'items' => $items,
            'value' => (float)$order['total']
        ]);
        
        return [
            'order' => $order,
            'items' => $items,
            'upsellProducts' => $upsellProducts,
            'orderNumber' => $order['id'],
            'orderDate' => $order['created_at'],
            'total' => (float)$order['total'],
            'status' => $order['status']
        ];
        
    } catch (Exception $e) {
        $kirby->logs()->store('orders')->error('Thank you page error: ' . $e->getMessage());
        go($kirby->url('home'));
    }
};
