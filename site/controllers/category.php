<?php

/**
 * Category Page Controller
 * 
 * Handles:
 * - Products listing with pagination
 * - Filtering and sorting
 * - SEO data
 */

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {
    $category = $kirby->site()->find($kirby->path());
    
    if (!$category || $category->intendedTemplate() !== 'category') {
        go($kirby->url('home'));
    }
    
    // Get all products in category
    $products = $category->children()->listed();
    
    // Apply filters from query params
    $sortBy = get('sort', 'newest');
    $minPrice = get('min_price');
    $maxPrice = get('max_price');
    $inStock = get('in_stock');
    
    // Sorting
    switch ($sortBy) {
        case 'price_asc':
            $products = $products->sortBy('price', 'asc');
            break;
        case 'price_desc':
            $products = $products->sortBy('price', 'desc');
            break;
        case 'name':
            $products = $products->sortBy('title', 'asc');
            break;
        case 'featured':
            $products = $products->filterBy('is_featured', true);
            break;
        default: // newest
            $products = $products->sortBy('created', 'desc');
    }
    
    // Price filter
    if ($minPrice !== null || $maxPrice !== null) {
        $products = $products->filter(function ($product) use ($minPrice, $maxPrice) {
            $price = (float)$product->price()->value();
            
            if ($minPrice !== null && $price < (float)$minPrice) {
                return false;
            }
            
            if ($maxPrice !== null && $price > (float)$maxPrice) {
                return false;
            }
            
            return true;
        });
    }
    
    // Stock filter
    if ($inStock === '1') {
        $products = $products->filter(function ($product) {
            if (!$product->hasStock()) {
                return true;
            }
            return $product->stock()->toInt() > 0;
        });
    }
    
    // Pagination
    $limit = (int)get('limit', 12);
    $page = (int)get('page', 1);
    $products = $products->paginate($limit);
    
    // Get subcategories
    $subcategories = $category->children()->listed()->filterBy('intendedTemplate', 'category');
    
    return [
        'category' => $category,
        'products' => $products,
        'subcategories' => $subcategories,
        'pagination' => $products->pagination(),
        'filters' => [
            'sort' => $sortBy,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'inStock' => $inStock
        ]
    ];
};
