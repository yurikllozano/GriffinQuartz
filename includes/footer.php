<?php
// Set default base path if not defined
if (!isset($basePath)) {
    $basePath = '.';
}
// Create prefix - empty for root, '../' for subdirectories
$prefix = ($basePath === '.' || $basePath === '') ? '' : $basePath . '/';
?>
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Visit Our Showroom</h4>
                <p>Located at Englert Arts Inc.</p>
                <a href="https://www.google.com/maps?q=1021+S+Rogers+Cir+%2318,+Boca+Raton,+FL+33487" target="_blank" rel="noopener">
                    1021 S Rogers Cir #18<br>Boca Raton, FL 33487
                </a>
                <p style="margin-top: 1rem;"><strong>Hours:</strong> Mon-Fri 7:30AM-3:30PM</p>
            </div>
            <div class="footer-col">
                <h4>Quartz Countertop Services</h4>
                <ul>
                    <li><a href="<?php echo $prefix; ?>quartz-brands">Quartz Product Selection</a></li>
                    <li><a href="<?php echo $prefix; ?>kitchen-bath">Kitchen & Bathroom Countertops</a></li>
                    <li><a href="<?php echo $prefix; ?>commercial">Commercial Countertop Installation</a></li>
                    <li><a href="<?php echo $prefix; ?>gallery">Inspiration Gallery</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Service Areas</h4>
                <ul class="service-areas">
                    <li><a href="<?php echo $prefix; ?>boca-raton">Boca Raton</a></li>
                    <li><a href="<?php echo $prefix; ?>fort-lauderdale">Fort Lauderdale</a></li>
                    <li><a href="<?php echo $prefix; ?>miami">Miami</a></li>
                    <li><a href="<?php echo $prefix; ?>west-palm-beach">West Palm Beach</a></li>
                    <li><a href="<?php echo $prefix; ?>delray-beach">Delray Beach</a></li>
                    <li><a href="<?php echo $prefix; ?>locations">All South Florida Locations</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Griffin Quartz</h4>
                <p><strong>Phone:</strong> <a href="tel:+17203241436">(720) 324-1436</a></p>
                <p><strong>Email:</strong> <a href="mailto:info@griffinquartz.com">info@griffinquartz.com</a></p>
                <p style="margin-top: 1rem;"><a href="<?php echo $prefix; ?>#contact-form" class="btn btn-primary btn-sm">Get FREE Quote</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Griffin Quartz | South Florida's Premier Quartz Countertop Installers</p>
            <p class="footer-areas">Proudly serving Palm Beach County, Broward County, and Miami-Dade County including Boca Raton, Fort Lauderdale, Miami, West Palm Beach, Delray Beach, Hollywood, Pompano Beach, Coral Gables, Miami Beach, Aventura, and surrounding areas.</p>
        </div>
    </div>
</footer>

<script src="<?php echo $prefix; ?>script.js"></script>
