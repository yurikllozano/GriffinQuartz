<?php
/**
 * Griffin Quartz - Shared Organization Schema
 * Include this in pages that need consistent business info
 */
?>
<!-- Schema.org Organization -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "@id": "https://griffinquartz.com/#organization",
    "name": "Griffin Quartz",
    "alternateName": ["SoFlo Countertops", "Griffin Quartz Countertops"],
    "url": "https://griffinquartz.com",
    "logo": {
        "@type": "ImageObject",
        "url": "https://griffinquartz.com/images/griffin-quartz-logo.webp",
        "width": 200,
        "height": 60
    },
    "image": "https://griffinquartz.com/images/luxury-white-kitchen-arched-windows-gold.webp",
    "description": "South Florida's premier quartz countertop installation company. Serving Fort Lauderdale, Miami, Boca Raton, and surrounding areas with premium Cambria, Silestone, and Caesarstone countertops.",
    "telephone": "+1-720-324-1436",
    "email": "info@griffinquartz.com",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "1021 S Rogers Cir #18",
        "addressLocality": "Boca Raton",
        "addressRegion": "FL",
        "postalCode": "33487",
        "addressCountry": "US"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": 26.3683,
        "longitude": -80.1289
    },
    "areaServed": [
        {"@type": "State", "name": "Florida"},
        {"@type": "City", "name": "Fort Lauderdale"},
        {"@type": "City", "name": "Miami"},
        {"@type": "City", "name": "Boca Raton"},
        {"@type": "City", "name": "West Palm Beach"},
        {"@type": "City", "name": "Hollywood"},
        {"@type": "City", "name": "Pompano Beach"},
        {"@type": "City", "name": "Coral Gables"},
        {"@type": "City", "name": "Aventura"},
        {"@type": "City", "name": "Weston"},
        {"@type": "City", "name": "Coral Springs"},
        {"@type": "City", "name": "Delray Beach"}
    ],
    "sameAs": [
        "https://www.facebook.com/griffinquartz",
        "https://www.instagram.com/griffinquartz",
        "https://www.pinterest.com/griffinquartz"
    ],
    "openingHoursSpecification": [
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
            "opens": "07:30",
            "closes": "15:30"
        }
    ],
    "priceRange": "$$-$$$",
    "paymentAccepted": ["Cash", "Credit Card", "Check", "Financing Available"],
    "currenciesAccepted": "USD",
    "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Countertop Services",
        "itemListElement": [
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Service",
                    "name": "Kitchen Countertop Installation",
                    "description": "Professional quartz countertop installation for kitchens"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Service",
                    "name": "Bathroom Vanity Countertops",
                    "description": "Custom bathroom vanity countertops and installation"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Service",
                    "name": "Commercial Countertops",
                    "description": "Commercial countertop solutions for offices, hotels, restaurants"
                }
            }
        ]
    }
}
</script>
