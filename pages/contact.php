<?php
/**
 * pages/contact.php - Public contact form. Submission is not wired to a backend yet.
 */
$user_role = "public";
$base_url  = "/Webdev/";

$page_title = "Contact Us";
include '../includes/header.php';
include '../includes/nav.php';

$subjects = ['Account help', 'Projects and proposals', 'Payments and fees', 'Report a user', 'Technical issue', 'Other'];
?>

<main class="page-browse">
  <div class="container">

    <header class="center-block">
      <h1 style="font-size:2rem; font-weight:700;">Contact Us</h1>
      <p style="margin-top:0.35rem; font-size:0.85rem; color:var(--color-muted-gray);">Send your inquiry or concern to the platform administrator.</p>
    </header>

    <div class="contact-layout">

      <form class="contact-form" method="post" action="">
        <div class="form-grid2">
          <div class="field">
            <label for="c-name">Full Name</label>
            <div class="input-wrap">
              <?= icon('user', 16) ?>
              <input type="text" id="c-name" name="name" placeholder="Your full name" autocomplete="name" required>
            </div>
          </div>
          <div class="field">
            <label for="c-email">Email Address</label>
            <div class="input-wrap">
              <?= icon('mail', 16) ?>
              <input type="email" id="c-email" name="email" placeholder="you@example.com" autocomplete="email" required>
            </div>
          </div>
        </div>

        <div class="field">
          <label for="c-subject">Subject</label>
          <select id="c-subject" name="subject" required>
            <option value="" selected disabled>Choose a subject…</option>
            <?php foreach ($subjects as $s): ?>
              <option value="<?= e($s) ?>"><?= e($s) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="c-message">Message</label>
          <textarea id="c-message" name="message" placeholder="How can we help?" required></textarea>
        </div>

        <div class="contact-form__foot">
          <small>We usually reply within 1–2 business days.</small>
          <button type="submit" class="btn btn--primary"><?= icon('send', 16) ?> Send Message</button>
        </div>
      </form>

      <aside class="contact-side">
        <div class="contact-info">
          <span class="icon-box icon-box--teal"><?= icon('mail', 18) ?></span>
          <div><small>Email</small><strong>support@toptunity.ph</strong></div>
        </div>
        <div class="contact-info">
          <span class="icon-box icon-box--teal"><?= icon('user', 18) ?></span>
          <div><small>Phone</small><strong>(02) 8123 4567</strong></div>
        </div>
        <div class="contact-info">
          <span class="icon-box icon-box--teal"><?= icon('clock', 18) ?></span>
          <div><small>Office hours</small><strong>Mon–Fri, 9:00 AM – 6:00 PM</strong></div>
        </div>

        <div class="help-card">
          <h3>Have a quick question?</h3>
          <p>Most answers are already in our FAQs.</p>
          <a href="faqs.php" class="btn btn--primary">Go to FAQs</a>
        </div>
      </aside>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>