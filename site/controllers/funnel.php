<?php

/**
 * Funnel Page Controller
 * 
 * Handles:
 * - Funnel step navigation
 * - Conversion tracking
 * - A/B testing
 * - Upsell/Downsell logic
 */

use Kirby\Cms\App as Kirby;

return function (Kirby $kirby) {
    $funnel = $kirby->site()->find($kirby->path());
    
    if (!$funnel || $funnel->intendedTemplate() !== 'funnel') {
        go($kirby->url('home'));
    }
    
    // Get current step from URL or session
    $currentStep = param('step') ?? get('step', 1);
    $funnelId = $funnel->id();
    
    // Get funnel steps
    $steps = $funnel->steps()->toObject() ?? [];
    $stepKeys = array_keys($steps);
    $totalSteps = count($steps);
    
    // Validate step
    if (!isset($steps[$currentStep]) && !is_numeric($currentStep)) {
        // Try to find step by name
        $found = false;
        foreach ($steps as $key => $step) {
            if (($step['slug'] ?? '') === $currentStep) {
                $currentStep = $key;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $currentStep = 1;
        }
    }
    
    // Get funnel data from session
    $funnelData = $kirby->session()->get('funnel_' . $funnelId, []);
    
    // Store current step
    $funnelData['current_step'] = $currentStep;
    $funnelData['last_visited'] = time();
    $kirby->session()->set('funnel_' . $funnelId, $funnelData);
    
    // Get products for this step
    $stepProducts = [];
    $stepData = $steps[$currentStep] ?? [];
    
    if (!empty($stepData['products'])) {
        $productSlugs = explode(',', $stepData['products']);
        $productsPage = $kirby->site()->find('products');
        
        if ($productsPage) {
            foreach ($productSlugs as $slug) {
                $product = $productsPage->find(trim($slug));
                if ($product) {
                    $stepProducts[] = $product;
                }
            }
        }
    }
    
    // Handle form submission (add to cart, continue, etc.)
    if ($kirby->request()->is('POST')) {
        $action = get('action');
        
        if ($action === 'add_to_cart') {
            $productId = get('product_id');
            $quantity = (int)get('quantity', 1);
            
            $productsPage = $kirby->site()->find('products');
            $product = $productsPage?->find($productId);
            
            if ($product) {
                $cart = $kirby->session()->get('cart', []);
                $cart[] = [
                    'slug' => $product->slug(),
                    'quantity' => $quantity,
                    'added_at' => time(),
                    'funnel_step' => $currentStep
                ];
                $kirby->session()->set('cart', $cart);
                
                $funnelData['converted_steps'][] = $currentStep;
                $kirby->session()->set('funnel_' . $funnelId, $funnelData);
            }
        }
        
        // Navigate to next step
        $nextStep = get('next_step');
        if ($nextStep) {
            $nextStepKey = is_numeric($nextStep) ? $nextStep : array_search($nextStep, $stepKeys);
            
            if (isset($steps[$nextStepKey])) {
                go($funnel->url() . '/step:' . $nextStepKey);
            }
        }
    }
    
    // Track funnel analytics
    $funnelData['visits'][$currentStep] = ($funnelData['visits'][$currentStep] ?? 0) + 1;
    $kirby->session()->set('funnel_' . $funnelId, $funnelData);
    
    return [
        'funnel' => $funnel,
        'currentStep' => $currentStep,
        'stepData' => $stepData,
        'totalSteps' => $totalSteps,
        'stepProducts' => $stepProducts,
        'steps' => $steps,
        'funnelData' => $funnelData,
        'isFirstStep' => $currentStep == 1,
        'isLastStep' => $currentStep == $totalSteps
    ];
};
