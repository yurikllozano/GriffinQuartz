<?php
/**
 * Griffin Quartz - Scheduled Blog Posts Import Script (Batch 2)
 * Reads 5 text files containing blog posts 23-50 and inserts them into the database
 * Posts are set to 'scheduled' status with future publish dates
 * Dates interleave with Batch 1 (posts 4-22) to achieve weekly publishing cadence
 * Run once from admin panel
 */

require_once __DIR__ . '/includes/admin-auth.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    ?>
    <!DOCTYPE html>
    <html><head><title>Create Scheduled Posts Batch 2 - Login</title></head>
    <body style="font-family:sans-serif;max-width:400px;margin:50px auto;">
        <h2>Admin Login Required</h2>
        <?php if (isset($auth_error)): ?><p style="color:red;"><?= $auth_error ?></p><?php endif; ?>
        <form method="post"><input type="password" name="admin_password" placeholder="Admin password" style="padding:8px;width:100%;"><br><br>
        <button type="submit" style="padding:8px 16px;">Login</button></form>
    </body></html>
    <?php
    exit();
}

// ============================================================
// Configuration: Post metadata, images, and publish dates
// Dates fill in the "off weeks" between Batch 1's biweekly schedule
// to achieve weekly publishing from April 2026 through Feb 2027
// ============================================================

$post_config = [
    // === Informational/How-To (Posts 23-28) ===
    23 => [
        'featured_image' => '/images/how-quartz-countertops-are-made-hero.webp',
        'publish_date'   => '2026-04-18 08:00:00',
    ],
    24 => [
        'featured_image' => '/images/are-quartz-countertops-heat-resistant-hero.webp',
        'publish_date'   => '2026-05-02 08:00:00',
    ],
    25 => [
        'featured_image' => '/images/do-quartz-countertops-stain-hero.webp',
        'publish_date'   => '2026-05-16 08:00:00',
    ],
    26 => [
        'featured_image' => '/images/quartz-countertops-pros-and-cons-hero.webp',
        'publish_date'   => '2026-05-30 08:00:00',
    ],
    27 => [
        'featured_image' => '/images/can-you-cut-on-quartz-countertops-hero.webp',
        'publish_date'   => '2026-06-13 08:00:00',
    ],
    28 => [
        'featured_image' => '/images/quartz-countertop-edge-profiles-hero.webp',
        'publish_date'   => '2026-06-27 08:00:00',
    ],

    // === Comparison/Buying (Posts 29-34) ===
    29 => [
        'featured_image' => '/images/quartz-vs-quartzite-hero.webp',
        'publish_date'   => '2026-07-04 08:00:00',
    ],
    30 => [
        'featured_image' => '/images/quartz-vs-marble-countertops-hero.webp',
        'publish_date'   => '2026-07-18 08:00:00',
    ],
    31 => [
        'featured_image' => '/images/best-quartz-countertop-colors-hero.webp',
        'publish_date'   => '2026-08-01 08:00:00',
    ],
    32 => [
        'featured_image' => '/images/white-quartz-countertops-that-look-like-marble-hero.webp',
        'publish_date'   => '2026-08-15 08:00:00',
    ],
    33 => [
        'featured_image' => '/images/black-quartz-countertops-hero.webp',
        'publish_date'   => '2026-08-29 08:00:00',
    ],
    34 => [
        'featured_image' => '/images/quartz-countertops-with-veining-hero.webp',
        'publish_date'   => '2026-09-12 08:00:00',
    ],

    // === Commercial Intent (Posts 35-40) ===
    35 => [
        'featured_image' => '/images/countertop-fabricator-near-me-hero.webp',
        'publish_date'   => '2026-09-26 08:00:00',
    ],
    36 => [
        'featured_image' => '/images/quartz-countertop-installation-cost-hero.webp',
        'publish_date'   => '2026-10-03 08:00:00',
    ],
    37 => [
        'featured_image' => '/images/cambria-countertops-near-me-hero.webp',
        'publish_date'   => '2026-10-17 08:00:00',
    ],
    38 => [
        'featured_image' => '/images/kitchen-countertop-replacement-hero.webp',
        'publish_date'   => '2026-10-31 08:00:00',
    ],
    39 => [
        'featured_image' => '/images/bathroom-quartz-countertops-hero.webp',
        'publish_date'   => '2026-11-14 08:00:00',
    ],
    40 => [
        'featured_image' => '/images/outdoor-kitchen-countertops-hero.webp',
        'publish_date'   => '2026-11-28 08:00:00',
    ],

    // === Location Pages (Posts 41-46) ===
    41 => [
        'featured_image' => '/images/quartz-countertops-miami-hero.webp',
        'publish_date'   => '2026-12-26 08:00:00',
    ],
    42 => [
        'featured_image' => '/images/quartz-countertops-west-palm-beach-hero.webp',
        'publish_date'   => '2027-01-02 08:00:00',
    ],
    43 => [
        'featured_image' => '/images/quartz-countertops-coral-gables-hero.webp',
        'publish_date'   => '2027-01-09 08:00:00',
    ],
    44 => [
        'featured_image' => '/images/quartz-countertops-weston-hero.webp',
        'publish_date'   => '2027-01-16 08:00:00',
    ],
    45 => [
        'featured_image' => '/images/quartz-countertops-delray-beach-hero.webp',
        'publish_date'   => '2027-01-23 08:00:00',
    ],
    46 => [
        'featured_image' => '/images/quartz-countertops-aventura-hero.webp',
        'publish_date'   => '2027-01-30 08:00:00',
    ],

    // === Trending/Specialty (Posts 47-50) ===
    47 => [
        'featured_image' => '/images/calacatta-quartz-countertops-guide-hero.webp',
        'publish_date'   => '2027-02-06 08:00:00',
    ],
    48 => [
        'featured_image' => '/images/waterfall-quartz-countertop-hero.webp',
        'publish_date'   => '2027-02-13 08:00:00',
    ],
    49 => [
        'featured_image' => '/images/quartz-countertop-seams-hero.webp',
        'publish_date'   => '2027-02-20 08:00:00',
    ],
    50 => [
        'featured_image' => '/images/quartz-countertops-for-condos-hero.webp',
        'publish_date'   => '2027-02-27 08:00:00',
    ],
];

