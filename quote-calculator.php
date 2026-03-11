<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title>Countertop Quote Calculator | Griffin Quartz</title>
    <meta name="description" content="Instant estimate for your quartz countertop project. Enter dimensions and preferences for pricing. Free quotes in South Florida.">
    <meta name="keywords" content="quartz countertop cost calculator, countertop price estimator, quartz pricing South Florida, countertop quote, kitchen countertop cost">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://griffinquartz.com/quote-calculator">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">

    <!-- Open Graph -->
    <meta property="og:title" content="Instant Quartz Countertop Quote Calculator | Griffin Quartz">
    <meta property="og:description" content="Get instant pricing for your quartz countertop project. Enter dimensions and see your estimate in seconds.">
    <meta property="og:url" content="https://griffinquartz.com/quote-calculator">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Instant Quartz Countertop Quote Calculator | Griffin Quartz">
    <meta name="twitter:description" content="Get instant pricing for your quartz countertop project. Enter dimensions and see your estimate in seconds.">
    <meta name="twitter:image" content="https://griffinquartz.com/images/griffin-quartz-showroom.webp">

    <!-- Fonts and Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.min.css">
    <style>
        /* Quote Calculator Enhanced Breakdown Styles */
        .estimate-breakdown {
            margin-top: 20px;
            padding: 16px;
            background: #f8f8f8;
            border-radius: 10px;
            border: 1px solid #e8e8e8;
        }

        .estimate-breakdown.total-section {
            background: #000;
            border: none;
            margin-top: 16px;
        }

        .estimate-breakdown.total-section .breakdown-row {
            border: none;
            padding: 0;
        }

        .estimate-breakdown.total-section .label-main {
            color: #fff;
            font-size: 16px;
        }

        .estimate-breakdown.total-section .label-detail {
            color: #888;
        }

        .estimate-breakdown.total-section #totalCost {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            color: #FDB913;
            font-weight: 700;
        }

        .breakdown-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .breakdown-section-header h4 {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #000;
        }

        .breakdown-section-header h4 i {
            color: #FDB913;
        }

        .section-badge {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .section-badge.variable {
            background: #fff8e6;
            color: #b8860b;
            border: 1px solid #FDB913;
        }

        .section-badge.fixed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .breakdown-note {
            font-size: 12px;
            color: #666;
            margin: 0 0 12px 0;
            padding-bottom: 12px;
            border-bottom: 1px solid #e8e8e8;
        }

        .breakdown-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e8e8e8;
        }

        .breakdown-row:last-child {
            border-bottom: none;
        }

        .breakdown-row.subtotal {
            margin-top: 8px;
            padding-top: 12px;
            border-top: 2px solid #FDB913;
            border-bottom: none;
            font-weight: 700;
        }

        .breakdown-label {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .breakdown-label .label-main {
            font-size: 13px;
            font-weight: 600;
            color: #000;
        }

        .breakdown-label .label-detail {
            font-size: 11px;
            color: #888;
        }

        .breakdown-value {
            font-size: 14px;
            font-weight: 600;
            color: #000;
            text-align: right;
        }

        .breakdown-value.range {
            color: #666;
        }

        .estimate-note {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            padding: 14px;
            background: #fff8e6;
            border-radius: 8px;
            border: 1px solid #FDB913;
        }

        .estimate-note i {
            color: #FDB913;
            font-size: 18px;
            flex-shrink: 0;
        }

        .estimate-note p {
            font-size: 12px;
            color: #666;
            margin: 0;
            line-height: 1.5;
        }

        .estimate-note strong {
            color: #000;
        }
    </style>
</head>
<body>
<?php $basePath = ''; include 'includes/header.php'; ?>

    <!-- Page Hero -->
    <section class="page-hero calculator-hero">
        <div class="container">
            <h1>Instant Quote Calculator</h1>
            <p>Get an estimate for your quartz countertop project in under 60 seconds. Enter your details below.</p>
        </div>
    </section>

    <!-- Calculator Tool -->
    <section class="calculator-section">
        <div class="container">
            <div class="calculator-wrapper">
                <!-- Calculator Form -->
                <div class="calculator-form">
                    <form id="quoteCalculator">
                        <!-- Step 1: Project Type -->
                        <div class="calc-step" data-step="1">
                            <h3><span class="step-number">1</span> What type of project is this?</h3>
                            <div class="option-cards">
                                <label class="option-card">
                                    <input type="radio" name="projectType" value="kitchen" checked>
                                    <div class="option-content">
                                        <i class="bi bi-house-door"></i>
                                        <span>Kitchen</span>
                                    </div>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="projectType" value="bathroom">
                                    <div class="option-content">
                                        <i class="bi bi-droplet"></i>
                                        <span>Bathroom</span>
                                    </div>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="projectType" value="outdoor">
                                    <div class="option-content">
                                        <i class="bi bi-sun"></i>
                                        <span>Outdoor</span>
                                    </div>
                                </label>
                                <label class="option-card">
                                    <input type="radio" name="projectType" value="commercial">
                                    <div class="option-content">
                                        <i class="bi bi-building"></i>
                                        <span>Commercial</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Step 2: Dimensions -->
                        <div class="calc-step" data-step="2">
                            <h3><span class="step-number">2</span> Enter your countertop dimensions</h3>
                            <p class="step-hint">Measure the length and depth of each countertop section. Add multiple sections if needed.</p>

                            <div class="dimension-sections" id="dimensionSections">
                                <div class="dimension-row" data-section="1">
                                    <div class="dimension-label">Section 1</div>
                                    <div class="dimension-inputs">
                                        <div class="input-group">
                                            <label>Length</label>
                                            <div class="input-with-unit">
                                                <input type="number" name="length1" min="1" max="300" value="96" class="calc-input length-input">
                                                <span class="unit">inches</span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <label>Depth</label>
                                            <div class="input-with-unit">
                                                <input type="number" name="depth1" min="1" max="60" value="25" class="calc-input depth-input">
                                                <span class="unit">inches</span>
                                            </div>
                                        </div>
                                        <button type="button" class="remove-section-btn" style="visibility: hidden;"><i class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="add-section-btn" id="addSectionBtn">
                                <i class="bi bi-plus-circle"></i> Add Another Section
                            </button>

                            <div class="total-sqft">
                                <span>Total Square Footage:</span>
                                <strong id="totalSqft">16.7</strong> sq ft
                            </div>
                        </div>

                        <!-- Step 3: Material Grade -->
                        <div class="calc-step" data-step="3">
                            <h3><span class="step-number">3</span> Select your material grade</h3>
                            <p class="step-hint">Material costs vary by color, pattern, and brand. Select a tier to see your estimate range.</p>
                            <div class="grade-options">
                                <label class="grade-option">
                                    <input type="radio" name="grade" value="standard" checked>
                                    <div class="grade-content">
                                        <div class="grade-header">
                                            <span class="grade-name">Entry Level</span>
                                            <span class="grade-price">$40-55/sq ft</span>
                                        </div>
                                        <p>Solid colors and basic patterns. Budget-friendly options perfect for rentals or utility spaces.</p>
                                    </div>
                                </label>
                                <label class="grade-option">
                                    <input type="radio" name="grade" value="premium">
                                    <div class="grade-content">
                                        <div class="grade-header">
                                            <span class="grade-name">Standard-Premium</span>
                                            <span class="grade-price">$55-85/sq ft</span>
                                        </div>
                                        <p>Popular marble-look patterns, Carrara styles, and soft veining. Most popular for kitchens & baths.</p>
                                        <span class="popular-badge">Most Popular</span>
                                    </div>
                                </label>
                                <label class="grade-option">
                                    <input type="radio" name="grade" value="luxury">
                                    <div class="grade-content">
                                        <div class="grade-header">
                                            <span class="grade-name">Designer</span>
                                            <span class="grade-price">$85-150/sq ft</span>
                                        </div>
                                        <p>Calacatta, Statuario, and exotic patterns. Premium brands like Cambria, Silestone, and Caesarstone.</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Step 4: Edge Profile -->
                        <div class="calc-step" data-step="4">
                            <h3><span class="step-number">4</span> Choose your edge profile</h3>
                            <div class="edge-options">
                                <label class="edge-option">
                                    <input type="radio" name="edge" value="eased" checked>
                                    <div class="edge-content">
                                        <div class="edge-visual edge-eased"></div>
                                        <span>Eased</span>
                                        <span class="edge-price">Included</span>
                                    </div>
                                </label>
                                <label class="edge-option">
                                    <input type="radio" name="edge" value="beveled">
                                    <div class="edge-content">
                                        <div class="edge-visual edge-beveled"></div>
                                        <span>Beveled</span>
                                        <span class="edge-price">+$12/ft</span>
                                    </div>
                                </label>
                                <label class="edge-option">
                                    <input type="radio" name="edge" value="bullnose">
                                    <div class="edge-content">
                                        <div class="edge-visual edge-bullnose"></div>
                                        <span>Bullnose</span>
                                        <span class="edge-price">+$18/ft</span>
                                    </div>
                                </label>
                                <label class="edge-option">
                                    <input type="radio" name="edge" value="ogee">
                                    <div class="edge-content">
                                        <div class="edge-visual edge-ogee"></div>
                                        <span>Ogee</span>
                                        <span class="edge-price">+$25/ft</span>
                                    </div>
                                </label>
                                <label class="edge-option">
                                    <input type="radio" name="edge" value="waterfall">
                                    <div class="edge-content">
                                        <div class="edge-visual edge-waterfall"></div>
                                        <span>Waterfall</span>
                                        <span class="edge-price">+$40/ft</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Step 5: Add-ons -->
                        <div class="calc-step" data-step="5">
                            <h3><span class="step-number">5</span> Additional services (optional)</h3>
                            <div class="addon-options">
                                <label class="addon-option">
                                    <input type="checkbox" name="addon" value="sink">
                                    <div class="addon-content">
                                        <i class="bi bi-droplet-half"></i>
                                        <div class="addon-details">
                                            <span class="addon-name">Undermount Sink Cutout</span>
                                            <span class="addon-price">+$195</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="addon-option">
                                    <input type="checkbox" name="addon" value="cooktop">
                                    <div class="addon-content">
                                        <i class="bi bi-fire"></i>
                                        <div class="addon-details">
                                            <span class="addon-name">Cooktop Cutout</span>
                                            <span class="addon-price">+$225</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="addon-option">
                                    <input type="checkbox" name="addon" value="backsplash">
                                    <div class="addon-content">
                                        <i class="bi bi-bricks"></i>
                                        <div class="addon-details">
                                            <span class="addon-name">4" Backsplash Fabrication</span>
                                            <span class="addon-price">+$25/linear ft</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="addon-option">
                                    <input type="checkbox" name="addon" value="removal">
                                    <div class="addon-content">
                                        <i class="bi bi-trash3"></i>
                                        <div class="addon-details">
                                            <span class="addon-name">Old Countertop Removal</span>
                                            <span class="addon-price">+$250</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Quote Result -->
                <div class="calculator-result">
                    <div class="result-card">
                        <h3>Your Estimated Quote</h3>

                        <div class="estimate-display">
                            <div class="estimate-range">
                                <span class="estimate-label">Estimated Total</span>
                                <div class="estimate-values">
                                    <span class="estimate-low" id="estimateLow">$750</span>
                                    <span class="estimate-separator">–</span>
                                    <span class="estimate-high" id="estimateHigh">$1,085</span>
                                </div>
                            </div>
                        </div>

                        <!-- Material Costs Section -->
                        <div class="estimate-breakdown">
                            <div class="breakdown-section-header">
                                <h4><i class="bi bi-gem"></i> Material Costs</h4>
                                <span class="section-badge variable">Variable</span>
                            </div>
                            <p class="breakdown-note">Material pricing varies by color, pattern, and brand selection.</p>
                            <div class="breakdown-row">
                                <div class="breakdown-label">
                                    <span class="label-main">Quartz Material</span>
                                    <span class="label-detail"><span id="sqftDisplay">16.7</span> sq ft × $<span id="matPriceRange">40-150</span>/sf</span>
                                </div>
                                <span class="breakdown-value range" id="materialCost">$668 – $2,505</span>
                            </div>
                            <div class="breakdown-row subtotal">
                                <span>Material Subtotal</span>
                                <span class="breakdown-value range" id="materialSubtotal">$668 – $2,505</span>
                            </div>
                        </div>

                        <!-- Fabrication & Installation Section -->
                        <div class="estimate-breakdown">
                            <div class="breakdown-section-header">
                                <h4><i class="bi bi-tools"></i> Fabrication & Installation</h4>
                                <span class="section-badge fixed">Fixed Rates</span>
                            </div>
                            <p class="breakdown-note">Based on Boca Raton, FL market rates (2025-2026).</p>
                            <div class="breakdown-row">
                                <div class="breakdown-label">
                                    <span class="label-main">Fabrication</span>
                                    <span class="label-detail"><span id="fabSqftDisplay">16.7</span> sq ft × $22/sf</span>
                                </div>
                                <span class="breakdown-value" id="fabCost">$367</span>
                            </div>
                            <div class="breakdown-row">
                                <div class="breakdown-label">
                                    <span class="label-main">Installation</span>
                                    <span class="label-detail"><span id="installSqftDisplay">16.7</span> sq ft × $20/sf</span>
                                </div>
                                <span class="breakdown-value" id="installCost">$334</span>
                            </div>
                            <div class="breakdown-row">
                                <div class="breakdown-label">
                                    <span class="label-main">Edge Profile</span>
                                    <span class="label-detail" id="edgeDetail">Eased (Standard)</span>
                                </div>
                                <span class="breakdown-value" id="edgeCost">Included</span>
                            </div>
                            <div class="breakdown-row" id="addonRow" style="display: none;">
                                <div class="breakdown-label">
                                    <span class="label-main">Add-ons</span>
                                    <span class="label-detail" id="addonDetail">Cutouts, backsplash, etc.</span>
                                </div>
                                <span class="breakdown-value" id="addonCost">$0</span>
                            </div>
                            <div class="breakdown-row subtotal">
                                <span>Fab & Install Subtotal</span>
                                <span class="breakdown-value" id="fabInstallSubtotal">$701</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="estimate-breakdown total-section">
                            <div class="breakdown-row breakdown-total">
                                <div class="breakdown-label">
                                    <span class="label-main">Estimated Project Total</span>
                                    <span class="label-detail">Materials + Fab & Installation</span>
                                </div>
                                <span id="totalCost">$1,369 – $3,206</span>
                            </div>
                        </div>

                        <div class="estimate-note">
                            <i class="bi bi-info-circle"></i>
                            <p><strong>About this estimate:</strong> Material costs vary significantly ($40-$150/sf) based on your color and brand choice. Entry-level solid colors are ~$40/sf while premium Calacatta patterns reach $150/sf. Fabrication & installation rates are fixed based on Boca Raton market pricing.</p>
                        </div>

                        <div class="result-actions">
                            <a href="tel:+17203241436" class="btn btn-primary btn-block">
                                <i class="bi bi-telephone"></i> Call for Exact Quote
                            </a>
                            <button type="button" class="btn btn-outline btn-block" id="emailQuoteBtn">
                                <i class="bi bi-envelope"></i> Email This Quote
                            </button>
                        </div>

                        <div class="result-trust">
                            <div class="trust-item">
                                <i class="bi bi-shield-check"></i>
                                <span>Price Match Guarantee</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-calendar-check"></i>
                                <span>1-Week Installation</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-award"></i>
                                <span>Lifetime Warranty</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="calculator-benefits">
        <div class="container">
            <h2>Why Griffin Quartz for Your Project?</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <i class="bi bi-piggy-bank"></i>
                    <h3>Factory-Direct Pricing</h3>
                    <p>We cut out the middleman and pass the savings to you. Up to 50% off retail prices.</p>
                </div>
                <div class="benefit-card">
                    <i class="bi bi-truck"></i>
                    <h3>Free Delivery & Install</h3>
                    <p>No hidden fees. Your quote includes delivery, fabrication, and professional installation.</p>
                </div>
                <div class="benefit-card">
                    <i class="bi bi-clock-history"></i>
                    <h3>Fast Turnaround</h3>
                    <p>From measurement to installation in as little as one week. We respect your time.</p>
                </div>
                <div class="benefit-card">
                    <i class="bi bi-star"></i>
                    <h3>5-Star Service</h3>
                    <p>100+ five-star reviews from happy customers across South Florida.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    <script>
    // Quote Calculator functionality
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('quoteCalculator');
        let sectionCount = 1;

        // =========================================================
        // Pricing Data - Boca Raton, FL Market Rates (2025-2026)
        // =========================================================
        // Material costs vary by grade/brand - shown as range
        // Fabrication & Installation are fixed rates
        const pricing = {
            // Material grades (per sq ft) - VARIABLE
            grades: {
                standard: { low: 40, high: 55, label: 'Entry Level' },    // Solid colors, basic patterns
                premium: { low: 55, high: 85, label: 'Standard-Premium' }, // Popular colors, subtle veining
                luxury: { low: 85, high: 150, label: 'Designer' }          // Calacatta, exotic patterns
            },
            // Fabrication & Installation (per sq ft) - FIXED
            fabrication: 22,    // Template, CNC cutting, edge work, polish
            installation: 20,   // Delivery, setup, seaming, caulk
            // Edge profiles (per linear ft) - FIXED
            edges: {
                eased: { price: 0, label: 'Eased (Standard)' },
                beveled: { price: 12, label: 'Beveled (+$12/lf)' },
                bullnose: { price: 18, label: 'Bullnose (+$18/lf)' },
                ogee: { price: 25, label: 'Ogee (+$25/lf)' },
                waterfall: { price: 40, label: 'Waterfall (+$40/lf)' }
            },
            // Add-ons - FIXED
            addons: {
                sink: 195,        // Undermount sink cutout
                cooktop: 225,     // Cooktop cutout
                backsplash: 25,   // Per linear ft (fab cost)
                removal: 250      // Old countertop removal
            }
        };

        // Calculate and update quote
        function updateQuote() {
            // Get total square footage
            let totalSqft = 0;
            let totalLinearFt = 0;

            document.querySelectorAll('.dimension-row').forEach(row => {
                const length = parseFloat(row.querySelector('.length-input').value) || 0;
                const depth = parseFloat(row.querySelector('.depth-input').value) || 0;
                const sqft = (length * depth) / 144;
                totalSqft += sqft;
                totalLinearFt += length / 12;
            });

            // Get selected grade
            const grade = document.querySelector('input[name="grade"]:checked').value;
            const gradePrice = pricing.grades[grade];

            // Get selected edge
            const edge = document.querySelector('input[name="edge"]:checked').value;
            const edgeData = pricing.edges[edge];

            // Get addons
            let addonTotal = 0;
            let addonDetails = [];
            document.querySelectorAll('input[name="addon"]:checked').forEach(addon => {
                if (addon.value === 'backsplash') {
                    const bsCost = Math.round(pricing.addons[addon.value] * totalLinearFt);
                    addonTotal += bsCost;
                    addonDetails.push('Backsplash');
                } else {
                    addonTotal += pricing.addons[addon.value];
                    if (addon.value === 'sink') addonDetails.push('Sink cutout');
                    if (addon.value === 'cooktop') addonDetails.push('Cooktop cutout');
                    if (addon.value === 'removal') addonDetails.push('Removal');
                }
            });

            // === MATERIAL COSTS (Variable Range) ===
            const materialLow = Math.round(totalSqft * gradePrice.low);
            const materialHigh = Math.round(totalSqft * gradePrice.high);

            // === FABRICATION & INSTALLATION (Fixed) ===
            const fabCost = Math.round(totalSqft * pricing.fabrication);
            const installCost = Math.round(totalSqft * pricing.installation);
            const edgeCost = Math.round(totalLinearFt * edgeData.price);
            const fabInstallSubtotal = fabCost + installCost + edgeCost + addonTotal;

            // === GRAND TOTALS ===
            const totalLow = materialLow + fabInstallSubtotal;
            const totalHigh = materialHigh + fabInstallSubtotal;

            // === UPDATE DISPLAY ===

            // Square footage displays
            document.getElementById('totalSqft').textContent = totalSqft.toFixed(1);
            document.getElementById('sqftDisplay').textContent = totalSqft.toFixed(1);
            document.getElementById('fabSqftDisplay').textContent = totalSqft.toFixed(1);
            document.getElementById('installSqftDisplay').textContent = totalSqft.toFixed(1);

            // Material price range indicator
            document.getElementById('matPriceRange').textContent = gradePrice.low + '-' + gradePrice.high;

            // Main estimate display
            document.getElementById('estimateLow').textContent = '$' + totalLow.toLocaleString();
            document.getElementById('estimateHigh').textContent = '$' + totalHigh.toLocaleString();

            // Material costs
            document.getElementById('materialCost').textContent = '$' + materialLow.toLocaleString() + ' – $' + materialHigh.toLocaleString();
            document.getElementById('materialSubtotal').textContent = '$' + materialLow.toLocaleString() + ' – $' + materialHigh.toLocaleString();

            // Fab & Install costs
            document.getElementById('fabCost').textContent = '$' + fabCost.toLocaleString();
            document.getElementById('installCost').textContent = '$' + installCost.toLocaleString();

            // Edge profile
            document.getElementById('edgeDetail').textContent = edgeData.label;
            if (edgeCost > 0) {
                document.getElementById('edgeCost').textContent = '+$' + edgeCost.toLocaleString();
            } else {
                document.getElementById('edgeCost').textContent = 'Included';
            }

            // Add-ons
            const addonRow = document.getElementById('addonRow');
            if (addonTotal > 0) {
                addonRow.style.display = 'flex';
                document.getElementById('addonDetail').textContent = addonDetails.join(', ');
                document.getElementById('addonCost').textContent = '+$' + addonTotal.toLocaleString();
            } else {
                addonRow.style.display = 'none';
            }

            // Fab & Install subtotal
            document.getElementById('fabInstallSubtotal').textContent = '$' + fabInstallSubtotal.toLocaleString();

            // Grand total
            document.getElementById('totalCost').textContent = '$' + totalLow.toLocaleString() + ' – $' + totalHigh.toLocaleString();
        }

        // Add section button
        document.getElementById('addSectionBtn').addEventListener('click', function() {
            sectionCount++;
            const newSection = document.createElement('div');
            newSection.className = 'dimension-row';
            newSection.dataset.section = sectionCount;
            newSection.innerHTML = `
                <div class="dimension-label">Section ${sectionCount}</div>
                <div class="dimension-inputs">
                    <div class="input-group">
                        <label>Length</label>
                        <div class="input-with-unit">
                            <input type="number" name="length${sectionCount}" min="1" max="300" value="48" class="calc-input length-input">
                            <span class="unit">inches</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Depth</label>
                        <div class="input-with-unit">
                            <input type="number" name="depth${sectionCount}" min="1" max="60" value="25" class="calc-input depth-input">
                            <span class="unit">inches</span>
                        </div>
                    </div>
                    <button type="button" class="remove-section-btn"><i class="bi bi-x-circle"></i></button>
                </div>
            `;

            document.getElementById('dimensionSections').appendChild(newSection);

            // Add remove functionality
            newSection.querySelector('.remove-section-btn').addEventListener('click', function() {
                newSection.remove();
                updateQuote();
            });

            // Add input listeners
            newSection.querySelectorAll('.calc-input').forEach(input => {
                input.addEventListener('input', updateQuote);
            });

            updateQuote();
        });

        // Listen for changes
        form.addEventListener('change', updateQuote);
        form.addEventListener('input', updateQuote);

        // Email quote button
        document.getElementById('emailQuoteBtn').addEventListener('click', function() {
            const totalSqft = document.getElementById('totalSqft').textContent;
            const estimateLow = document.getElementById('estimateLow').textContent;
            const estimateHigh = document.getElementById('estimateHigh').textContent;

            const subject = encodeURIComponent('Quote Request from Website Calculator');
            const body = encodeURIComponent(`Hi Griffin Quartz,

I used your online quote calculator and got an estimate of ${estimateLow} - ${estimateHigh} for approximately ${totalSqft} sq ft of quartz countertops.

I would like to schedule a free in-home consultation to get an exact quote.

Please contact me at your earliest convenience.

Thank you!`);

            window.location.href = `mailto:info@griffinquartz.com?subject=${subject}&body=${body}`;
        });

        // Initial calculation
        updateQuote();
    });
    </script>
</body>
</html>
