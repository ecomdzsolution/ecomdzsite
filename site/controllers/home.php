<?php

/**
 * Home Page Controller
 * 
 * Handles:
 * - Featured products
 * - Categories
 * - Hero content
 * - Dynamic sections
 */

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {
    $site = $kirby->site();
    $home = $site->homePage();
    
    // Get featured products
    $featuredProducts = $site->find('products')?->children()?->listed()?->filterBy('is_featured', true)?->limit(8);
    
    // If no featured products, get latest products
    if ($featuredProducts->count() === 0) {
        $featuredProducts = $site->find('products')?->children()?->listed()?->limit(8);
    }
    
    // Get all categories
    $categories = $site->find('categories')?->children()?->listed();
    
    // Get testimonials if exists
    $testimonials = [];
    $testimonialsPage = $site->find('testimonials');
    if ($testimonialsPage) {
        $testimonials = $testimonialsPage->children()->listed()->limit(6);
    }
    
    // Get custom sections from home page
    $sections = $home->sections()->toObject() ?? [];
    
    return [
        'home' => $home,
        'featuredProducts' => $featuredProducts,
        'categories' => $categories,
        'testimonials' => $testimonials,
        'sections' => $sections,
        'heroTitle' => $home->hero_title(),
        'heroSubtitle' => $home->hero_subtitle(),
        'heroImage' => $home->hero_image()->toFile(),
        'heroCtaText' => $home->hero_cta_text(),
        'heroCtaLink' => $home->hero_cta_link()
    ];
};