// Source text files
$source_files = [
    __DIR__ . '/../blog-content/gq-blog-posts-23-28.txt',
    __DIR__ . '/../blog-content/gq-blog-posts-29-34.txt',
    __DIR__ . '/../blog-content/gq-blog-posts-35-40.txt',
    __DIR__ . '/../blog-content/gq-blog-posts-41-46.txt',
    __DIR__ . '/../blog-content/gq-blog-posts-47-50.txt',
];

// ============================================================
// Parser: Extract posts from text files (same as Batch 1)
// ============================================================

function parse_blog_posts_file($filepath) {
    $posts = [];
    $content = file_get_contents($filepath);
    if ($content === false) {
        return $posts;
    }

    // Split by post markers
    $parts = preg_split('/^=== POST (\d+): (.+?) ===$/m', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

    // parts[0] = content before first post (empty/whitespace)
    // Then groups of 3: [post_number, title, content_block]
    for ($i = 1; $i + 2 < count($parts); $i += 3) {
        $post_num = (int)$parts[$i];
        $title = trim($parts[$i + 1]);
        $block = $parts[$i + 2];

        $post = [
            'post_number' => $post_num,
            'title'       => $title,
            'slug'        => '',
            'seo_title'   => '',
            'seo_description' => '',
            'seo_keywords'    => '',
            'excerpt'     => '',
            'content'     => '',
            'faqs'        => [],
        ];

        // Extract SLUG
        if (preg_match('/^SLUG:\s*(.+)$/m', $block, $m)) {
            $post['slug'] = trim($m[1]);
        }

        // Extract SEO_TITLE
        if (preg_match('/^SEO_TITLE:\s*(.+)$/m', $block, $m)) {
            $post['seo_title'] = trim($m[1]);
        }

        // Extract SEO_DESCRIPTION
        if (preg_match('/^SEO_DESCRIPTION:\s*(.+)$/m', $block, $m)) {
            $post['seo_description'] = trim($m[1]);
        }

        // Extract SEO_KEYWORDS
        if (preg_match('/^SEO_KEYWORDS:\s*(.+)$/m', $block, $m)) {
            $post['seo_keywords'] = trim($m[1]);
        }

        // Extract EXCERPT
        if (preg_match('/^EXCERPT:\s*(.+)$/m', $block, $m)) {
            $post['excerpt'] = trim($m[1]);
        }

        // Extract CONTENT_HTML: everything between CONTENT_HTML: and FAQS: (or end of block)
        if (preg_match('/CONTENT_HTML:\s*\n(.*?)(?=\nFAQS:\s*$|\n={10,})/ms', $block, $m)) {
            $post['content'] = trim($m[1]);
        }

        // Extract FAQs
        if (preg_match('/^FAQS:\s*\n(.*?)(?:\n={10,}|\z)/ms', $block, $m)) {
            $faq_block = trim($m[1]);
            $faq_pairs = preg_split('/^Q:\s*/m', $faq_block, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($faq_pairs as $pair) {
                $pair = trim($pair);
                if (empty($pair)) continue;
                // Split on the A: line
                if (preg_match('/^(.+?)\nA:\s*(.+)$/s', $pair, $fm)) {
                    $question = trim($fm[1]);
                    $answer = trim($fm[2]);
                    if (!empty($question) && !empty($answer)) {
                        $post['faqs'][] = [
                            'question' => $question,
                            'answer'   => $answer,
                        ];
                    }
                }
            }
        }

        $posts[$post_num] = $post;
    }

    return $posts;
}

// Parse all files
$all_posts = [];
$parse_errors = [];

foreach ($source_files as $file) {
    if (!file_exists($file)) {
        $parse_errors[] = "File not found: " . basename($file);
        continue;
    }
    $parsed = parse_blog_posts_file($file);
    if (empty($parsed)) {
        $parse_errors[] = "No posts parsed from: " . basename($file);
    }
    $all_posts += $parsed;
}

// Sort by post number
ksort($all_posts);

// Merge config data into parsed posts
foreach ($all_posts as $num => &$post) {
    if (isset($post_config[$num])) {
        $post['featured_image']     = $post_config[$num]['featured_image'];
        $post['featured_image_alt'] = $post['seo_title'];
        $post['publish_date']       = $post_config[$num]['publish_date'];
        $post['status']             = 'scheduled';
        $post['author']             = 'Griffin Quartz Team';
        $post['og_title']           = $post['seo_title'];
        $post['og_description']     = $post['seo_description'];
        $post['og_image']           = 'https://griffinquartz.com' . $post_config[$num]['featured_image'];
    }
}
unset($post);

// ============================================================
// GET: Show confirmation page
// ============================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Create Scheduled Blog Posts - Batch 2</title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; max-width: 1000px; margin: 30px auto; padding: 0 20px; color: #333; background: #fafafa; }
            h1 { color: #1a1a1a; border-bottom: 3px solid #c9a96e; padding-bottom: 12px; }
            .info-box { background: #e8f4f8; border-left: 4px solid #2196F3; padding: 16px; margin: 20px 0; border-radius: 0 6px 6px 0; }
            .warning-box { background: #fff3cd; border-left: 4px solid #ffc107; padding: 16px; margin: 20px 0; border-radius: 0 6px 6px 0; }
            .error-box { background: #f8d7da; border-left: 4px solid #dc3545; padding: 16px; margin: 20px 0; border-radius: 0 6px 6px 0; }
            table { width: 100%; border-collapse: collapse; margin: 20px 0; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
            th { background: #1a1a1a; color: #fff; padding: 12px 16px; text-align: left; font-weight: 500; }
            td { padding: 10px 16px; border-bottom: 1px solid #e0e0e0; }
            tr:last-child td { border-bottom: none; }
            tr:nth-child(even) { background: #f8f6f0; }
            .btn { display: inline-block; padding: 14px 28px; background: #c9a96e; color: #fff; border: none; cursor: pointer; font-size: 16px; font-weight: 600; border-radius: 6px; text-decoration: none; }
            .btn:hover { background: #b8964f; }
            .btn-back { background: #666; margin-left: 12px; }
            .btn-back:hover { background: #555; }
            .post-num { font-weight: 700; color: #c9a96e; }
            .slug { color: #666; font-family: monospace; font-size: 0.85em; }
            .date { white-space: nowrap; }
            .faq-count { text-align: center; }
            .content-len { text-align: right; font-family: monospace; font-size: 0.85em; color: #666; }
            .status-ok { color: #28a745; font-weight: 600; }
            .status-warn { color: #dc3545; font-weight: 600; }
            .category-label { display: inline-block; font-size: 0.75em; padding: 2px 8px; border-radius: 4px; color: #fff; margin-bottom: 4px; }
            .cat-info { background: #2196F3; }
            .cat-compare { background: #9C27B0; }
            .cat-commercial { background: #FF9800; }
            .cat-location { background: #4CAF50; }
            .cat-specialty { background: #E91E63; }
        </style>
    </head>
    <body>
        <h1>Create Scheduled Blog Posts &mdash; Batch 2 (Posts 23&ndash;50)</h1>

        <div class="info-box">
            <strong>What this does:</strong> Reads 5 text files, parses 28 blog posts, and inserts them into the <code>blog_posts</code> and <code>blog_faqs</code> database tables with status <code>scheduled</code>. Posts auto-publish when their <code>publish_date</code> arrives.<br><br>
            <strong>Schedule:</strong> These posts fill in the off-weeks between Batch 1's biweekly schedule (Apr&ndash;Dec 2026), then continue weekly into Feb 2027 &mdash; achieving <strong>weekly publishing</strong>.
        </div>

        <?php if (!empty($parse_errors)): ?>
            <div class="error-box">
                <strong>Parse Errors:</strong><br>
                <?php foreach ($parse_errors as $err): ?>
                    &bull; <?= htmlspecialchars($err) ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($all_posts)): ?>
            <div class="error-box">
                <strong>No posts found!</strong> Make sure the text files exist in <code>/blog-content/</code>.<br>
                Expected: <code>gq-blog-posts-23-28.txt</code>, <code>gq-blog-posts-29-34.txt</code>, <code>gq-blog-posts-35-40.txt</code>, <code>gq-blog-posts-41-46.txt</code>, <code>gq-blog-posts-47-50.txt</code>
            </div>
        <?php else: ?>
            <p><strong><?= count($all_posts) ?> posts</strong> parsed and ready to import. Existing slugs will be <strong>skipped</strong> (no duplicates).</p>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Publish Date</th>
                        <th>FAQs</th>
                        <th>Content</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_posts as $num => $post):
                        // Determine category label
                        if ($num >= 23 && $num <= 28) { $cat = 'Informational'; $catClass = 'cat-info'; }
                        elseif ($num >= 29 && $num <= 34) { $cat = 'Comparison'; $catClass = 'cat-compare'; }
                        elseif ($num >= 35 && $num <= 40) { $cat = 'Commercial'; $catClass = 'cat-commercial'; }
                        elseif ($num >= 41 && $num <= 46) { $cat = 'Location'; $catClass = 'cat-location'; }
                        else { $cat = 'Specialty'; $catClass = 'cat-specialty'; }
                    ?>
                    <tr>
                        <td class="post-num"><?= $num ?></td>
                        <td><span class="category-label <?= $catClass ?>"><?= $cat ?></span></td>
                        <td><?= htmlspecialchars(mb_strimwidth($post['title'], 0, 50, '...')) ?></td>
                        <td class="slug"><?= htmlspecialchars($post['slug']) ?></td>
                        <td class="date"><?= isset($post['publish_date']) ? date('M j, Y', strtotime($post['publish_date'])) : '<span class="status-warn">Missing</span>' ?></td>
                        <td class="faq-count"><?= count($post['faqs']) ?></td>
                        <td class="content-len"><?= number_format(strlen($post['content'])) ?> chars</td>
                        <td>
                            <?php
                            $ok = !empty($post['slug']) && !empty($post['content']) && !empty($post['seo_title']) && isset($post['publish_date']);
                            echo $ok ? '<span class="status-ok">Ready</span>' : '<span class="status-warn">Issue</span>';
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="post" onsubmit="return confirm('This will insert <?= count($all_posts) ?> scheduled posts into the database. Continue?');">
                <button type="submit" class="btn">Insert <?= count($all_posts) ?> Scheduled Posts</button>
                <a href="/admin/" class="btn btn-back">&larr; Back to Admin</a>
            </form>
        <?php endif; ?>

        <br><a href="/admin/">&larr; Back to Admin</a>
    </body>
    </html>
    <?php
    exit();
}

// ============================================================
// POST: Insert posts into database
// ============================================================

require_once dirname(__DIR__) . '/api/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_BLOG_HOST . ";dbname=" . DB_BLOG_NAME . ";charset=utf8mb4",
        DB_BLOG_USER,
        DB_BLOG_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("<h2 style='color:red;font-family:sans-serif;'>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</h2>");
}

$results = [];
$inserted = 0;
$skipped = 0;
$errors = 0;

// Prepare slug check statement
$check_slug = $pdo->prepare("SELECT id FROM blog_posts WHERE slug = ?");

// Prepare insert statement
$insert_post = $pdo->prepare("
    INSERT INTO blog_posts (
        title, slug, content, excerpt,
        featured_image, featured_image_alt,
        status, publish_date, author,
        seo_title, seo_description, seo_keywords,
        og_title, og_description, og_image,
        created_at, updated_at
    ) VALUES (
        ?, ?, ?, ?,
        ?, ?,
        ?, ?, ?,
        ?, ?, ?,
        ?, ?, ?,
        NOW(), NOW()
    )
");

// Prepare FAQ insert statement
$insert_faq = $pdo->prepare("
    INSERT INTO blog_faqs (post_id, question, answer, sort_order)
    VALUES (?, ?, ?, ?)
");

foreach ($all_posts as $num => $post) {
    $result = [
        'post_number' => $num,
        'title'       => $post['title'],
        'slug'        => $post['slug'],
        'status'      => '',
        'message'     => '',
        'post_id'     => null,
        'faq_count'   => 0,
    ];

    // Validate required fields
    if (empty($post['slug']) || empty($post['content']) || !isset($post['publish_date'])) {
        $result['status'] = 'error';
        $result['message'] = 'Missing required data (slug, content, or publish_date)';
        $results[] = $result;
        $errors++;
        continue;
    }

    // Check if slug already exists
    $check_slug->execute([$post['slug']]);
    if ($check_slug->fetch()) {
        $result['status'] = 'skipped';
        $result['message'] = 'Slug already exists in database';
        $results[] = $result;
        $skipped++;
        continue;
    }

    // Insert the post
    try {
        $pdo->beginTransaction();

        $insert_post->execute([
            $post['title'],
            $post['slug'],
            $post['content'],
            $post['excerpt'],
            $post['featured_image'],
            $post['featured_image_alt'],
            $post['status'],
            $post['publish_date'],
            $post['author'],
            $post['seo_title'],
            $post['seo_description'],
            $post['seo_keywords'],
            $post['og_title'],
            $post['og_description'],
            $post['og_image'],
        ]);

        $post_id = $pdo->lastInsertId();
        $result['post_id'] = $post_id;

        // Insert FAQs
        $faq_count = 0;
        foreach ($post['faqs'] as $idx => $faq) {
            if (!empty($faq['question']) && !empty($faq['answer'])) {
                $insert_faq->execute([
                    $post_id,
                    $faq['question'],
                    $faq['answer'],
                    $idx,
                ]);
                $faq_count++;
            }
        }

        $pdo->commit();

        $result['status'] = 'inserted';
        $result['message'] = "Post ID: {$post_id}, {$faq_count} FAQs";
        $result['faq_count'] = $faq_count;
        $inserted++;

    } catch (Exception $e) {
        $pdo->rollBack();
        $result['status'] = 'error';
        $result['message'] = $e->getMessage();
        $errors++;
    }

    $results[] = $result;
}

// ============================================================
// Display results
// ============================================================
?>
<!DOCTYPE html>
<html>
<head>
    <title>Import Results - Batch 2 Scheduled Blog Posts</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; max-width: 1000px; margin: 30px auto; padding: 0 20px; color: #333; background: #fafafa; }
        h1 { color: #1a1a1a; border-bottom: 3px solid #c9a96e; padding-bottom: 12px; }
        .summary { display: flex; gap: 20px; margin: 20px 0; }
        .summary-box { flex: 1; padding: 20px; border-radius: 8px; text-align: center; }
        .summary-box h2 { margin: 0 0 4px 0; font-size: 2em; }
        .summary-box p { margin: 0; font-size: 0.9em; }
        .bg-success { background: #d4edda; color: #155724; }
        .bg-warning { background: #fff3cd; color: #856404; }
        .bg-danger { background: #f8d7da; color: #721c24; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        th { background: #1a1a1a; color: #fff; padding: 12px 16px; text-align: left; font-weight: 500; }
        td { padding: 10px 16px; border-bottom: 1px solid #e0e0e0; }
        tr:last-child td { border-bottom: none; }
        .status-inserted { color: #28a745; font-weight: 600; }
        .status-skipped { color: #856404; font-weight: 600; }
        .status-error { color: #dc3545; font-weight: 600; }
        .post-num { font-weight: 700; color: #c9a96e; }
        .btn-back { display: inline-block; padding: 12px 24px; background: #666; color: #fff; text-decoration: none; border-radius: 6px; margin-top: 10px; }
        .btn-back:hover { background: #555; }
    </style>
</head>
<body>
    <h1>Batch 2 Import Results</h1>

    <div class="summary">
        <div class="summary-box bg-success">
            <h2><?= $inserted ?></h2>
            <p>Inserted</p>
        </div>
        <div class="summary-box bg-warning">
            <h2><?= $skipped ?></h2>
            <p>Skipped (duplicate)</p>
        </div>
        <div class="summary-box bg-danger">
            <h2><?= $errors ?></h2>
            <p>Errors</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $r): ?>
            <tr>
                <td class="post-num"><?= $r['post_number'] ?></td>
                <td><?= htmlspecialchars(mb_strimwidth($r['title'], 0, 55, '...')) ?></td>
                <td style="font-family:monospace;font-size:0.85em;color:#666;"><?= htmlspecialchars($r['slug']) ?></td>
                <td class="status-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></td>
                <td><?= htmlspecialchars($r['message']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/admin/" class="btn-back">&larr; Back to Admin</a>
    <br><br>
</body>
</html>
<?php
