<?php
$page_title = "Contact Us";
$user_role = "public";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <div style="display: grid; grid-template-columns: 1fr 320px; gap: 2rem;">
    <!-- Contact Form -->
    <main class="card">
      <h2>Send Us an Inquiry</h2>
      <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Have questions or concerns? Reach out to the platform administrator[cite: 4, 34].</p>

      <form action="#" method="POST">
        <div style="margin-bottom: 1rem;">
          <label for="contact_name" style="display: block; font-weight: 600; font-size: 0.9rem;">Full Name</label>
          <input type="text" name="contact_name" id="contact_name" placeholder="Juan Dela Cruz" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>

        <div style="margin-bottom: 1rem;">
          <label for="contact_email" style="display: block; font-weight: 600; font-size: 0.9rem;">Email Address</label>
          <input type="email" name="contact_email" id="contact_email" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>

        <div style="margin-bottom: 1rem;">
          <label for="contact_subject" style="display: block; font-weight: 600; font-size: 0.9rem;">Subject</label>
          <input type="text" name="contact_subject" id="contact_subject" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>

        <div style="margin-bottom: 1.5rem;">
          <label for="contact_message" style="display: block; font-weight: 600; font-size: 0.9rem;">Message</label>
          <textarea name="contact_message" id="contact_message" rows="5" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
        </div>

        <button type="submit" class="btn-primary">Send Message</button>
      </form>
    </main>

    <!-- Support Information Sidebar -->
    <aside class="card">
      <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Help & Support</h3>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-bottom: 0.5rem;"><strong>Email:</strong> support@toptunity.ph</p>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-bottom: 0.5rem;"><strong>Office Hours:</strong> Mon - Fri, 9 AM - 5 PM</p>
      <p style="font-size: 0.85rem; color: var(--color-muted-gray); margin-top: 1.5rem;">Inquiries submitted through this form are logged in the administrator's dashboard[cite: 11, 34].</p>
    </aside>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>