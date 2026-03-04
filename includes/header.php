<?php
// Set default base path if not defined
if (!isset($basePath)) {
    $basePath = '.';
}
// Create prefix - empty for root, '../' for subdirectories
$prefix = ($basePath === '.' || $basePath === '') ? '' : $basePath . '/';
// Home link - always use absolute root path
$homeLink = '/';
?>

<!-- Lead Capture Popup -->
<div class="lead-popup-overlay" id="leadPopup">
    <div class="lead-popup">
        <button class="lead-popup-close" id="leadPopupClose" aria-label="Close popup">&times;</button>
        <div class="lead-popup-content">
            <h3>Instant FREE Estimate</h3>
            <p>Your perfect quartz countertop is just a click away. Get a free in-home consultation and see why our craftsmanship and warranty set us apart</p>
            <div class="lead-popup-benefits">
                <span><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M13.5 4.5L6 12L2.5 8.5" stroke="#FDB913" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Free Consultation</span>
                <span><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M13.5 4.5L6 12L2.5 8.5" stroke="#FDB913" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> In-House Fabrication</span>
                <span><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M13.5 4.5L6 12L2.5 8.5" stroke="#FDB913" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Warranty-Backed Service</span>
            </div>
        </div>
        <div class="lead-popup-image">
            <img src="<?php echo $prefix; ?>images/kitchen-calacatta-gold-globe-pendants.webp" alt="Luxury calacatta gold kitchen countertop" width="800" height="533" loading="lazy">
        </div>
        <div class="lead-popup-form-wrapper">
            <form id="leadPopupForm" class="lead-popup-form">
                <div class="form-group form-group-icon">
                    <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6L12 13L2 6"/></svg>
                    <input type="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group form-group-icon">
                    <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
                    <input type="text" name="name" placeholder="Enter name" required>
                </div>
                <div class="form-group form-group-icon form-group-phone">
                    <div class="phone-prefix">
                        <span class="flag-icon">🇺🇸</span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 4.5L6 7.5L9 4.5"/></svg>
                    </div>
                    <input type="tel" name="phone" placeholder="Enter a phone number" required>
                </div>
                <button type="submit" class="btn btn-dark btn-full">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- Admin Utility Bar -->
<div class="admin-utility-bar">
    <div class="container">
        <a href="<?php echo $prefix; ?>admin/leads" class="admin-login-link"><i class="bi bi-person-lock"></i> Admin</a>
    </div>
</div>

<!-- Announcement Bar -->
<div class="announcement-bar">
    <p>&#9752; St. Patrick's Day Sale—<strong>Up to 50% OFF</strong> Select Slabs. Fast Installation in as Little as 1 Week! <a href="<?php echo $prefix; ?>#contact-form"><strong>EXPLORE SALE</strong></a></p>
</div>

