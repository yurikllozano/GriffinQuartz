<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title>Quartz Color Visualizer & Design Studio | Griffin Quartz</title>
    <meta name="description" content="Interactive quartz color visualizer and wall color palette tool. See how countertops look in real spaces. Serving South Florida.">
    <meta name="keywords" content="quartz color visualizer, countertop color picker, wall color palette, kitchen design tool, quartz colors South Florida">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://griffinquartz.com/color-visualizer">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Quartz Color Visualizer & Design Studio | Griffin Quartz">
    <meta name="twitter:description" content="Interactive quartz color visualizer and wall color palette tool. See how countertops look in real spaces. Serving South Florida.">
    <meta name="twitter:image" content="https://griffinquartz.com/images/griffin-quartz-showroom.webp">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">

    <!-- Fonts and Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.min.css">
</head>
<body>
<?php $basePath = ''; include 'includes/header.php'; ?>

    <!-- Page Hero -->
    <section class="page-hero visualizer-hero">
        <div class="container">
            <h1>Design Studio</h1>
            <p>Your complete toolkit for designing the perfect countertop space</p>
        </div>
    </section>

    <!-- SECTION 1: Quartz Color Explorer -->
    <section class="studio-section" id="colorExplorer">
        <div class="container">
            <div class="section-header-fancy">
                <span class="section-number">01</span>
                <div class="section-header-content">
                    <h2>Quartz Color Explorer</h2>
                    <p>Select a color to visualize how it looks in real spaces. Filter by room type or category to find your perfect match.</p>
                </div>
            </div>

            <div class="explorer-layout">
                <!-- Left: Preview Area -->
                <div class="explorer-preview">
                    <!-- Pantone Style Card Overlaid -->
                    <div class="preview-container">
                        <div class="inspiration-photo-large">
                            <img src="images/luxury-white-kitchen-arched-windows-gold.webp" alt="Inspiration photo" id="inspirationImg" width="800" height="800" loading="lazy">
                        </div>
                        <div class="pantone-card-overlay" id="pantoneCard">
                            <div class="pantone-swatch" id="pantoneSwatch" style="background: #F8F8F8;"></div>
                            <div class="pantone-label">
                                <span class="pantone-name" id="pantoneName">Arctic White</span>
                                <span class="pantone-collection" id="pantoneCollection">White Collection</span>
                            </div>
                        </div>
                    </div>

                    <!-- Room Type Filter -->
                    <div class="room-filter-bar">
                        <span class="filter-label">View in:</span>
                        <div class="room-filter-btns">
                            <button class="room-btn active" data-room="all"><i class="bi bi-grid-3x3-gap"></i> All Rooms</button>
                            <button class="room-btn" data-room="kitchen"><i class="bi bi-cup-hot"></i> Kitchen</button>
                            <button class="room-btn" data-room="bathroom"><i class="bi bi-droplet"></i> Bathroom</button>
                            <button class="room-btn" data-room="outdoor"><i class="bi bi-sun"></i> Outdoor</button>
                        </div>
                    </div>
                </div>

                <!-- Right: Color Selection -->
                <div class="color-selector-panel">
                    <div class="selector-header">
                        <h3>Choose Your Quartz Color</h3>
                        <div class="category-filter">
                            <button class="cat-btn active" data-cat="all">All</button>
                            <button class="cat-btn" data-cat="white">Whites</button>
                            <button class="cat-btn" data-cat="marble">Marbles</button>
                            <button class="cat-btn" data-cat="dark">Darks</button>
                            <button class="cat-btn" data-cat="warm">Warm</button>
                        </div>
                    </div>

                    <div class="color-grid" id="swatchGrid">
                        <!-- White Collection -->
                        <div class="color-chip active" data-cat="white" data-name="Arctic White" data-collection="White Collection" data-color="#F8F8F8" data-img="images/luxury-white-kitchen-arched-windows-gold.webp" data-room="kitchen" data-imgs='{"kitchen":"images/luxury-white-kitchen-arched-windows-gold.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/outdoor-kitchen-white-marble-waterfall-modern.webp"}'>
                            <div class="chip-color" style="background: #F8F8F8;"></div>
                            <span class="chip-name">Arctic White</span>
                        </div>
                        <div class="color-chip" data-cat="white" data-name="Pure Snow" data-collection="White Collection" data-color="#FAFAFA" data-img="images/outdoor-kitchen-white-marble-waterfall-modern.webp" data-room="outdoor" data-imgs='{"kitchen":"images/coastal-kitchen-marble-island-coffered-ceiling.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/outdoor-kitchen-white-marble-waterfall-modern.webp"}'>
                            <div class="chip-color" style="background: #FAFAFA;"></div>
                            <span class="chip-name">Pure Snow</span>
                        </div>
                        <div class="color-chip" data-cat="white" data-name="Frost" data-collection="White Collection" data-color="#F0EDE8" data-img="images/coastal-kitchen-marble-island-coffered-ceiling.webp" data-room="kitchen" data-imgs='{"kitchen":"images/coastal-kitchen-marble-island-coffered-ceiling.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/covered-patio-white-marble-island-pool.webp"}'>
                            <div class="chip-color" style="background: #F0EDE8;"></div>
                            <span class="chip-name">Frost</span>
                        </div>

                        <!-- Marble Collection -->
                        <div class="color-chip" data-cat="marble" data-name="Calacatta Luxe" data-collection="Marble Collection" data-color="linear-gradient(135deg, #F5F3F0 0%, #E8E4DF 50%, #D5CFC7 100%)" data-img="images/modern-kitchen-marble-island-glass-pendants.webp" data-room="kitchen" data-imgs='{"kitchen":"images/modern-kitchen-marble-island-glass-pendants.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/outdoor-kitchen-marble-fireplace-pool.webp"}'>
                            <div class="chip-color" style="background: linear-gradient(135deg, #F5F3F0 0%, #E8E4DF 50%, #D5CFC7 100%);"></div>
                            <span class="chip-name">Calacatta Luxe</span>
                        </div>
                        <div class="color-chip" data-cat="marble" data-name="Carrara Mist" data-collection="Marble Collection" data-color="linear-gradient(120deg, #F0EEEB 0%, #E0DCD6 50%, #D0CBC4 100%)" data-img="images/covered-patio-white-marble-island-pool.webp" data-room="outdoor" data-imgs='{"kitchen":"images/mediterranean-kitchen-quartz-arched-window.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/covered-patio-white-marble-island-pool.webp"}'>
                            <div class="chip-color" style="background: linear-gradient(120deg, #F0EEEB 0%, #E0DCD6 50%, #D0CBC4 100%);"></div>
                            <span class="chip-name">Carrara Mist</span>
                        </div>
                        <div class="color-chip" data-cat="marble" data-name="Statuario" data-collection="Marble Collection" data-color="linear-gradient(145deg, #EAE7E3 0%, #D8D3CC 50%, #C5BFB5 100%)" data-img="images/outdoor-kitchen-marble-fireplace-pool.webp" data-room="outdoor" data-imgs='{"kitchen":"images/modern-kitchen-marble-island-glass-pendants.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/outdoor-kitchen-marble-fireplace-pool.webp"}'>
                            <div class="chip-color" style="background: linear-gradient(145deg, #EAE7E3 0%, #D8D3CC 50%, #C5BFB5 100%);"></div>
                            <span class="chip-name">Statuario</span>
                        </div>
                        <div class="color-chip" data-cat="marble" data-name="Calacatta Gold" data-collection="Marble Collection" data-color="linear-gradient(130deg, #F5F0E8 0%, #E8DFD0 50%, #D4C5A8 100%)" data-img="images/mediterranean-kitchen-quartz-arched-window.webp" data-room="kitchen" data-imgs='{"kitchen":"images/mediterranean-kitchen-quartz-arched-window.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/mediterranean-outdoor-kitchen-stone-arches.webp"}'>
                            <div class="chip-color" style="background: linear-gradient(130deg, #F5F0E8 0%, #E8DFD0 50%, #D4C5A8 100%);"></div>
                            <span class="chip-name">Calacatta Gold</span>
                        </div>

                        <!-- Dark Collection -->
                        <div class="color-chip" data-cat="dark" data-name="Midnight Black" data-collection="Dark Collection" data-color="linear-gradient(135deg, #1A1A1A 0%, #2D2D2D 50%, #1A1A1A 100%)" data-img="images/luxury-bathroom-black-marble-gold-fixtures.webp" data-room="bathroom" data-imgs='{"kitchen":"images/industrial-loft-kitchen-brick-quartz-island.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/backyard-outdoor-kitchen-firepit-evening.webp"}'>
                            <div class="chip-color" style="background: linear-gradient(135deg, #1A1A1A 0%, #2D2D2D 50%, #1A1A1A 100%);"></div>
                            <span class="chip-name">Midnight Black</span>
                        </div>
                        <div class="color-chip" data-cat="dark" data-name="Charcoal" data-collection="Dark Collection" data-color="#3D3D3D" data-img="images/industrial-loft-kitchen-brick-quartz-island.webp" data-room="kitchen" data-imgs='{"kitchen":"images/industrial-loft-kitchen-brick-quartz-island.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/modern-outdoor-kitchen-quartz-firepit.webp"}'>
                            <div class="chip-color" style="background: #3D3D3D;"></div>
                            <span class="chip-name">Charcoal</span>
                        </div>
                        <div class="color-chip" data-cat="dark" data-name="Storm Gray" data-collection="Dark Collection" data-color="linear-gradient(135deg, #6B6B6B 0%, #4A4A4A 50%, #5A5A5A 100%)" data-img="images/modern-kitchen-gray-quartz-wood-slats.webp" data-room="kitchen" data-imgs='{"kitchen":"images/modern-kitchen-gray-quartz-wood-slats.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/rooftop-outdoor-kitchen-sunset-skyline.webp"}'>
                            <div class="chip-color" style="background: linear-gradient(135deg, #6B6B6B 0%, #4A4A4A 50%, #5A5A5A 100%);"></div>
                            <span class="chip-name">Storm Gray</span>
                        </div>

                        <!-- Warm Collection -->
                        <div class="color-chip" data-cat="warm" data-name="Sahara Beige" data-collection="Warm Collection" data-color="#D4C4B0" data-img="images/mediterranean-outdoor-kitchen-stone-arches.webp" data-room="outdoor" data-imgs='{"kitchen":"images/mediterranean-kitchen-quartz-arched-window.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/mediterranean-outdoor-kitchen-stone-arches.webp"}'>
                            <div class="chip-color" style="background: #D4C4B0;"></div>
                            <span class="chip-name">Sahara Beige</span>
                        </div>
                        <div class="color-chip" data-cat="warm" data-name="Cafe Brown" data-collection="Warm Collection" data-color="#A08060" data-img="images/backyard-outdoor-kitchen-firepit-evening.webp" data-room="outdoor" data-imgs='{"kitchen":"images/industrial-loft-kitchen-brick-quartz-island.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/backyard-outdoor-kitchen-firepit-evening.webp"}'>
                            <div class="chip-color" style="background: #A08060;"></div>
                            <span class="chip-name">Cafe Brown</span>
                        </div>
                        <div class="color-chip" data-cat="warm" data-name="Ivory Coast" data-collection="Warm Collection" data-color="#EAE0D0" data-img="images/rooftop-outdoor-kitchen-sunset-skyline.webp" data-room="outdoor" data-imgs='{"kitchen":"images/coastal-kitchen-marble-island-coffered-ceiling.webp","bathroom":"images/luxury-bathroom-black-marble-gold-fixtures.webp","outdoor":"images/rooftop-outdoor-kitchen-sunset-skyline.webp"}'>
                            <div class="chip-color" style="background: #EAE0D0;"></div>
                            <span class="chip-name">Ivory Coast</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: Compare Colors -->
    <section class="studio-section studio-section-alt" id="compareSection">
        <div class="container">
            <div class="section-header-fancy">
                <span class="section-number">02</span>
                <div class="section-header-content">
                    <h2>Compare Colors Side-by-Side</h2>
                    <p>Can't decide between a few favorites? Select up to 3 colors to compare them side by side and find your perfect match.</p>
                </div>
            </div>

            <div class="compare-tool">
                <div class="compare-instruction">
                    <i class="bi bi-hand-index"></i>
                    <span>Click on colors below to add them to comparison</span>
                </div>

                <div class="compare-display">
                    <div class="compare-card" id="compareCard1">
                        <div class="compare-swatch empty">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <span class="compare-label">Color 1</span>
                        <button class="remove-btn" style="display: none;"><i class="bi bi-x"></i></button>
                    </div>
                    <div class="compare-card" id="compareCard2">
                        <div class="compare-swatch empty">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <span class="compare-label">Color 2</span>
                        <button class="remove-btn" style="display: none;"><i class="bi bi-x"></i></button>
                    </div>
                    <div class="compare-card" id="compareCard3">
                        <div class="compare-swatch empty">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <span class="compare-label">Color 3</span>
                        <button class="remove-btn" style="display: none;"><i class="bi bi-x"></i></button>
                    </div>
                </div>

                <div class="compare-color-picker">
                    <div class="picker-grid" id="comparePickerGrid">
                        <!-- Colors will be dynamically populated from the main grid -->
                    </div>
                </div>

                <div class="compare-actions">
                    <button class="btn btn-outline" id="clearCompareBtn"><i class="bi bi-arrow-counterclockwise"></i> Clear All</button>
                    <button class="btn btn-primary" id="shareCompareBtn"><i class="bi bi-share"></i> Share Selection</button>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: Quick Price Estimator -->
    <section class="studio-section" id="estimatorSection">
        <div class="container">
            <div class="section-header-fancy">
                <span class="section-number">03</span>
                <div class="section-header-content">
                    <h2>Quick Price Estimator</h2>
                    <p>Get an instant ballpark estimate for your countertop project. Enter your dimensions and see estimated pricing.</p>
                </div>
            </div>

            <div class="estimator-tool">
                <div class="estimator-card">
                    <div class="estimator-icon">
                        <i class="bi bi-calculator"></i>
                    </div>
                    <h3>Enter Your Countertop Dimensions</h3>

                    <div class="estimator-inputs">
                        <div class="dimension-group">
                            <label for="estLength">Length</label>
                            <div class="input-with-unit">
                                <input type="number" id="estLength" placeholder="10" min="1" max="100">
                                <span class="unit">ft</span>
                            </div>
                        </div>
                        <div class="dimension-multiply">
                            <i class="bi bi-x-lg"></i>
                        </div>
                        <div class="dimension-group">
                            <label for="estWidth">Width (Depth)</label>
                            <div class="input-with-unit">
                                <input type="number" id="estWidth" placeholder="2" min="1" max="10">
                                <span class="unit">ft</span>
                            </div>
                        </div>
                    </div>

                    <div class="estimator-result" id="estimatorResult">
                        <div class="result-placeholder">
                            <i class="bi bi-arrow-up-circle"></i>
                            <span>Enter dimensions above to see estimate</span>
                        </div>
                    </div>

                    <div class="estimator-note">
                        <i class="bi bi-info-circle"></i>
                        <p>Estimates based on typical quartz pricing ($55-$95/sq ft). Final pricing depends on edge profile, cutouts, and quartz selection.</p>
                    </div>

                    <a href="quote-calculator" class="btn btn-primary btn-full">
                        <i class="bi bi-calculator"></i> Get Detailed Quote
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: Request Free Samples -->
    <section class="studio-section studio-section-alt" id="samplesSection">
        <div class="container">
            <div class="section-header-fancy">
                <span class="section-number">04</span>
                <div class="section-header-content">
                    <h2>Free At-Home Consultation</h2>
                    <p>See and feel the quartz in person. Select up to 3 samples and one of our stone experts will bring them directly to your home for a free consultation.</p>
                </div>
            </div>

            <div class="samples-tool">
                <div class="samples-layout">
                    <!-- Selected Samples Display -->
                    <div class="samples-selection">
                        <h3><i class="bi bi-gem"></i> Your Selected Samples</h3>
                        <div class="samples-chips" id="sampleChipsDisplay">
                            <p class="no-samples">Click colors below to select samples (up to 3)</p>
                        </div>
                        <div class="samples-picker">
                            <h4>Choose Your Samples:</h4>
                            <div class="picker-mini-grid" id="samplePickerGrid">
                                <!-- Mini color picker -->
                            </div>
                        </div>
                        <div class="consult-benefits">
                            <div class="benefit-item">
                                <i class="bi bi-house-door"></i>
                                <span>In-home viewing</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-person-badge"></i>
                                <span>Expert guidance</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-cash-stack"></i>
                                <span>Free estimate</span>
                            </div>
                        </div>
                    </div>

                    <!-- Request Form -->
                    <div class="samples-form-card">
                        <h3><i class="bi bi-calendar-check"></i> Schedule Your Free Consultation</h3>
                        <p class="form-subtitle">A stone expert will contact you to schedule a convenient time to visit your home with your selected samples.</p>
                        <form class="samples-request-form" id="samplesForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="sampleName">Full Name *</label>
                                    <input type="text" id="sampleName" required>
                                </div>
                                <div class="form-group">
                                    <label for="samplePhone">Phone *</label>
                                    <input type="tel" id="samplePhone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sampleEmail">Email *</label>
                                <input type="email" id="sampleEmail" required>
                            </div>
                            <div class="form-group">
                                <label for="sampleAddress">Home Address (Optional)</label>
                                <input type="text" id="sampleAddress" placeholder="Street address for consultation visit">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="sampleCity">City *</label>
                                    <input type="text" id="sampleCity" placeholder="e.g., Boca Raton" required>
                                </div>
                                <div class="form-group">
                                    <label for="sampleZip">ZIP Code *</label>
                                    <input type="text" id="sampleZip" placeholder="e.g., 33487" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sampleNotes">Project Details (Optional)</label>
                                <input type="text" id="sampleNotes" placeholder="e.g., Kitchen remodel, ~30 sq ft">
                            </div>
                            <div class="service-area-note">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Free consultations available throughout <strong>South Florida</strong> including Boca Raton, Fort Lauderdale, Miami, West Palm Beach, and surrounding areas.</span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-full" id="submitSamplesBtn">
                                <i class="bi bi-calendar-plus"></i> Request Free Consultation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: Wall Color Palette Studio -->
    <section class="studio-section" id="paletteSection">
        <div class="container">
            <div class="section-header-fancy">
                <span class="section-number">05</span>
                <div class="section-header-content">
                    <h2>Wall Color Palette Studio</h2>
                    <p>Your new quartz countertops deserve the perfect backdrop. Explore curated wall color palettes designed to complement your stone.</p>
                </div>
            </div>

            <!-- Room Palettes Grid -->
            <div class="palette-rooms-grid">
                <!-- Room 1 -->
                <div class="palette-room-card">
                    <div class="room-image-wrap">
                        <img src="images/luxury-white-kitchen-arched-windows-gold.webp" alt="Modern Elegance Kitchen" width="800" height="800" loading="lazy">
                        <div class="room-style-tag">Modern Elegance</div>
                    </div>
                    <div class="room-palette-bar">
                        <div class="palette-dot" style="background: #F5F3EF;" data-name="Alabaster"></div>
                        <div class="palette-dot" style="background: #E8E3DA;" data-name="Swiss Coffee"></div>
                        <div class="palette-dot" style="background: #D4C9B9;" data-name="Accessible Beige"></div>
                        <div class="palette-dot" style="background: #C2B9A7;" data-name="Balanced Beige"></div>
                        <div class="palette-dot" style="background: #9C8E7C;" data-name="Virtual Taupe"></div>
                    </div>
                    <p class="palette-tip-text">Warm neutrals complement white quartz beautifully</p>
                </div>

                <!-- Room 2 -->
                <div class="palette-room-card">
                    <div class="room-image-wrap">
                        <img src="images/luxury-bathroom-black-marble-gold-fixtures.webp" alt="Dramatic Spa Bathroom" width="800" height="800" loading="lazy">
                        <div class="room-style-tag">Dramatic Spa</div>
                    </div>
                    <div class="room-palette-bar">
                        <div class="palette-dot" style="background: #2C3E50;" data-name="Naval"></div>
                        <div class="palette-dot" style="background: #4A4A4A;" data-name="Iron Ore"></div>
                        <div class="palette-dot" style="background: #3D4F4F;" data-name="Dark Night"></div>
                        <div class="palette-dot" style="background: #5C5D5E;" data-name="Peppercorn"></div>
                        <div class="palette-dot" style="background: #D4AF37;" data-name="Auric Gold"></div>
                    </div>
                    <p class="palette-tip-text">Bold colors create a luxurious spa atmosphere</p>
                </div>

                <!-- Room 3 -->
                <div class="palette-room-card">
                    <div class="room-image-wrap">
                        <img src="images/coastal-kitchen-marble-island-coffered-ceiling.webp" alt="Coastal Retreat Kitchen" width="800" height="603" loading="lazy">
                        <div class="room-style-tag">Coastal Retreat</div>
                    </div>
                    <div class="room-palette-bar">
                        <div class="palette-dot" style="background: #E0EBE8;" data-name="Sea Salt"></div>
                        <div class="palette-dot" style="background: #B8D4E3;" data-name="Watery"></div>
                        <div class="palette-dot" style="background: #6B9AC4;" data-name="Denim"></div>
                        <div class="palette-dot" style="background: #537B9D;" data-name="Smoky Blue"></div>
                        <div class="palette-dot" style="background: #FFFFFF;" data-name="Pure White"></div>
                    </div>
                    <p class="palette-tip-text">Ocean blues bring beach vibes indoors</p>
                </div>

                <!-- Room 4 -->
                <div class="palette-room-card">
                    <div class="room-image-wrap">
                        <img src="images/mediterranean-kitchen-quartz-arched-window.webp" alt="Mediterranean Villa Kitchen" width="800" height="800" loading="lazy">
                        <div class="room-style-tag">Mediterranean Villa</div>
                    </div>
                    <div class="room-palette-bar">
                        <div class="palette-dot" style="background: #F5E6D3;" data-name="Creamy"></div>
                        <div class="palette-dot" style="background: #D9C5A0;" data-name="Whole Wheat"></div>
                        <div class="palette-dot" style="background: #C4A77D;" data-name="Camel"></div>
                        <div class="palette-dot" style="background: #8B7355;" data-name="Toasted Pine Nut"></div>
                        <div class="palette-dot" style="background: #6B4423;" data-name="Terracotta"></div>
                    </div>
                    <p class="palette-tip-text">Earth tones create welcoming warmth</p>
                </div>

                <!-- Room 5 -->
                <div class="palette-room-card">
                    <div class="room-image-wrap">
                        <img src="images/outdoor-kitchen-white-marble-waterfall-modern.webp" alt="Outdoor Oasis" width="800" height="800" loading="lazy">
                        <div class="room-style-tag">Outdoor Oasis</div>
                    </div>
                    <div class="room-palette-bar">
                        <div class="palette-dot" style="background: #87A96B;" data-name="Asparagus"></div>
                        <div class="palette-dot" style="background: #4F7942;" data-name="Fern"></div>
                        <div class="palette-dot" style="background: #8FBC8F;" data-name="Sage"></div>
                        <div class="palette-dot" style="background: #C4B7A6;" data-name="Stone"></div>
                        <div class="palette-dot" style="background: #36454F;" data-name="Charcoal"></div>
                    </div>
                    <p class="palette-tip-text">Natural greens blend with outdoor spaces</p>
                </div>
            </div>

            <!-- My Palette Builder -->
            <div class="my-palette-builder">
                <h3>My Color Palette</h3>
                <p>Click any color above to add it to your palette</p>
                <div class="palette-slots">
                    <div class="palette-slot" id="slot1">
                        <span class="slot-label">Wall</span>
                        <span class="slot-hex">#F5F3EF</span>
                    </div>
                    <div class="palette-slot" id="slot2">
                        <span class="slot-label">Trim</span>
                        <span class="slot-hex">#FFFFFF</span>
                    </div>
                    <div class="palette-slot" id="slot3">
                        <span class="slot-label">Accent</span>
                        <span class="slot-hex">#D4C9B9</span>
                    </div>
                </div>
                <div class="palette-actions">
                    <button class="btn btn-outline" id="resetPaletteBtn"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                    <button class="btn btn-primary" id="copyPaletteBtn"><i class="bi bi-clipboard"></i> Copy Palette</button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="page-cta">
        <div class="container">
            <h2>Ready to Bring Your Vision to Life?</h2>
            <p>Our design experts can help you choose the perfect quartz and wall colors for your space.</p>
            <div class="cta-buttons">
                <a href="tel:+17203241436" class="btn btn-primary"><i class="bi bi-telephone"></i> Call (720) 324-1436</a>
                <a href="quote-calculator" class="btn btn-outline">Get Instant Quote</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== State Management =====
        let selectedColor = null;
        let currentRoomFilter = 'all';
        let compareColors = [];
        let sampleColors = [];

        // ===== DOM Elements =====
        const chips = document.querySelectorAll('.color-chip');
        const pantoneSwatch = document.getElementById('pantoneSwatch');
        const pantoneName = document.getElementById('pantoneName');
        const pantoneCollection = document.getElementById('pantoneCollection');
        const inspirationImg = document.getElementById('inspirationImg');
        const catBtns = document.querySelectorAll('.cat-btn');
        const roomBtns = document.querySelectorAll('.room-btn');

        // ===== SECTION 1: Color Explorer =====

        // Initialize with first active chip
        const firstChip = document.querySelector('.color-chip.active');
        if (firstChip) {
            updatePreview(firstChip);
            selectedColor = {
                name: firstChip.dataset.name,
                color: firstChip.dataset.color,
                collection: firstChip.dataset.collection
            };
        }

        // Color chip click handler
        chips.forEach(chip => {
            chip.addEventListener('click', function() {
                chips.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                updatePreview(this);
                selectedColor = {
                    name: this.dataset.name,
                    color: this.dataset.color,
                    collection: this.dataset.collection
                };
            });
        });

        function updatePreview(chip) {
            const color = chip.dataset.color;
            const name = chip.dataset.name;
            const collection = chip.dataset.collection;

            // Get image based on room filter
            let img = chip.dataset.img;
            if (currentRoomFilter !== 'all' && chip.dataset.imgs) {
                try {
                    const imgs = JSON.parse(chip.dataset.imgs);
                    if (imgs[currentRoomFilter]) {
                        img = imgs[currentRoomFilter];
                    }
                } catch(e) {
                    console.log('Error parsing imgs data');
                }
            }

            // Update Pantone card
            pantoneSwatch.style.background = color;
            pantoneName.textContent = name;
            pantoneCollection.textContent = collection;

            // Fade transition for image
            inspirationImg.style.opacity = '0';
            setTimeout(() => {
                inspirationImg.src = img;
                inspirationImg.style.opacity = '1';
            }, 150);
        }

        // Category filtering
        catBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                catBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const cat = this.dataset.cat;
                chips.forEach(chip => {
                    if (cat === 'all' || chip.dataset.cat === cat) {
                        chip.style.display = 'flex';
                    } else {
                        chip.style.display = 'none';
                    }
                });
            });
        });

        // Room type filtering
        roomBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                roomBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentRoomFilter = this.dataset.room;

                // Update current preview with new room type
                const activeChip = document.querySelector('.color-chip.active');
                if (activeChip) {
                    updatePreview(activeChip);
                }
            });
        });

        // ===== SECTION 2: Compare Colors =====

        // Populate compare picker grid
        const comparePickerGrid = document.getElementById('comparePickerGrid');
        chips.forEach(chip => {
            const miniChip = document.createElement('div');
            miniChip.className = 'picker-chip';
            miniChip.dataset.name = chip.dataset.name;
            miniChip.dataset.color = chip.dataset.color;
            miniChip.dataset.collection = chip.dataset.collection;
            miniChip.innerHTML = `
                <div class="picker-color" style="background: ${chip.dataset.color};"></div>
                <span>${chip.dataset.name}</span>
            `;
            miniChip.addEventListener('click', () => addToCompare(miniChip));
            comparePickerGrid.appendChild(miniChip);
        });

        function addToCompare(chip) {
            if (compareColors.length >= 3) return;

            const colorData = {
                name: chip.dataset.name,
                color: chip.dataset.color,
                collection: chip.dataset.collection
            };

            // Check if already added
            if (compareColors.find(c => c.name === colorData.name)) return;

            compareColors.push(colorData);
            chip.classList.add('selected');
            updateCompareDisplay();
        }

        function updateCompareDisplay() {
            for (let i = 0; i < 3; i++) {
                const card = document.getElementById(`compareCard${i + 1}`);
                const swatch = card.querySelector('.compare-swatch');
                const label = card.querySelector('.compare-label');
                const removeBtn = card.querySelector('.remove-btn');

                if (compareColors[i]) {
                    swatch.classList.remove('empty');
                    swatch.innerHTML = '';
                    swatch.style.background = compareColors[i].color;
                    label.textContent = compareColors[i].name;
                    removeBtn.style.display = 'flex';
                } else {
                    swatch.classList.add('empty');
                    swatch.innerHTML = '<i class="bi bi-plus-lg"></i>';
                    swatch.style.background = '';
                    label.textContent = `Color ${i + 1}`;
                    removeBtn.style.display = 'none';
                }
            }
        }

        // Remove buttons for compare
        document.querySelectorAll('.compare-card .remove-btn').forEach((btn, index) => {
            btn.addEventListener('click', function() {
                if (compareColors[index]) {
                    // Find and deselect the picker chip
                    const name = compareColors[index].name;
                    const pickerChip = document.querySelector(`.picker-chip[data-name="${name}"]`);
                    if (pickerChip) pickerChip.classList.remove('selected');

                    compareColors.splice(index, 1);
                    updateCompareDisplay();
                }
            });
        });

        // Clear all compare
        document.getElementById('clearCompareBtn').addEventListener('click', function() {
            compareColors = [];
            document.querySelectorAll('.picker-chip').forEach(c => c.classList.remove('selected'));
            updateCompareDisplay();
        });

        // Share compare selection
        document.getElementById('shareCompareBtn').addEventListener('click', function() {
            if (compareColors.length === 0) {
                alert('Please select colors to compare first.');
                return;
            }
            const colorNames = compareColors.map(c => c.name).join(', ');
            const url = `${window.location.origin}${window.location.pathname}?compare=${encodeURIComponent(colorNames)}`;

            navigator.clipboard.writeText(url).then(() => {
                this.innerHTML = '<i class="bi bi-check"></i> Link Copied!';
                setTimeout(() => {
                    this.innerHTML = '<i class="bi bi-share"></i> Share Selection';
                }, 2000);
            });
        });

        // ===== SECTION 3: Quick Estimator =====

        const estLength = document.getElementById('estLength');
        const estWidth = document.getElementById('estWidth');
        const estimatorResult = document.getElementById('estimatorResult');

        function calculateEstimate() {
            const length = parseFloat(estLength.value) || 0;
            const width = parseFloat(estWidth.value) || 0;

            if (length > 0 && width > 0) {
                const sqft = length * width;
                const lowPrice = Math.round(sqft * 55);
                const highPrice = Math.round(sqft * 95);

                estimatorResult.innerHTML = `
                    <div class="result-calculated">
                        <div class="result-sqft">
                            <span class="sqft-number">${sqft}</span>
                            <span class="sqft-label">sq ft</span>
                        </div>
                        <div class="result-divider"></div>
                        <div class="result-price">
                            <span class="price-range">$${lowPrice.toLocaleString()} - $${highPrice.toLocaleString()}</span>
                            <span class="price-label">Estimated Range</span>
                        </div>
                    </div>
                `;
            } else {
                estimatorResult.innerHTML = `
                    <div class="result-placeholder">
                        <i class="bi bi-arrow-up-circle"></i>
                        <span>Enter dimensions above to see estimate</span>
                    </div>
                `;
            }
        }

        estLength.addEventListener('input', calculateEstimate);
        estWidth.addEventListener('input', calculateEstimate);

        // ===== SECTION 4: Request Samples =====

        // Populate sample picker grid
        const samplePickerGrid = document.getElementById('samplePickerGrid');
        chips.forEach(chip => {
            const miniChip = document.createElement('div');
            miniChip.className = 'sample-picker-chip';
            miniChip.dataset.name = chip.dataset.name;
            miniChip.dataset.color = chip.dataset.color;
            miniChip.dataset.collection = chip.dataset.collection;
            miniChip.innerHTML = `<div class="mini-swatch" style="background: ${chip.dataset.color};"></div>`;
            miniChip.title = chip.dataset.name;
            miniChip.addEventListener('click', () => toggleSampleSelection(miniChip));
            samplePickerGrid.appendChild(miniChip);
        });

        function toggleSampleSelection(chip) {
            const name = chip.dataset.name;
            const existingIndex = sampleColors.findIndex(c => c.name === name);

            if (existingIndex > -1) {
                // Remove
                sampleColors.splice(existingIndex, 1);
                chip.classList.remove('selected');
            } else {
                // Add (max 3)
                if (sampleColors.length >= 3) {
                    alert('You can select up to 3 samples.');
                    return;
                }
                sampleColors.push({
                    name: chip.dataset.name,
                    color: chip.dataset.color,
                    collection: chip.dataset.collection
                });
                chip.classList.add('selected');
            }
            updateSampleDisplay();
        }

        function updateSampleDisplay() {
            const display = document.getElementById('sampleChipsDisplay');

            if (sampleColors.length === 0) {
                display.innerHTML = '<p class="no-samples">Click colors above to select samples (up to 3)</p>';
            } else {
                display.innerHTML = sampleColors.map(c => `
                    <div class="sample-chip-display">
                        <div class="chip-swatch" style="background: ${c.color};"></div>
                        <span>${c.name}</span>
                        <button class="chip-remove" data-name="${c.name}"><i class="bi bi-x"></i></button>
                    </div>
                `).join('');

                // Add remove handlers
                display.querySelectorAll('.chip-remove').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const name = this.dataset.name;
                        sampleColors = sampleColors.filter(c => c.name !== name);
                        const pickerChip = document.querySelector(`.sample-picker-chip[data-name="${name}"]`);
                        if (pickerChip) pickerChip.classList.remove('selected');
                        updateSampleDisplay();
                    });
                });
            }
        }

        // Sample form submission
        document.getElementById('samplesForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (sampleColors.length === 0) {
                alert('Please select at least one color sample.');
                return;
            }

            const btn = document.getElementById('submitSamplesBtn');
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sending...';
            btn.disabled = true;

            // Simulate form submission
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Request Sent!';
                btn.classList.add('btn-success');

                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-send"></i> Request Free Samples';
                    btn.disabled = false;
                    btn.classList.remove('btn-success');
                    this.reset();
                    sampleColors = [];
                    document.querySelectorAll('.sample-picker-chip').forEach(c => c.classList.remove('selected'));
                    updateSampleDisplay();
                }, 3000);
            }, 1500);
        });

        // ===== SECTION 5: Wall Palette Builder =====

        const paletteDots = document.querySelectorAll('.palette-dot');
        const paletteSlots = document.querySelectorAll('.palette-slot');
        let currentSlot = 0;

        // Initialize slots
        paletteSlots[0].style.background = '#F5F3EF';
        paletteSlots[1].style.background = '#FFFFFF';
        paletteSlots[2].style.background = '#D4C9B9';

        paletteDots.forEach(dot => {
            dot.addEventListener('mouseenter', function() {
                this.title = this.dataset.name;
            });

            dot.addEventListener('click', function() {
                const color = this.style.background;
                const hex = rgbToHex(getComputedStyle(this).backgroundColor);

                paletteSlots[currentSlot].style.background = color;
                paletteSlots[currentSlot].querySelector('.slot-hex').textContent = hex;

                // Visual feedback
                this.style.transform = 'scale(1.3)';
                setTimeout(() => this.style.transform = 'scale(1)', 200);

                currentSlot = (currentSlot + 1) % 3;
            });
        });

        document.getElementById('resetPaletteBtn').addEventListener('click', function() {
            const defaults = [
                { bg: '#F5F3EF', hex: '#F5F3EF' },
                { bg: '#FFFFFF', hex: '#FFFFFF' },
                { bg: '#D4C9B9', hex: '#D4C9B9' }
            ];
            paletteSlots.forEach((slot, i) => {
                slot.style.background = defaults[i].bg;
                slot.querySelector('.slot-hex').textContent = defaults[i].hex;
            });
            currentSlot = 0;
        });

        document.getElementById('copyPaletteBtn').addEventListener('click', function() {
            const colors = [];
            paletteSlots.forEach(slot => colors.push(slot.querySelector('.slot-hex').textContent));

            const text = `Griffin Quartz Color Palette\nWall: ${colors[0]}\nTrim: ${colors[1]}\nAccent: ${colors[2]}`;

            navigator.clipboard.writeText(text).then(() => {
                this.innerHTML = '<i class="bi bi-check"></i> Copied!';
                setTimeout(() => this.innerHTML = '<i class="bi bi-clipboard"></i> Copy Palette', 2000);
            });
        });

        function rgbToHex(rgb) {
            const result = rgb.match(/\d+/g);
            if (!result) return '#000000';
            return '#' + result.slice(0, 3).map(x => {
                const hex = parseInt(x).toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('').toUpperCase();
        }
    });
    </script>
</body>
</html>
