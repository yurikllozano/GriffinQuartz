<?php
$basePath = '.';
$pageTitle = 'Page Not Found';
$pageDescription = 'The page you were looking for could not be found. Explore Griffin Quartz countertop services, browse our gallery, or contact us.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | Griffin Quartz</title>
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://griffinquartz.com/">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/styles.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        .error-page {
            text-align: center;
            padding: 80px 20px 100px;
            max-width: 720px;
            margin: 0 auto;
        }
        .error-page .error-code {
            font-size: 8rem;
            font-weight: 800;
            color: #c9a96e;
            line-height: 1;
            margin-bottom: 0;
            letter-spacing: -4px;
        }
        .error-page h1 {
            font-size: 2rem;
            color: #1a1a1a;
            margin: 16px 0 12px;
        }
        .error-page .error-message {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        .error-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin: 40px 0;
        }
        .error-link-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            color: #1a1a1a;
            transition: all 0.2s ease;
        }
        .error-link-card:hover {
            border-color: #c9a96e;
            box-shadow: 0 2px 8px rgba(201, 169, 110, 0.15);
            transform: translateY(-1px);
        }
        .error-link-card i {
            font-size: 1.4rem;
            color: #c9a96e;
            flex-shrink: 0;
        }
        .error-link-card span {
            font-weight: 500;
        }
        .error-cta {
            margin-top: 48px;
            padding: 32px;
            background: #f8f6f0;
            border-radius: 12px;
        }
        .error-cta h3 {
            margin: 0 0 8px;
            color: #1a1a1a;
        }
        .error-cta p {
            color: #666;
            margin: 0 0 20px;
        }
        .error-cta .btn {
            display: inline-block;
            padding: 12px 28px;
            background: #c9a96e;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .error-cta .btn:hover {
            background: #b8964f;
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<main class="error-page">
    <p class="error-code">404</p>
    <h1>This Page Has Been Moved or Doesn't Exist</h1>
    <p class="error-message">We recently redesigned our website, so the page you're looking for may have a new home. Try one of the links below or search for what you need.</p>

    <div class="error-links">
        <a href="/" class="error-link-card">
            <i class="bi bi-house"></i>
            <span>Homepage</span>
        </a>
        <a href="/kitchen-bath" class="error-link-card">
            <i class="bi bi-grid-3x3"></i>
            <span>Kitchen Countertops</span>
        </a>
        <a href="/quartz-brands" class="error-link-card">
            <i class="bi bi-gem"></i>
            <span>Quartz Brands</span>
        </a>
        <a href="/gallery" class="error-link-card">
            <i class="bi bi-images"></i>
            <span>Inspiration Gallery</span>
        </a>
        <a href="/blog/" class="error-link-card">
            <i class="bi bi-journal-text"></i>
            <span>Blog &amp; Guides</span>
        </a>
        <a href="/quote-calculator" class="error-link-card">
            <i class="bi bi-calculator"></i>
            <span>Instant Quote</span>
        </a>
        <a href="/locations" class="error-link-card">
            <i class="bi bi-geo-alt"></i>
            <span>Service Areas</span>
        </a>
        <a href="/contact" class="error-link-card">
            <i class="bi bi-envelope"></i>
            <span>Contact Us</span>
        </a>
    </div>

    <div class="error-cta">
        <h3>Need Help Finding Something?</h3>
        <p>Our team is ready to help with your countertop project. Call us at <a href="tel:+17203241436" style="color:#c9a96e;font-weight:600;">(720) 324-1436</a> or get a free estimate online.</p>
        <a href="/contact" class="btn">Get a Free Consultation</a>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
