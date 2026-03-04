<?php
/**
 * Griffin Quartz - Blog Index
 * Database-driven blog listing with pagination
 */

$basePath = '..';
require_once dirname(__DIR__) . '/api/config.php';

// Database connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_BLOG_HOST . ";dbname=" . DB_BLOG_NAME . ";charset=utf8mb4",
        DB_BLOG_USER,
        DB_BLOG_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    // Fallback to static page if database fails
    include 'index-static.php';
    exit();
}

// Pagination
$per_page = 12;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $per_page;

// Filter by category
$category_slug = $_GET['category'] ?? '';
$category_name = '';

// Build query
$where = "WHERE p.status = 'published' AND (p.publish_date IS NULL OR p.publish_date <= NOW())";
$params = [];

if ($category_slug) {
    $where .= " AND EXISTS (SELECT 1 FROM blog_post_categories pc JOIN blog_categories c ON pc.category_id = c.id WHERE pc.post_id = p.id AND c.slug = ?)";
    $params[] = $category_slug;

    // Get category name
    $stmt = $pdo->prepare("SELECT name FROM blog_categories WHERE slug = ?");
    $stmt->execute([$category_slug]);
    $category_name = $stmt->fetchColumn();
}

// Get total count
$count_sql = "SELECT COUNT(*) FROM blog_posts p $where";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_posts = $stmt->fetchColumn();
$total_pages = ceil($total_posts / $per_page);

// Get posts
$sql = "SELECT p.*, GROUP_CONCAT(DISTINCT c.name) as categories
        FROM blog_posts p
        LEFT JOIN blog_post_categories pc ON p.id = pc.post_id
        LEFT JOIN blog_categories c ON pc.category_id = c.id
        $where
        GROUP BY p.id
        ORDER BY p.publish_date DESC, p.created_at DESC
        LIMIT $per_page OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll();

// Get all categories for filter
$categories = $pdo->query("SELECT c.*, COUNT(pc.post_id) as post_count
                           FROM blog_categories c
                           LEFT JOIN blog_post_categories pc ON c.id = pc.category_id
                           LEFT JOIN blog_posts p ON pc.post_id = p.id AND p.status = 'published'
                           GROUP BY c.id
                           HAVING post_count > 0
                           ORDER BY c.name")->fetchAll();

// Page title
$page_title = $category_name ? "$category_name - Blog" : "Quartz Countertop Blog";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary SEO Meta Tags -->
    <title><?= htmlspecialchars($page_title) ?> | Griffin Quartz</title>
    <meta name="description" content="Expert guides on quartz countertops for South Florida homes. Installation, costs, colors, maintenance and design trends from Griffin Quartz.">
    <meta name="keywords" content="quartz countertops blog, countertop guides South Florida, kitchen countertop tips, quartz installation guide, Fort Lauderdale countertops, Miami quartz countertops">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Griffin Quartz">
    <link rel="canonical" href="https://griffinquartz.com/blog/<?= $category_slug ? '?category=' . htmlspecialchars($category_slug) : '' ?>">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">

    <!-- Geographic Meta Tags -->
    <meta name="geo.region" content="US-FL">
    <meta name="geo.placename" content="South Florida">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://griffinquartz.com/blog/">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?> | Griffin Quartz">
    <meta property="og:description" content="Expert guides on quartz countertops for South Florida homes. Learn about installation, costs, colors, and design trends.">
    <meta property="og:image" content="https://griffinquartz.com/images/luxury-white-kitchen-arched-windows-gold.webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Fonts and Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles.css">

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
            }
        ]
    }
    </script>

    <!-- Schema.org Blog -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Blog",
        "name": "Griffin Quartz Blog",
        "description": "Expert guides and tips on quartz countertops for South Florida homes",
        "url": "https://griffinquartz.com/blog/",
        "publisher": {
            "@type": "Organization",
            "name": "Griffin Quartz",
            "logo": {
                "@type": "ImageObject",
                "url": "https://griffinquartz.com/images/griffin-quartz-logo.webp"
            }
        }
    }
    </script>

    <style>
        .blog-filters { margin-bottom: 2rem; display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .blog-filters a { display: inline-block; padding: 0.5rem 1rem; background: #f5f5f5; color: #333; text-decoration: none; border-radius: 4px; font-size: 0.875rem; transition: all 0.2s; }
        .blog-filters a:hover, .blog-filters a.active { background: #FDB913; color: #000; }
        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 3rem; }
        .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #f5f5f5; color: #333; text-decoration: none; border-radius: 4px; font-weight: 500; }
        .pagination a:hover { background: #FDB913; }
        .pagination .current { background: #FDB913; color: #000; }
        .pagination .disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="blog-breadcrumb">
        <div class="container">
            <nav>
                <a href="../">Home</a>
                <span>/</span>
                <?php if ($category_name): ?>
                    <a href="/blog/">Blog</a>
                    <span>/</span>
                    <span class="current"><?= htmlspecialchars($category_name) ?></span>
                <?php else: ?>
                    <span class="current">Blog</span>
                <?php endif; ?>
            </nav>
        </div>
    </div>

    <!-- Blog Index Section -->
    <section class="blog-index-section">
        <div class="container">
            <div class="blog-index-header">
                <h1><?= $category_name ? htmlspecialchars($category_name) : 'Quartz Countertop Blog' ?></h1>
                <p>Expert guides, tips, and inspiration for your South Florida countertop project</p>
            </div>

            <?php if (!empty($categories)): ?>
            <div class="blog-filters">
                <a href="/blog/" <?= !$category_slug ? 'class="active"' : '' ?>>All Posts</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="/blog/?category=<?= htmlspecialchars($cat['slug']) ?>"
                       <?= $category_slug === $cat['slug'] ? 'class="active"' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?> (<?= $cat['post_count'] ?>)
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (empty($posts)): ?>
                <p style="text-align: center; padding: 3rem; color: #666;">No posts found.</p>
            <?php else: ?>
                <div class="blog-index-grid">
                    <?php foreach ($posts as $post):
                        $image = $post['featured_image'] ?: '../images/luxury-white-kitchen-arched-windows-gold.webp';
                        $date = $post['publish_date'] ? date('M j, Y', strtotime($post['publish_date'])) : date('M j, Y', strtotime($post['created_at']));
                        $excerpt = $post['excerpt'] ?: substr(strip_tags($post['content']), 0, 150) . '...';
                    ?>
                    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="blog-index-card">
                        <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($post['featured_image_alt'] ?: $post['title']) ?>" loading="lazy">
                        <div class="blog-index-card-content">
                            <span class="blog-meta">By <?= htmlspecialchars($post['author']) ?> &bull; <?= $date ?></span>
                            <h2><?= htmlspecialchars($post['title']) ?></h2>
                            <p><?= htmlspecialchars($excerpt) ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= $category_slug ? '&category=' . htmlspecialchars($category_slug) : '' ?>">&laquo;</a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <?php if ($i === $page): ?>
                            <span class="current"><?= $i ?></span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?><?= $category_slug ? '&category=' . htmlspecialchars($category_slug) : '' ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?><?= $category_slug ? '&category=' . htmlspecialchars($category_slug) : '' ?>">&raquo;</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="blog-cta" style="max-width: 100%; border-radius: 0; margin: 0;">
        <div class="container">
            <h3>Ready to Transform Your Space?</h3>
            <p>Get a free quote for your quartz countertop project in South Florida.</p>
            <a href="/#contact-form" class="btn btn-primary">Get FREE Estimate</a>
        </div>
    </section>

<?php include '../includes/footer.php'; ?>
</body>
</html>
