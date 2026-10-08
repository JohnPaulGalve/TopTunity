<?php
$page_title = "Platform Review";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 600px;">
  <div class="card">
    <h2>Rate TopTunity</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Share your feedback as a freelancer on our platform[cite: 10, 75].</p>

    <form action="#" method="POST">
      <div style="margin-bottom: 1rem;">
        <label for="rating" style="display: block; font-weight: 600; font-size: 0.9rem;">Rating</label>
        <select name="rating" id="rating" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
          <option value="5">★★★★★ (5 Stars)</option>
          <option value="4">★★★★☆ (4 Stars)</option>
        </select>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label for="review_text" style="display: block; font-weight: 600; font-size: 0.9rem;">Your Feedback</label>
        <textarea name="review_text" id="review_text" rows="5" required placeholder="Write about your experience finding projects and receiving net payouts..." style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
      </div>

      <button type="submit" class="btn-primary" style="width: 100%;">Submit Platform Review</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>