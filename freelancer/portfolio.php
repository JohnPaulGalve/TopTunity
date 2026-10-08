<?php
$page_title = "Portfolio Management";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <h2>Portfolio Management</h2>
      <p style="color: var(--color-muted-gray);">Upload and showcase previous work samples on your public profile[cite: 9, 68].</p>
    </div>
    <button class="btn-primary" onclick="document.getElementById('portfolioForm').style.display='block';">+ Add Portfolio Sample</button>
  </div>

  <!-- Upload New Portfolio Item Form -->
  <div id="portfolioForm" class="card" style="display: none; margin-bottom: 2rem; background: var(--color-off-white);">
    <h3>Upload Work Sample</h3>
    <form action="#" method="POST" style="margin-top: 1rem;">
      <div style="margin-bottom: 1rem;">
        <label style="display: block; font-weight: 600; font-size: 0.9rem;">Project Title</label>
        <input type="text" name="item_title" placeholder="e.g. Restaurant Point of Sale System" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
      </div>
      <div style="margin-bottom: 1rem;">
        <label style="display: block; font-weight: 600; font-size: 0.9rem;">Category / Skill Tag</label>
        <input type="text" name="item_category" placeholder="Web Development, PHP" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
      </div>
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 600; font-size: 0.9rem;">Sample Preview Image</label>
        <input type="file" name="item_image" required style="font-size: 0.85rem;">
      </div>
      <div style="display: flex; gap: 0.5rem;">
        <button type="submit" class="btn-primary">Upload Sample</button>
        <button type="button" class="btn-outline" onclick="document.getElementById('portfolioForm').style.display='none';">Cancel</button>
      </div>
    </form>
  </div>

  <!-- Portfolio Grid View -->
  <div class="grid-3">
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="height: 140px; background: var(--color-border-gray); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--color-muted-gray); margin-bottom: 1rem;">[ Sample Image Preview ]</div>
        <h3>Sari-Sari Store POS System</h3>
        <p style="font-size: 0.85rem; color: var(--color-muted-gray); margin-top: 0.2rem;">Web Development • PHP / MySQL</p>
      </div>
      <button class="btn-outline" style="margin-top: 1rem; color: var(--color-error-base); padding: 0.3rem 0.6rem; font-size: 0.8rem;">Delete Item</button>
    </div>

    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="height: 140px; background: var(--color-border-gray); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--color-muted-gray); margin-bottom: 1rem;">[ Sample Image Preview ]</div>
        <h3>Resort Booking Web Portal</h3>
        <p style="font-size: 0.85rem; color: var(--color-muted-gray); margin-top: 0.2rem;">Web Development • JavaScript</p>
      </div>
      <button class="btn-outline" style="margin-top: 1rem; color: var(--color-error-base); padding: 0.3rem 0.6rem; font-size: 0.8rem;">Delete Item</button>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>