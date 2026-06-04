<?php
// Organization Structured Data
if ($site->logo()->toFile() || $site->phone()->isNotEmpty()):
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "<?= $site->title() ?>",
    "url": "<?= $site->url() ?>",
    "logo": "<?= $site->logo()->toFile()?->url() ?>",
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "<?= $site->phone() ?>",
        "contactType": "customer service",
        "availableLanguage": ["Arabic", "French", "English"]
    },
    "areaServed": {
        "@type": "Country",
        "name": "Algeria"
    }
}
</script>
<?php endif;

// Product Structured Data (if on product page)
if ($page->intendedTemplate() === 'product'):
    $product = $page;
    $price = (float)$product->price()->value();
    $currency = 'DZD';
    $inStock = !$product->hasStock() || $product->stock()->toInt() > 0;
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "<?= $product->title() ?>",
    "description": "<?= $product->meta_description() ?>",
    "image": [
        <?php foreach ($product->images()->limit(3) as $index => $image): ?>
        "<?= $image->toFile()?->url() ?>"<?= $index < $product->images()->count() - 1 ? ',' : '' ?>
        <?php endforeach; ?>
    ],
    "sku": "<?= $product->sku() ?>",
    "brand": {
        "@type": "Brand",
        "name": "<?= $product->brand()->or($site->title()) ?>"
    },
    "offers": {
        "@type": "Offer",
        "url": "<?= $product->url() ?>",
        "priceCurrency": "<?= $currency ?>",
        "price": <?= $price ?>,
        "priceValidUntil": "<?= date('Y-12-31') ?>",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "<?= $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>",
        "seller": {
            "@type": "Organization",
            "name": "<?= $site->title() ?>"
        },
        "shippingDetails": {
            "@type": "OfferShippingDetails",
            "shippingRate": {
                "@type": "MonetaryAmount",
                "value": "0",
                "currency": "<?= $currency ?>"
            },
            "deliveryTime": {
                "@type": "ShippingDeliveryTime",
                "handlingTime": {
                    "@type": "QuantitativeValue",
                    "minValue": 1,
                    "maxValue": 3,
                    "unitCode": "d"
                },
                "transitTime": {
                    "@type": "QuantitativeValue",
                    "minValue": 2,
                    "maxValue": 5,
                    "unitCode": "d"
                }
            }
        }
    },
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?= $product->rating()->or(4.5) ?>",
        "reviewCount": "<?= $product->reviews_count()->or(10) ?>"
    }
}
</script>
<?php endif;

// Breadcrumb Structured Data
$breadcrumbs = [];
$current = $page;
while ($current && $current->depth() > 0) {
    array_unshift($breadcrumbs, ['name' => $current->title(), 'url' => $current->url()]);
    $current = $current->parent();
}
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        <?php foreach ($breadcrumbs as $index => $crumb): ?>
        {
            "@type": "ListItem",
            "position": <?= $index + 1 ?>,
            "name": "<?= $crumb['name'] ?>",
            "item": "<?= $crumb['url'] ?>"
        }<?= $index < count($breadcrumbs) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
    ]
}
</script>
