<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary SEO Meta Tags -->
    <title>Countertop Inspiration Gallery | Griffin Quartz</title>
    <meta name="description" content="Stunning quartz countertop designs for kitchens, bathrooms & outdoor spaces. 100+ photos of luxury installations in South Florida. Find your style.">
    <meta name="keywords" content="quartz countertop gallery, kitchen design ideas, coastal kitchen countertops, modern kitchen inspiration, bathroom vanity ideas, outdoor kitchen designs, waterfall island countertops, Calacatta quartz, white quartz countertops, luxury kitchen photos, South Florida kitchen remodel, Mediterranean kitchen design, spa bathroom countertops, penthouse kitchen, beachfront kitchen">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="https://griffinquartz.com/gallery">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://griffinquartz.com/gallery">
    <meta property="og:title" content="Quartz Countertop Inspiration Gallery | 100+ Design Ideas">
    <meta property="og:description" content="Explore stunning quartz countertop designs for kitchens, bathrooms & outdoor spaces. Find inspiration for your South Florida home.">
    <meta property="og:image" content="https://griffinquartz.com/images/luxury-white-kitchen-arched-windows-gold.webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Quartz Countertop Inspiration Gallery | Griffin Quartz">
    <meta name="twitter:description" content="100+ stunning quartz countertop designs for kitchens, bathrooms & outdoor spaces in South Florida.">
    <meta name="twitter:image" content="https://griffinquartz.com/images/luxury-white-kitchen-arched-windows-gold.webp">

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.min.css">

    <!-- Schema.org BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {"@type": "ListItem", "position": 1, "name": "Home", "item": "https://griffinquartz.com/"},
            {"@type": "ListItem", "position": 2, "name": "Inspiration Gallery", "item": "https://griffinquartz.com/gallery"}
        ]
    }
    </script>

    <!-- Schema.org ImageGallery -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ImageGallery",
        "name": "Griffin Quartz Countertop Inspiration Gallery",
        "description": "Browse over 100 stunning quartz countertop installations including coastal kitchens, spa bathrooms, outdoor entertaining spaces, and luxury penthouse designs in South Florida.",
        "url": "https://griffinquartz.com/gallery",
        "publisher": {
            "@type": "Organization",
            "name": "Griffin Quartz",
            "logo": "https://griffinquartz.com/images/griffin-quartz-logo.webp"
        }
    }
    </script>

    <style>
        /* Gallery Hero Section */
        .gallery-hero {
            position: relative;
            min-height: 70vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .gallery-hero .hero-background {
            position: absolute;
            inset: 0;
        }

        .gallery-hero .hero-background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-hero .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.5) 100%);
        }

        .gallery-hero .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 0 auto;
            padding: 6rem 1.5rem;
            text-align: center;
        }

        .gallery-hero .hero-badge {
            display: inline-block;
            background: rgba(253, 185, 19, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(253, 185, 19, 0.3);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--color-accent);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
        }

        .gallery-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 500;
            color: #fff;
            margin-bottom: 1.25rem;
            line-height: 1.1;
        }

        .gallery-hero .hero-description {
            font-size: 1.1875rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.7;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        .gallery-hero .hero-cta {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .gallery-hero .hero-trust {
            margin-top: 2rem;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .gallery-hero .hero-trust i {
            color: var(--color-accent);
        }

        @media (max-width: 768px) {
            .gallery-hero {
                min-height: 60vh;
            }

            .gallery-hero .hero-content {
                padding: 4rem 1rem;
            }

            .gallery-hero .hero-cta .btn {
                width: 100%;
            }
        }

        /* Style Navigation */
        .style-nav {
            position: sticky;
            top: 77px;
            z-index: 99;
            background: var(--color-white);
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .style-nav-list {
            display: flex;
            justify-content: center;
            gap: 0;
            list-style: none;
            margin: 0;
            padding: 0;
            overflow-x: auto;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }

        .style-nav-list::-webkit-scrollbar {
            display: none;
        }

        .style-nav-item a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 1.25rem;
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--color-gray);
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .style-nav-item a:hover,
        .style-nav-item a.active {
            color: var(--color-primary);
            border-bottom-color: var(--color-accent);
        }

        @media (max-width: 768px) {
            .style-nav {
                top: 69px;
            }
            .style-nav-list {
                justify-content: flex-start;
                padding: 0 1rem;
            }
            .style-nav-item a {
                padding: 0.875rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* Gallery Section Styles */
        .gallery-section {
            padding: 5rem 0;
            scroll-margin-top: 140px;
        }

        .gallery-section:nth-child(even) {
            background: var(--color-light);
        }

        .gallery-section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .gallery-section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 500;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .gallery-section-header p {
            font-size: 1.0625rem;
            color: var(--color-gray);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .gallery-section-header .style-tags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.25rem;
        }

        .gallery-section-header .style-tag {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            background: rgba(253, 185, 19, 0.1);
            border: 1px solid rgba(253, 185, 19, 0.3);
            border-radius: 20px;
            font-size: 0.8125rem;
            color: var(--color-primary);
        }

        /* Masonry Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        @media (max-width: 1200px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }

        .gallery-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 4/3;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .gallery-item.tall {
            grid-row: span 2;
            aspect-ratio: 3/4;
        }

        .gallery-item.wide {
            grid-column: span 2;
            aspect-ratio: 16/9;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.08);
        }

        .gallery-item-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0) 60%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
        }

        .gallery-item:hover .gallery-item-overlay {
            opacity: 1;
        }

        .gallery-item-overlay h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.125rem;
            font-weight: 500;
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .gallery-item-overlay span {
            font-size: 0.8125rem;
            color: var(--color-accent);
        }

        /* Featured Style Card */
        .featured-style-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            margin-bottom: 3rem;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .featured-style-card {
                grid-template-columns: 1fr;
            }
        }

        .featured-style-image {
            position: relative;
            min-height: 400px;
        }

        .featured-style-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured-style-content {
            padding: 3rem;
            background: var(--color-primary);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .featured-style-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--color-accent);
            margin-bottom: 1rem;
        }

        .featured-style-content p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .featured-style-content ul {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem 0;
        }

        .featured-style-content ul li {
            padding: 0.5rem 0;
            color: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .featured-style-content ul li i {
            color: var(--color-accent);
        }

        /* CTA Section */
        .gallery-cta {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--color-accent) 0%, #e0a510 100%);
            text-align: center;
        }

        .gallery-cta h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .gallery-cta p {
            font-size: 1.125rem;
            color: var(--color-primary);
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .gallery-cta .btn {
            margin: 0 0.5rem;
        }

        @media (max-width: 768px) {
            .gallery-cta .btn {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>
<?php $basePath = ''; include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="gallery-hero">
        <div class="hero-background">
            <img src="images/luxury-white-kitchen-arched-windows-gold.webp" alt="Luxury quartz countertop inspiration - kitchen, bathroom and outdoor designs in South Florida" loading="eager" width="800" height="800">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <span class="hero-badge">100+ Design Ideas</span>
            <h1>Find Your Perfect Style</h1>
            <p class="hero-description">Explore stunning quartz countertop installations across South Florida. From coastal kitchens to spa-like bathrooms and resort-style outdoor spaces, discover the design that speaks to you.</p>
            <div class="hero-cta">
                <a href="/#contact-form" class="btn btn-primary">Get FREE Estimate</a>
                <a href="tel:+17203241436" class="btn btn-secondary"><i class="bi bi-telephone"></i> (720) 324-1436</a>
            </div>
            <p class="hero-trust"><i class="bi bi-images"></i> 8 Design Collections &nbsp;|&nbsp; <i class="bi bi-star-fill"></i> South Florida's #1 Choice</p>
        </div>
    </section>

    <!-- Style Navigation -->
    <nav class="style-nav">
        <ul class="style-nav-list">
            <li class="style-nav-item"><a href="#coastal" class="active"><i class="bi bi-water"></i> Coastal Living</a></li>
            <li class="style-nav-item"><a href="#modern"><i class="bi bi-building"></i> Modern Luxury</a></li>
            <li class="style-nav-item"><a href="#mediterranean"><i class="bi bi-sun"></i> Mediterranean</a></li>
            <li class="style-nav-item"><a href="#transitional"><i class="bi bi-house-heart"></i> Transitional</a></li>
            <li class="style-nav-item"><a href="#bold"><i class="bi bi-gem"></i> Bold & Dramatic</a></li>
            <li class="style-nav-item"><a href="#spa"><i class="bi bi-droplet"></i> Spa Retreat</a></li>
            <li class="style-nav-item"><a href="#outdoor"><i class="bi bi-tree"></i> Outdoor Oasis</a></li>
            <li class="style-nav-item"><a href="#urban"><i class="bi bi-buildings"></i> Urban Chic</a></li>
        </ul>
    </nav>

    <!-- ============================================== -->
    <!-- COASTAL LIVING -->
    <!-- ============================================== -->
    <section id="coastal" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Coastal Living Kitchens & Baths</h2>
                <p>Capture the essence of South Florida's waterfront lifestyle. Light, airy spaces with white quartz countertops, natural textures, and breathtaking ocean views define this beloved design aesthetic.</p>
                <div class="style-tags">
                    <span class="style-tag">Beachfront Homes</span>
                    <span class="style-tag">Wicker & Rattan</span>
                    <span class="style-tag">White Quartz</span>
                    <span class="style-tag">Ocean Views</span>
                    <span class="style-tag">Natural Light</span>
                </div>
            </div>

            <div class="featured-style-card">
                <div class="featured-style-image">
                    <img src="images/kitchen-beachfront-ocean-view-globes.webp" alt="Coastal beachfront kitchen with white quartz countertops and ocean view in South Florida" loading="lazy" width="800" height="603">
                </div>
                <div class="featured-style-content">
                    <h3>Coastal Kitchen Design</h3>
                    <p>Embrace the relaxed elegance of coastal living with quartz countertops that complement natural light and ocean views. Perfect for South Florida's beachfront condos and waterfront estates.</p>
                    <ul>
                        <li><i class="bi bi-check-circle-fill"></i> White & cream quartz tones</li>
                        <li><i class="bi bi-check-circle-fill"></i> Soft veining patterns</li>
                        <li><i class="bi bi-check-circle-fill"></i> Woven pendant lighting</li>
                        <li><i class="bi bi-check-circle-fill"></i> Natural wood accents</li>
                        <li><i class="bi bi-check-circle-fill"></i> Indoor-outdoor flow</li>
                    </ul>
                    <a href="/#contact-form" class="btn btn-primary">Get This Look</a>
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item wide">
                    <img src="images/kitchen-beachfront-pool-palms.webp" alt="Beachfront kitchen with pool view and palm trees - coastal quartz countertops" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Beachfront Paradise</h4>
                        <span>Fort Lauderdale</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-coastal-wicker-stools-skylight.webp" alt="Coastal kitchen with wicker bar stools and skylight - white quartz island" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Skylight Kitchen</h4>
                        <span>Delray Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-coastal-woven-pendants-wood.webp" alt="Coastal kitchen with woven pendant lights and wood cabinets" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Natural Textures</h4>
                        <span>Palm Beach</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/bathroom-floating-vanity-ocean-view.webp" alt="Coastal bathroom with floating vanity and ocean view - quartz countertop" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Ocean View Bath</h4>
                        <span>Miami Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-coastal-blue-tile-backsplash.webp" alt="Coastal kitchen with blue tile backsplash and white quartz counters" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Blue Tile Accent</h4>
                        <span>Jupiter</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-coastal-calacatta-palms-flowers.webp" alt="Coastal kitchen with Calacatta quartz and tropical plants" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Tropical Elegance</h4>
                        <span>Boca Raton</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-coastal-oak-wicker-stools.webp" alt="Coastal kitchen with oak cabinets and wicker stools - quartz island" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Oak & Wicker</h4>
                        <span>Hollywood</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-white-quartz-orchids-coastal.webp" alt="Coastal bathroom with white quartz vanity and orchids" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Coastal Bath</h4>
                        <span>Coral Gables</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-beach-condo-woven-pendants.webp" alt="Beach condo kitchen with woven pendant lights and quartz counters" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Beach Condo</h4>
                        <span>Sunny Isles</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/coastal-kitchen-marble-island-coffered-ceiling.webp" alt="Coastal kitchen with marble island and coffered ceiling" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Coffered Elegance</h4>
                        <span>Palm Beach Gardens</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- MODERN LUXURY -->
    <!-- ============================================== -->
    <section id="modern" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Modern Luxury Penthouse Style</h2>
                <p>Sleek lines, premium finishes, and commanding views define modern luxury living. These penthouse and high-rise kitchens showcase the pinnacle of contemporary quartz countertop design.</p>
                <div class="style-tags">
                    <span class="style-tag">Penthouse Living</span>
                    <span class="style-tag">Waterfall Islands</span>
                    <span class="style-tag">High-Rise Condos</span>
                    <span class="style-tag">Calacatta Gold</span>
                    <span class="style-tag">Statement Lighting</span>
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item wide">
                    <img src="images/kitchen-penthouse-calacatta-gold-ocean.webp" alt="Penthouse kitchen with Calacatta Gold quartz and ocean view" loading="lazy" width="800" height="448">
                    <div class="gallery-item-overlay">
                        <h4>Oceanfront Penthouse</h4>
                        <span>Miami Beach</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/kitchen-penthouse-crystal-chandelier.webp" alt="Penthouse kitchen with crystal chandelier and quartz island" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Crystal Chandelier</h4>
                        <span>Aventura</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-highrise-condo-intracoastal.webp" alt="High-rise condo kitchen with Intracoastal view and quartz counters" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Intracoastal Views</h4>
                        <span>Fort Lauderdale</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-highrise-marina-view-white.webp" alt="High-rise kitchen with marina view and white quartz" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Marina Luxury</h4>
                        <span>West Palm Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-penthouse-veined-ocean-view.webp" alt="Penthouse kitchen with veined quartz and panoramic ocean view" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Panoramic Views</h4>
                        <span>Sunny Isles</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-penthouse-calacatta-walnut-ceiling.webp" alt="Penthouse kitchen with Calacatta quartz and walnut ceiling" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Walnut Ceiling</h4>
                        <span>Brickell</span>
                    </div>
                </div>
                <div class="gallery-item wide">
                    <img src="images/modern-kitchen-marble-island-glass-pendants.webp" alt="Modern kitchen with marble island and glass pendant lights" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Glass Pendants</h4>
                        <span>Coral Gables</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-penthouse-blush-cream-arched.webp" alt="Penthouse kitchen with blush and cream tones and arched details" loading="lazy" width="800" height="400">
                    <div class="gallery-item-overlay">
                        <h4>Soft Blush Tones</h4>
                        <span>Palm Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-condo-brittanicca-navy-stools.webp" alt="Condo kitchen with Brittanicca quartz and navy stools" loading="lazy" width="800" height="601">
                    <div class="gallery-item-overlay">
                        <h4>Navy Accents</h4>
                        <span>Boca Raton</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- MEDITERRANEAN ELEGANCE -->
    <!-- ============================================== -->
    <section id="mediterranean" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Mediterranean Elegance</h2>
                <p>Warm tones, arched details, and timeless sophistication inspired by the sun-drenched coasts of Italy and Spain. This romantic style brings Old World charm to South Florida homes.</p>
                <div class="style-tags">
                    <span class="style-tag">Arched Windows</span>
                    <span class="style-tag">Warm Neutrals</span>
                    <span class="style-tag">Stone Accents</span>
                    <span class="style-tag">Tuscan Inspired</span>
                    <span class="style-tag">Terra Cotta</span>
                </div>
            </div>

            <div class="featured-style-card">
                <div class="featured-style-content">
                    <h3>Tuscan-Inspired Kitchen</h3>
                    <p>Transport yourself to the Italian countryside with Mediterranean-style kitchens featuring warm Calacatta quartz, arched details, and rich wood tones. Perfect for South Florida's Spanish Revival estates.</p>
                    <ul>
                        <li><i class="bi bi-check-circle-fill"></i> Warm cream quartz tones</li>
                        <li><i class="bi bi-check-circle-fill"></i> Gold veining patterns</li>
                        <li><i class="bi bi-check-circle-fill"></i> Arched windows & doorways</li>
                        <li><i class="bi bi-check-circle-fill"></i> Ornate range hoods</li>
                        <li><i class="bi bi-check-circle-fill"></i> Rich wood cabinetry</li>
                    </ul>
                    <a href="/#contact-form" class="btn btn-primary">Get This Look</a>
                </div>
                <div class="featured-style-image">
                    <img src="images/mediterranean-kitchen-quartz-arched-window.webp" alt="Mediterranean kitchen with quartz countertops and arched windows" loading="lazy" width="800" height="800">
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="images/kitchen-french-mediterranean-pink-gold.webp" alt="French Mediterranean kitchen with pink and gold accents" loading="lazy" width="800" height="400">
                    <div class="gallery-item-overlay">
                        <h4>French Provincial</h4>
                        <span>Coral Gables</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/kitchen-loft-thick-carrara-arched.webp" alt="Loft kitchen with thick Carrara quartz and arched details" loading="lazy" width="710" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Arched Elegance</h4>
                        <span>Palm Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-french-blue-gray-island.webp" alt="French kitchen with blue-gray island and quartz countertop" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>French Blue</h4>
                        <span>Delray Beach</span>
                    </div>
                </div>
                <div class="gallery-item wide">
                    <img src="images/luxury-white-kitchen-arched-windows-gold.webp" alt="Luxury white kitchen with arched windows and gold fixtures" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Arched Windows</h4>
                        <span>Boca Raton</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-blush-pink-gold-arched.webp" alt="Blush pink kitchen with gold accents and arched ceiling" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Blush & Gold</h4>
                        <span>Wellington</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/mediterranean-outdoor-kitchen-stone-arches.webp" alt="Mediterranean outdoor kitchen with stone arches and quartz" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Stone Arches</h4>
                        <span>Jupiter</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- TRANSITIONAL WARMTH -->
    <!-- ============================================== -->
    <section id="transitional" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Transitional Warmth</h2>
                <p>The perfect blend of classic elegance and modern simplicity. Transitional kitchens feature warm wood tones, soft Calacatta quartz, and timeless designs that never go out of style.</p>
                <div class="style-tags">
                    <span class="style-tag">Warm Woods</span>
                    <span class="style-tag">Calacatta Quartz</span>
                    <span class="style-tag">Classic Details</span>
                    <span class="style-tag">Shaker Cabinets</span>
                    <span class="style-tag">Soft Neutrals</span>
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item wide">
                    <img src="images/kitchen-calacatta-gold-wood-cabinets.webp" alt="Transitional kitchen with Calacatta gold quartz and wood cabinets" loading="lazy" width="533" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Calacatta & Wood</h4>
                        <span>Boca Raton</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-calacatta-walnut-leather-stools.webp" alt="Kitchen with Calacatta quartz, walnut cabinets and leather stools" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Walnut & Leather</h4>
                        <span>Fort Lauderdale</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-calacatta-walnut-orchids.webp" alt="Kitchen with Calacatta quartz, walnut island and orchids" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Walnut Island</h4>
                        <span>Parkland</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/kitchen-transitional-calacatta-tray-ceiling.webp" alt="Transitional kitchen with Calacatta quartz and tray ceiling" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Tray Ceiling</h4>
                        <span>Weston</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-calacatta-gold-globe-pendants.webp" alt="Kitchen with Calacatta gold quartz and globe pendant lights" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Globe Pendants</h4>
                        <span>Coral Springs</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-sage-green-calacatta-gold.webp" alt="Kitchen with sage green cabinets and Calacatta gold quartz" loading="lazy" width="800" height="560">
                    <div class="gallery-item-overlay">
                        <h4>Sage Green</h4>
                        <span>Delray Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-green-cabinets-cream-quartz.webp" alt="Kitchen with green cabinets and cream quartz countertops" loading="lazy" width="800" height="500">
                    <div class="gallery-item-overlay">
                        <h4>Green & Cream</h4>
                        <span>West Palm Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-rustic-white-quartz-wood-beams.webp" alt="Rustic kitchen with white quartz and exposed wood beams" loading="lazy" width="679" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Wood Beams</h4>
                        <span>Jupiter</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- BOLD & DRAMATIC -->
    <!-- ============================================== -->
    <section id="bold" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Bold & Dramatic</h2>
                <p>Make a statement with striking black quartz, dramatic veining, and luxurious gold accents. These show-stopping kitchens prove that dark and moody can be utterly sophisticated.</p>
                <div class="style-tags">
                    <span class="style-tag">Black Quartz</span>
                    <span class="style-tag">Gold Veining</span>
                    <span class="style-tag">Dramatic Contrast</span>
                    <span class="style-tag">Statement Pieces</span>
                    <span class="style-tag">Art Deco</span>
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item wide">
                    <img src="images/kitchen-black-gold-veined-dramatic.webp" alt="Dramatic black kitchen with gold veined quartz countertops" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Black & Gold Drama</h4>
                        <span>Miami Beach</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/kitchen-black-marble-gold-herringbone.webp" alt="Black marble-look quartz kitchen with gold herringbone backsplash" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Herringbone Gold</h4>
                        <span>Fort Lauderdale</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-black-white-calacatta-velvet.webp" alt="Black and white kitchen with Calacatta quartz and velvet seating" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Black & White</h4>
                        <span>Aventura</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-artdeco-brass-navy-curved.webp" alt="Art Deco kitchen with brass accents and navy curved island" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Art Deco Curves</h4>
                        <span>Coral Gables</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/luxury-bathroom-black-marble-gold-fixtures.webp" alt="Luxury bathroom with black marble quartz and gold fixtures" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Black & Gold Bath</h4>
                        <span>Brickell</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-black-white-hexagon-gold.webp" alt="Black and white bathroom with hexagon tile and gold accents" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Hexagon Drama</h4>
                        <span>South Beach</span>
                    </div>
                </div>
                <div class="gallery-item wide">
                    <img src="images/commercial-bar-black-gold-quartz-restaurant.webp" alt="Commercial bar with black and gold quartz countertops" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Restaurant Bar</h4>
                        <span>Wynwood</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- SPA RETREAT BATHROOMS -->
    <!-- ============================================== -->
    <section id="spa" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Spa Retreat Bathrooms</h2>
                <p>Transform your bathroom into a personal sanctuary. These serene spaces feature calming quartz vanities, soaking tubs, and luxurious details that invite relaxation and rejuvenation.</p>
                <div class="style-tags">
                    <span class="style-tag">Floating Vanities</span>
                    <span class="style-tag">Soaking Tubs</span>
                    <span class="style-tag">Vessel Sinks</span>
                    <span class="style-tag">Natural Light</span>
                    <span class="style-tag">Zen Design</span>
                </div>
            </div>

            <div class="featured-style-card">
                <div class="featured-style-image">
                    <img src="images/bathroom-spa-calacatta-vessel-tub.webp" alt="Spa bathroom with Calacatta quartz vanity, vessel sink and freestanding tub" loading="lazy" width="800" height="533">
                </div>
                <div class="featured-style-content">
                    <h3>Spa-Like Master Bath</h3>
                    <p>Create your own private retreat with luxurious quartz vanities, freestanding soaking tubs, and calming neutral tones. South Florida's humidity makes quartz the perfect moisture-resistant choice.</p>
                    <ul>
                        <li><i class="bi bi-check-circle-fill"></i> Non-porous quartz surfaces</li>
                        <li><i class="bi bi-check-circle-fill"></i> Moisture & mold resistant</li>
                        <li><i class="bi bi-check-circle-fill"></i> Vessel & undermount sinks</li>
                        <li><i class="bi bi-check-circle-fill"></i> Floating vanity designs</li>
                        <li><i class="bi bi-check-circle-fill"></i> Matching shower surrounds</li>
                    </ul>
                    <a href="/#contact-form" class="btn btn-primary">Get This Look</a>
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="images/bathroom-spa-white-quartz-wood.webp" alt="Spa bathroom with white quartz and wood accents" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Wood & White</h4>
                        <span>Boca Raton</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-spa-calacatta-walnut-tub.webp" alt="Spa bathroom with Calacatta quartz vanity and walnut tub surround" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Walnut Accents</h4>
                        <span>Palm Beach</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/bathroom-calacatta-vessel-backlit.webp" alt="Bathroom with Calacatta quartz and backlit mirror" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Backlit Luxury</h4>
                        <span>Fort Lauderdale</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-double-vanity-calacatta-gold.webp" alt="Double vanity bathroom with Calacatta gold quartz" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Double Vanity</h4>
                        <span>Coral Springs</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-zen-triple-vessel-terrazzo.webp" alt="Zen bathroom with triple vessel sinks and terrazzo accents" loading="lazy" width="800" height="400">
                    <div class="gallery-item-overlay">
                        <h4>Triple Vessels</h4>
                        <span>Miami</span>
                    </div>
                </div>
                <div class="gallery-item wide">
                    <img src="images/bathroom-spa-infinity-pool-orchids.webp" alt="Spa bathroom overlooking infinity pool with orchids" loading="lazy" width="800" height="400">
                    <div class="gallery-item-overlay">
                        <h4>Pool View Spa</h4>
                        <span>Key Biscayne</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-penthouse-gray-quartz-ocean.webp" alt="Penthouse bathroom with gray quartz and ocean view" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Ocean View</h4>
                        <span>Sunny Isles</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-resort-vessel-bowls-turquoise.webp" alt="Resort-style bathroom with vessel bowl sinks and turquoise accents" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Resort Style</h4>
                        <span>Hollywood</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-minimalist-terrazzo-mountain.webp" alt="Minimalist bathroom with terrazzo accents" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Minimalist Zen</h4>
                        <span>Aventura</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-blush-pink-terrazzo-gold.webp" alt="Blush pink bathroom with terrazzo and gold fixtures" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Blush & Terrazzo</h4>
                        <span>Delray Beach</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- OUTDOOR OASIS -->
    <!-- ============================================== -->
    <section id="outdoor" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Outdoor Oasis Living</h2>
                <p>Extend your living space outdoors with stunning quartz countertops built for South Florida's lifestyle. From poolside bars to complete outdoor kitchens, entertain in style year-round.</p>
                <div class="style-tags">
                    <span class="style-tag">Outdoor Kitchens</span>
                    <span class="style-tag">Pool Bars</span>
                    <span class="style-tag">Fire Pits</span>
                    <span class="style-tag">UV Resistant</span>
                    <span class="style-tag">Entertainment</span>
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item wide">
                    <img src="images/outdoor-kitchen-pool-firepit-dusk.webp" alt="Outdoor kitchen with pool and firepit at dusk" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Poolside Paradise</h4>
                        <span>Boca Raton</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/outdoor-kitchen-marble-fireplace-pool.webp" alt="Outdoor kitchen with marble quartz, fireplace and pool" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Fireplace Lounge</h4>
                        <span>Palm Beach</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/outdoor-kitchen-white-marble-waterfall-modern.webp" alt="Modern outdoor kitchen with white marble waterfall island" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Waterfall Island</h4>
                        <span>Fort Lauderdale</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/outdoor-kitchen-led-underglow-pool.webp" alt="Outdoor kitchen with LED underglow lighting and pool" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>LED Underglow</h4>
                        <span>Weston</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/tropical-outdoor-kitchen-teal-cabinets-rattan.webp" alt="Tropical outdoor kitchen with teal cabinets and rattan seating" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Tropical Teal</h4>
                        <span>Key Biscayne</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/outdoor-kitchen-pool-palms-dusk.webp" alt="Outdoor kitchen with pool and palm trees at dusk" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Palm Paradise</h4>
                        <span>Miami Beach</span>
                    </div>
                </div>
                <div class="gallery-item wide">
                    <img src="images/outdoor-bar-infinity-pool-sunset.webp" alt="Outdoor bar with infinity pool at sunset" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Infinity Sunset</h4>
                        <span>Jupiter</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/outdoor-kitchen-fireplace-wood-ceiling.webp" alt="Outdoor kitchen with fireplace and wood ceiling" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Covered Kitchen</h4>
                        <span>Coral Gables</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/poolside-white-marble-island-palms-dusk.webp" alt="Poolside white marble island with palm trees at dusk" loading="lazy" width="800" height="533">
                    <div class="gallery-item-overlay">
                        <h4>Dusk Entertaining</h4>
                        <span>Parkland</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/covered-patio-white-marble-island-pool.webp" alt="Covered patio with white marble island and pool view" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Covered Patio</h4>
                        <span>Wellington</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/outdoor-kitchen-desert-adobe-firepit.webp" alt="Desert-style outdoor kitchen with adobe and firepit" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Desert Vibes</h4>
                        <span>West Palm Beach</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- URBAN CHIC -->
    <!-- ============================================== -->
    <section id="urban" class="gallery-section">
        <div class="container">
            <div class="gallery-section-header">
                <h2>Urban Chic & Industrial</h2>
                <p>City views, exposed brick, and sophisticated style define urban living. These loft-inspired kitchens and rooftop spaces showcase quartz countertops in edgy, contemporary settings.</p>
                <div class="style-tags">
                    <span class="style-tag">Loft Living</span>
                    <span class="style-tag">Exposed Brick</span>
                    <span class="style-tag">City Views</span>
                    <span class="style-tag">Rooftop Bars</span>
                    <span class="style-tag">Industrial Modern</span>
                </div>
            </div>

            <div class="gallery-grid">
                <div class="gallery-item wide">
                    <img src="images/industrial-loft-kitchen-brick-quartz-island.webp" alt="Industrial loft kitchen with exposed brick and quartz island" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Brick Loft</h4>
                        <span>Wynwood</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/rooftop-outdoor-kitchen-sunset-skyline.webp" alt="Rooftop outdoor kitchen with sunset skyline view" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Skyline Sunset</h4>
                        <span>Brickell</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/rooftop-bar-blue-marble-quartz-cityview.webp" alt="Rooftop bar with blue marble quartz and city view" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>City View Bar</h4>
                        <span>Downtown Miami</span>
                    </div>
                </div>
                <div class="gallery-item tall">
                    <img src="images/bathroom-penthouse-black-white-city.webp" alt="Penthouse bathroom with black and white quartz and city view" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>City Bath</h4>
                        <span>Miami</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/industrial-rooftop-bar-concrete-cityview.webp" alt="Industrial rooftop bar with concrete and city view" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Concrete & Steel</h4>
                        <span>Fort Lauderdale</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/kitchen-miami-penthouse-brown-veined.webp" alt="Miami penthouse kitchen with brown veined quartz" loading="lazy" width="800" height="603">
                    <div class="gallery-item-overlay">
                        <h4>Miami Penthouse</h4>
                        <span>South Beach</span>
                    </div>
                </div>
                <div class="gallery-item wide">
                    <img src="images/rooftop-outdoor-kitchen-ocean-sunset.webp" alt="Rooftop outdoor kitchen with ocean view at sunset" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Ocean Rooftop</h4>
                        <span>Sunny Isles</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/bathroom-penthouse-backlit-mirrors-city.webp" alt="Penthouse bathroom with backlit mirrors and city view" loading="lazy" width="800" height="400">
                    <div class="gallery-item-overlay">
                        <h4>Backlit Mirrors</h4>
                        <span>Aventura</span>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="images/modern-kitchen-gray-quartz-wood-slats.webp" alt="Modern kitchen with gray quartz and wood slat accent wall" loading="lazy" width="800" height="800">
                    <div class="gallery-item-overlay">
                        <h4>Wood Slats</h4>
                        <span>Coral Gables</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gallery-cta">
        <div class="container">
            <h2>Ready to Create Your Dream Space?</h2>
            <p>Our design experts will help you find the perfect quartz countertop to match your style. Schedule a free consultation today.</p>
            <a href="/#contact-form" class="btn btn-dark">Get FREE Estimate</a>
            <a href="tel:+17203241436" class="btn btn-outline-dark"><i class="bi bi-telephone"></i> (720) 324-1436</a>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>

    <script>
        // Style navigation active state on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.style-nav-item a');
            const sections = document.querySelectorAll('.gallery-section');

            // Smooth scroll for nav links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);
                    if (targetSection) {
                        targetSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });

            // Update active state on scroll
            function updateActiveNav() {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 160;
                    if (window.pageYOffset >= sectionTop) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }

            window.addEventListener('scroll', updateActiveNav);
            updateActiveNav();
        });
    </script>
</body>
</html>
