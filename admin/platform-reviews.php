<?php
$page_title = "Platform Reviews Moderation";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Platform Reviews Moderation</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Approve, publish, or unpublish user platform reviews shown on the public Testimonials page[cite: 11, 86].</p>

  <div style="display: flex; flex-direction: column; gap: 1rem;">
    <div class="card" style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.3rem;">
          <strong>Rhea Mendoza</strong> (Freelancer)[cite: 92]
          <span style="color: var(--color-warning-text); font-size: 0.85rem;">★ 5.0</span>
        </div>
        <p style="font-size: 0.85rem; color: var(--color-deep-slate);">
          "The 10% fee structure is shown upfront so I always know my exact net earnings before submitting proposals."[cite: 92]
        </p>
      </div>
      <div style="display: flex; gap: 0.5rem;">
        <span class="badge badge-success" style="align-self: center;">Published</span>[cite: 86]
        <button class="btn-outline" style="font-size: 0.75rem; padding: 0.3rem 0.6rem; color: var(--color-error-base);">Unpublish</button>[cite: 11, 86]
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>