<?php
/**
 * includes/footer.php
 * Global footer, loads js/main.js and closes <body> and <html>.
 */
$base_url = isset($base_url) ? $base_url : (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
?>
<?php if (!empty($app_shell)): ?>
</div><!-- /app-main -->
</div><!-- /app-shell -->
<?php endif; ?>

<footer class="footer">
  <div class="container">
    <div class="footer__grid">
      <div>
        <a href="<?= e($base_url . tt_brand_home()) ?>" class="brand-logo brand-logo--light" aria-label="TopTunity home">TopTunity<span class="logo-star" aria-hidden="true">&#10022;</span></a>
        <p class="footer__tagline">Top Talents. Best Opportunities.</p>
        <p class="footer__about">The freelance project and service marketplace that connects clients who need projects done with skilled Filipino freelancers.</p>
      </div>

      <div>
        <h4>Platform</h4>
        <ul>
          <li><a href="<?= e($base_url) ?>pages/about.php">About Us</a></li>
          <li><a href="<?= e($base_url) ?>pages/guide.php">Guide</a></li>
          <li><a href="<?= e($base_url) ?>pages/pricing.php">Pricing</a></li>
          <li><a href="<?= e($base_url) ?>pages/testimonials.php">Testimonials</a></li>
        </ul>
      </div>

      <div>
        <h4>Support</h4>
        <ul>
          <li><a href="<?= e($base_url) ?>pages/contact.php">Contact Us</a></li>
          <li><a href="<?= e($base_url) ?>pages/faqs.php">FAQs</a></li>
          <li><a href="<?= e($base_url) ?>pages/terms.php">Terms and Privacy Policy</a></li>
        </ul>
      </div>
    </div>

    <div class="footer__bottom">
      <span>&copy; <?= date('Y') ?> TopTunity. All rights reserved.</span>
      <span>All payments on TopTunity are simulated. No real money is used.</span>
    </div>
  </div>
</footer>

<script src="<?= e($base_url) ?>js/main.js?v=<?= @filemtime(__DIR__ . '/../js/main.js') ?>"></script>
</body>
</html>