<?php
$page_title = "Contact Form Inquiries";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Public Contact Inquiries</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Review and respond to messages submitted via the public Contact Us page[cite: 11, 86].</p>

  <div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
      <thead>
        <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
          <th style="padding: 0.75rem;">Name</th>
          <th style="padding: 0.75rem;">Email</th>
          <th style="padding: 0.75rem;">Subject</th>
          <th style="padding: 0.75rem;">Message Preview</th>
          <th style="padding: 0.75rem;">Date</th>
          <th style="padding: 0.75rem;">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;">Juan Dela Cruz</td>
          <td style="padding: 0.75rem;">juan@example.com</td>
          <td style="padding: 0.75rem;">Inquiry regarding GCash withdrawals</td>
          <td style="padding: 0.75rem; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">How long do withdrawal requests take to process?</td>
          <td style="padding: 0.75rem;">Oct 05, 2026</td>
          <td style="padding: 0.75rem;">
            <button class="btn-primary" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">Reply</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>