<!-- Header -->
<header class="header">
    <div class="container">
        <a href="<?php echo $homeLink; ?>" class="logo"><img src="<?php echo $prefix; ?>images/griffin-quartz-logo.webp" alt="Griffin Quartz" width="800" height="330" loading="eager"></a>

        <nav class="nav" id="mainNav">
            <ul class="nav-list">
                <li class="nav-item dropdown has-mega-menu">
                    <a href="#" class="nav-link">Our Services</a>
                    <!-- Mega Menu - Icons + Text -->
                    <div class="mega-menu mega-menu-icons">
                        <div class="mega-menu-grid">
                            <a href="<?php echo $prefix; ?>kitchen-bath" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="M3 9V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v3"/><path d="M12 4v5"/><path d="M8 13v4"/><path d="M16 13v4"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Kitchen Countertops</strong>
                                    <span>Islands, perimeters & breakfast bars</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>kitchen-bath#bathroom" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6 6.5 3.5a1.5 1.5 0 0 0-1-.5C4.683 3 4 3.683 4 4.5V17a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/><line x1="10" x2="8" y1="5" y2="7"/><line x1="2" x2="22" y1="12" y2="12"/><line x1="7" x2="7" y1="19" y2="21"/><line x1="17" x2="17" y1="19" y2="21"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Bathroom Vanities</strong>
                                    <span>Single, double & floating vanity tops</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>commercial" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Commercial Projects</strong>
                                    <span>Hotels, restaurants, offices & retail</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>quartz-countertops" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Quartz Countertops</strong>
                                    <span>Engineered stone, non-porous, low maintenance</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>quartzite-countertops" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72Z"/><path d="m14 7 3 3"/><path d="M5 6v4"/><path d="M19 14v4"/><path d="M10 2v2"/><path d="M7 8H3"/><path d="M21 16h-4"/><path d="M11 3H9"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Quartzite Countertops</strong>
                                    <span>Natural stone, superior heat resistance</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>marble-countertops" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Marble Countertops</strong>
                                    <span>Carrara, Calacatta & Statuario marble</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>granite-countertops" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Granite Countertops</strong>
                                    <span>Durable natural stone, unique patterns</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>semi-precious-stone-countertops" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Semi-Precious Stone Countertops</strong>
                                    <span>Backlit agate, amethyst & onyx</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>quartz-brands" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Quartz Brands</strong>
                                    <span>Cambria, Silestone, Caesarstone & more</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>countertop-materials" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/><path d="M9 21v-6h6v6"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>All Countertop Materials</strong>
                                    <span>Compare quartz, marble, granite & more</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>our-services" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>All Services</strong>
                                    <span>Fabrication, installation & more</span>
                                </span>
                            </a>
                            <a href="<?php echo $prefix; ?>gallery" class="mega-menu-item">
                                <span class="mega-menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                </span>
                                <span class="mega-menu-text">
                                    <strong>Inspiration Gallery</strong>
                                    <span>Browse our completed projects</span>
                                </span>
                            </a>
                        </div>
                        <div class="mega-menu-footer">
                            <a href="<?php echo $prefix; ?>#contact-form" class="mega-menu-cta-btn">Get Your FREE Quote</a>
                        </div>
                    </div>
                    <!-- Mobile fallback dropdown -->
                    <ul class="dropdown-menu mobile-dropdown">
                        <li><a href="<?php echo $prefix; ?>our-services">Countertop Services</a></li>
                        <li><a href="<?php echo $prefix; ?>countertop-materials">All Countertop Materials</a></li>
                        <li><a href="<?php echo $prefix; ?>quartz-countertops">Quartz Countertops</a></li>
                        <li><a href="<?php echo $prefix; ?>quartzite-countertops">Quartzite Countertops</a></li>
                        <li><a href="<?php echo $prefix; ?>marble-countertops">Marble Countertops</a></li>
                        <li><a href="<?php echo $prefix; ?>granite-countertops">Granite Countertops</a></li>
                        <li><a href="<?php echo $prefix; ?>semi-precious-stone-countertops">Semi-Precious Stone</a></li>
                        <li><a href="<?php echo $prefix; ?>quartz-brands">Quartz Brands</a></li>
                        <li><a href="<?php echo $prefix; ?>kitchen-bath">Kitchens & Baths</a></li>
                        <li><a href="<?php echo $prefix; ?>commercial">Commercial Services</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">Installation Locations</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $prefix; ?>locations">All Service Areas</a></li>
                        <li><a href="<?php echo $prefix; ?>south-florida">South Florida</a></li>
                        <li><a href="<?php echo $prefix; ?>boca-raton">Boca Raton, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>boynton-beach">Boynton Beach, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>coconut-creek">Coconut Creek, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>coral-springs">Coral Springs, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>deerfield-beach">Deerfield Beach, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>delray-beach">Delray Beach, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>fort-lauderdale">Fort Lauderdale, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>hollywood">Hollywood, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>miami">Miami, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>parkland">Parkland, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>pompano-beach">Pompano Beach, FL</a></li>
                        <li><a href="<?php echo $prefix; ?>west-palm-beach">West Palm Beach, FL</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="<?php echo $prefix; ?>gallery" class="nav-link">Inspiration Gallery</a></li>
                <li class="nav-item"><a href="<?php echo $prefix; ?>contact" class="nav-link">Contact Us</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">Resources</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $prefix; ?>color-visualizer">Color Visualizer</a></li>
                        <li><a href="<?php echo $prefix; ?>space-design-tool">Space Design Tool</a></li>
                        <li><a href="<?php echo $prefix; ?>quote-calculator">Instant Quote Calculator</a></li>
                        <li><a href="<?php echo $prefix; ?>blog/">Blog</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="tel:+17203241436" class="nav-link phone-link">(720) 324-1436</a></li>
            </ul>
        </nav>

        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
