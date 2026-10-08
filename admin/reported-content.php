<?php
$page_title = "Reported Content Moderation";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Reported Content & Profiles</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Review flagged messages, inappropriate user profiles, or project descriptions[cite: 10, 80].</p>

  <div style="display: flex; flex-direction: column; gap: 1rem;">
    <!-- Report Item Card 1 -->
    <div class="card" style="border-left: 4px solid var(--color-error-base);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <span class="badge badge-error">Reported Chat Message</span>
          <h3 style="margin: 0.5rem 0;">Inappropriate language reported in chat thread</h3>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Reported by: Andrea Santos • Target User: User_992</p>
          <p style="font-size: 0.9rem; background: var(--color-off-white); padding: 0.6rem; border-radius: 4px; margin-top: 0.5rem;">"Content text flagged for review by moderator."</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
          <button class="btn-primary" style="background: var(--color-error-base); font-size: 0.8rem; padding: 0.3rem 0.6rem;">Delete Content</button>[cite: 10, 80]
          <button class="btn-outline" style="font-size: 0.8rem; padding: 0.3rem 0.6rem;">Dismiss Report</button>[cite: 10, 80]
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>