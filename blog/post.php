<?php
/**
 * Griffin Quartz - Dynamic Blog Post Renderer
 * Renders individual blog posts from database
 */

$basePath = '..';

// Get slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: /blog/');
    exit();
}

// PRIORITY: Check for static file first - these are hand-crafted and clean
$static_file = __DIR__ . '/' . $slug . '.php';
if (file_exists($static_file)) {
    include $static_file;
    exit();
}

// Try database-driven post if config exists
$configFile = dirname(__DIR__) . '/api/config.php';
if (!file_exists($configFile)) {
    header('HTTP/1.0 404 Not Found');
    echo '<h1>Post not found</h1>';
    exit();
}

require_once $configFile;

// Database connection for dynamic posts
try {
    $pdo = new PDO(
        "mysql:host=" . DB_BLOG_HOST . ";dbname=" . DB_BLOG_NAME . ";charset=utf8mb4",
        DB_BLOG_USER,
        DB_BLOG_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die('Database error');
}

// Get post from database
$stmt = $pdo->prepare("
    SELECT p.*
    FROM blog_posts p
    WHERE p.slug = ?
    AND p.status = 'published'
    AND (p.publish_date IS NULL OR p.publish_date <= NOW())
");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    header('Location: /blog/');
    exit();
}

// Increment view count
$pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?")->execute([$post['id']]);

// Get categories
$stmt = $pdo->prepare("
    SELECT c.name, c.slug
    FROM blog_categories c
    JOIN blog_post_categories pc ON c.id = pc.category_id
    WHERE pc.post_id = ?
");
$stmt->execute([$post['id']]);
$categories = $stmt->fetchAll();

// Get tags
$stmt = $pdo->prepare("
    SELECT t.name, t.slug
    FROM blog_tags t
    JOIN blog_post_tags pt ON t.id = pt.tag_id
    WHERE pt.post_id = ?
");
$stmt->execute([$post['id']]);
$tags = $stmt->fetchAll();

// Get FAQs
$stmt = $pdo->prepare("SELECT question, answer FROM blog_faqs WHERE post_id = ? ORDER BY sort_order");
$stmt->execute([$post['id']]);
$faqs = $stmt->fetchAll();

// Get related posts (same category)
$related = [];
if (!empty($categories)) {
    $cat_ids = array_column($categories, 'slug');
    $stmt = $pdo->prepare("
        SELECT DISTINCT p.id, p.title, p.slug, p.featured_image, p.excerpt, p.publish_date
        FROM blog_posts p
        JOIN blog_post_categories pc ON p.id = pc.post_id
        JOIN blog_categories c ON pc.category_id = c.id
        WHERE c.slug IN ('" . implode("','", $cat_ids) . "')
        AND p.id != ?
        AND p.status = 'published'
        ORDER BY p.publish_date DESC
        LIMIT 3
    ");
    $stmt->execute([$post['id']]);
    $related = $stmt->fetchAll();
}

// Prepare meta values
$seo_title = $post['seo_title'] ?: $post['title'];
$seo_desc = $post['seo_description'] ?: $post['excerpt'] ?: substr(strip_tags($post['content']), 0, 160);
$og_title = $post['og_title'] ?: $seo_title;
$og_desc = $post['og_description'] ?: $seo_desc;
$featured_image = $post['featured_image'] ?: '../images/luxury-white-kitchen-arched-windows-gold.webp';
$publish_date = $post['publish_date'] ?: $post['created_at'];

// Helper function
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Strip Related Articles sections from blog content
 * This removes hardcoded related articles so only the dynamic section renders
 */
function stripRelatedArticles($content) {
    if (empty($content)) {
        return $content;
    }

    // Pattern 1: Remove <section class="blog-related">...</section> with all nested content
    $content = preg_replace(
        '/<section[^>]*class="[^"]*blog-related[^"]*"[^>]*>[\s\S]*?<\/section>/i',
        '',
        $content
    );

    // Pattern 2: Remove <section class="related-articles">...</section>
    $content = preg_replace(
        '/<section[^>]*class="[^"]*related-articles[^"]*"[^>]*>[\s\S]*?<\/section>/i',
        '',
        $content
    );

    // Pattern 3: Remove <div class="...related...">...</div> with nested content
    // Use recursive pattern for nested divs
    $content = preg_replace(
        '/<div[^>]*class="[^"]*(?:related-articles|blog-related|related-posts)[^"]*"[^>]*>(?:[^<]|<(?!div[^>]*>|\/div>)|<div[^>]*>(?:[^<]|<(?!div[^>]*>|\/div>)|<div[^>]*>.*?<\/div>)*<\/div>)*<\/div>/is',
        '',
        $content
    );

    // Pattern 4: Remove any div with class containing "related" (simpler fallback)
    $content = preg_replace(
        '/<div[^>]*class="[^"]*related[^"]*"[^>]*>[\s\S]*?<\/div>/i',
        '',
        $content
    );

    // Pattern 5: Remove h2 "Related Articles/Posts/Reading" and everything after it until next major section
    $content = preg_replace(
        '/<h2[^>]*>\s*Related\s+(?:Articles|Posts|Reading)\s*<\/h2>[\s\S]*?(?=<h2[^>]*>(?!Related)|<section|<footer|<div\s+class="blog-cta"|<div\s+class="blog-faq"|$)/i',
        '',
        $content
    );

    // Pattern 6: Remove h3 "Related Articles/Posts" sections
    $content = preg_replace(
        '/<h3[^>]*>\s*Related\s+(?:Articles|Posts)\s*<\/h3>[\s\S]*?(?=<h2|<h3[^>]*>(?!Related)|<section|<footer|<div\s+class="blog-cta"|$)/i',
        '',
        $content
    );

    // Pattern 7: Remove orphaned article card grids (common structure for related articles)
    $content = preg_replace(
        '/<div[^>]*class="[^"]*(?:articles-grid|article-cards|related-grid|blog-index-grid)[^"]*"[^>]*>[\s\S]*?<\/div>/i',
        '',
        $content
    );

    // Pattern 8: Remove groups of bare anchor tags with images that look like related article cards
    // This catches orphaned related article links without wrapper divs
    $content = preg_replace(
        '/(?:<a[^>]*href="[^"]*(?:\/blog\/|blog\/)[^"]*"[^>]*>\s*<img[^ loading="lazy">]*>\s*(?:<[^>]+>[^<]*<\/[^>]+>\s*)*<\/a>\s*){2,}/i',
        '',
        $content
    );

    // Pattern 9: Clean up any multiple consecutive empty lines or spaces left behind
    $content = preg_replace('/(\s*\n){3,}/', "\n\n", $content);

    return trim($content);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title><?= e($seo_title) ?> | Griffin Quartz Blog</title>
    <meta name="description" content="<?= e($seo_desc) ?>">
    <?php if ($post['seo_keywords']): ?>
    <meta name="keywords" content="<?= e($post['seo_keywords']) ?>">
    <?php endif; ?>
    <meta name="author" content="<?= e($post['author']) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://griffinquartz.com/blog/<?= e($post['slug']) ?>">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://griffinquartz.com/blog/<?= e($post['slug']) ?>">
    <meta property="og:title" content="<?= e($og_title) ?>">
    <meta property="og:description" content="<?= e($og_desc) ?>">
    <meta property="og:image" content="https://griffinquartz.com<?= e($featured_image) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="article:published_time" content="<?= date('c', strtotime($publish_date)) ?>">
    <meta property="article:modified_time" content="<?= date('c', strtotime($post['updated_at'])) ?>">
    <meta property="article:author" content="<?= e($post['author']) ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($og_title) ?>">
    <meta name="twitter:description" content="<?= e($og_desc) ?>">
    <meta name="twitter:image" content="https://griffinquartz.com<?= e($featured_image) ?>">

    <!-- Fonts and Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles.min.css">

    <!-- Schema.org BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "https://griffinquartz.com/"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "Blog",
                "item": "https://griffinquartz.com/blog/"
            },
            {
                "@type": "ListItem",
                "position": 3,
                "name": <?= json_encode($post['title']) ?>,
                "item": "https://griffinquartz.com/blog/<?= e($post['slug']) ?>"
            }
        ]
    }
    </script>

    <!-- Schema.org BlogPosting -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": <?= json_encode($post['title']) ?>,
        "description": <?= json_encode($seo_desc) ?>,
        "image": "https://griffinquartz.com<?= e($featured_image) ?>",
        "datePublished": "<?= date('c', strtotime($publish_date)) ?>",
        "dateModified": "<?= date('c', strtotime($post['updated_at'])) ?>",
        "author": {
            "@type": "Person",
            "name": <?= json_encode($post['author']) ?>
        },
        "publisher": {
            "@type": "Organization",
            "name": "Griffin Quartz",
            "logo": {
                "@type": "ImageObject",
                "url": "https://griffinquartz.com/images/griffin-quartz-logo.webp"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "https://griffinquartz.com/blog/<?= e($post['slug']) ?>"
        }
    }
    </script>

    <?php if (!empty($faqs)): ?>
    <!-- Schema.org FAQPage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            <?php foreach ($faqs as $i => $faq): ?>
            {
                "@type": "Question",
                "name": <?= json_encode($faq['question']) ?>,
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": <?= json_encode($faq['answer']) ?>
                }
            }<?= $i < count($faqs) - 1 ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>
</head>
<body>
<?php include '../includes/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="blog-breadcrumb">
        <div class="container">
            <nav>
                <a href="../">Home</a>
                <span>/</span>
                <a href="/blog/">Blog</a>
                <span>/</span>
                <span class="current"><?= e($post['title']) ?></span>
            </nav>
        </div>
    </div>

    <!-- Blog Article -->
    <article class="blog-article">
        <!-- Full-width Hero -->
        <div class="blog-hero" style="display: flex; align-items: center; justify-content: center;">
            <img src="<?= e($featured_image) ?>" alt="<?= e($post['featured_image_alt'] ?: $post['title']) ?>" class="blog-hero-image" loading="eager">
            <div class="blog-hero-overlay" style="align-items: center; justify-content: center; text-align: center;">
                <div class="blog-hero-content" style="text-align: center; padding-bottom: 0;">
                    <span class="blog-meta">By <?= e($post['author']) ?> | <?= date('M j, Y', strtotime($publish_date)) ?></span>
                    <h1><?= e($post['title']) ?></h1>
                    <div class="blog-share-buttons" style="margin-top: 1.5rem;">
                        <span class="blog-share-label">Share</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=https://griffinquartz.com/blog/<?= e($post['slug']) ?>" target="_blank" rel="noopener" class="blog-share-btn facebook" title="Share on Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=https://griffinquartz.com/blog/<?= e($post['slug']) ?>&text=<?= urlencode($post['title']) ?>" target="_blank" rel="noopener" class="blog-share-btn twitter" title="Share on X"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($post['title'] . ' https://griffinquartz.com/blog/' . $post['slug']) ?>" target="_blank" rel="noopener" class="blog-share-btn whatsapp" title="Share on WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="https://pinterest.com/pin/create/button/?url=https://griffinquartz.com/blog/<?= e($post['slug']) ?>&media=https://griffinquartz.com<?= e($featured_image) ?>&description=<?= urlencode($post['title']) ?>" target="_blank" rel="noopener" class="blog-share-btn pinterest" title="Share on Pinterest"><i class="bi bi-pinterest"></i></a>
                        <a href="sms:?body=<?= urlencode('Check this out: ' . $post['title'] . ' https://griffinquartz.com/blog/' . $post['slug']) ?>" class="blog-share-btn sms" title="Share via SMS"><i class="bi bi-chat-dots"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Body -->
        <div class="blog-body">
            <div class="blog-content">
                <?= stripRelatedArticles($post['content']) ?>

                <?php if (!empty($faqs)): ?>
                <section class="blog-faq" style="margin-top: 3rem;">
                    <h2>Frequently Asked Questions</h2>
                    <?php foreach ($faqs as $faq): ?>
                    <div class="faq-item" style="margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;"><?= e($faq['question']) ?></h3>
                        <p><?= e($faq['answer']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </section>
                <?php endif; ?>

                <?php if (!empty($tags)): ?>
                <div class="blog-tags" style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee;">
                    <strong>Tags:</strong>
                    <?php foreach ($tags as $tag): ?>
                        <a href="/blog/?tag=<?= e($tag['slug']) ?>" style="display: inline-block; padding: 0.25rem 0.5rem; background: #f5f5f5; border-radius: 4px; margin: 0.25rem; font-size: 0.875rem; text-decoration: none; color: #333;">
                            <?= e($tag['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- CTA - Only show if content doesn't already have one -->
            <?php if (strpos($post['content'], 'blog-cta') === false): ?>
            <div class="blog-cta">
                <h3>Ready to Transform Your Kitchen?</h3>
                <p>Get expert advice and a free quote for your quartz countertop project.</p>
                <a href="/#contact-form" class="btn btn-primary">Get Your FREE Estimate</a>
            </div>
            <?php endif; ?>

            <!-- Related Articles - Dynamic section from database -->
            <?php if (!empty($related)): ?>
            <section class="blog-related">
                <h2>Related Articles</h2>
                <div class="blog-related__grid">
                    <?php foreach ($related as $rel):
                        $rel_image = $rel['featured_image'] ?: '../images/luxury-white-kitchen-arched-windows-gold.webp';
                        $rel_date = $rel['publish_date'] ? date('M j, Y', strtotime($rel['publish_date'])) : '';
                    ?>
                    <a href="/blog/<?= e($rel['slug']) ?>" class="blog-related__card">
                        <img src="<?= e($rel_image) ?>" alt="<?= e($rel['title']) ?>" class="blog-related__image" loading="lazy">
                        <div class="blog-related__content">
                            <h3 class="blog-related__title"><?= e($rel['title']) ?></h3>
                            <?php if ($rel_date): ?>
                            <span class="blog-related__date"><?= $rel_date ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </article>

<?php include '../includes/footer.php'; ?>
</body>
</html>
