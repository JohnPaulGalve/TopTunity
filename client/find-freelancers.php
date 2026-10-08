<?php
$page_title = "Find Freelancers";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Find Freelancers</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Search and discover top talent for your projects[cite: 6, 47].</p>

  <div style="display: grid; grid-template-columns: 260px 1fr; gap: 2rem;">
    <!-- Filter -->
    <aside class="card" style="height: fit-content;">
      <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Filter by Skill</h3>
      <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem;">
        <label><input type="checkbox" checked> PHP</label>
        <label><input type="checkbox"> MySQL</label>
        <label><input type="checkbox"> JavaScript</label>
        <label><input type="checkbox"> Figma</label>
      </div>
    </aside>

    <main>
      <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem;">
        <input type="text" placeholder="Search by name or title..." style="flex: 1; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        <button class="btn-primary">Search</button>
      </div>

      <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h3>Miguel Reyes</h3>
            <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Full-Stack PHP Developer • ₱650/hr[cite: 95, 96]</p>
          </div>
          <div style="display: flex; gap: 0.5rem;">
            <a href="<?php echo $base_url; ?>client/saved-freelancers.php" class="btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">♡ Save</a>
            <a href="<?php echo $base_url; ?>client/hire-freelancer.php?freelancer=1" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Hire</a>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include '../includes/footer.php'; ?>