<?php
$page_title = "Saved Freelancers";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Saved Freelancers</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Freelancers you bookmarked for future projects[cite: 7, 55].</p>

  <div class="grid-3">
    <!-- Saved Card 1 -->
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
          <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--color-disabled-gray); display: flex; align-items: center; justify-content: center; font-weight: bold;">MR</div>
          <div>
            <h3 style="font-size: 1.1rem; margin: 0;">Miguel Reyes</h3>
            <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Full-Stack PHP Developer[cite: 95]</p>
          </div>
        </div>
        <p style="font-size: 0.85rem; color: var(--color-warning-text); font-weight: bold; margin-bottom: 0.5rem;">★ 4.9 (38 reviews)</p>
        <p style="font-size: 0.85rem; color: var(--color-muted-gray); margin-bottom: 1.5rem;">Rate: ₱650 / hr • 42 completed projects[cite: 95, 96]</p>
      </div>

      <div style="display: flex; gap: 0.5rem;">
        <a href="<?php echo $base_url; ?>client/hire-freelancer.php?freelancer=1" class="btn-primary" style="flex: 1; text-align: center; padding: 0.4rem; font-size: 0.85rem;">Hire</a>
        <button class="btn-outline" style="padding: 0.4rem; font-size: 0.85rem; color: var(--color-error-base);">Remove</button>
      </div>
    </div>

    <!-- Saved Card 2 -->
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
          <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--color-disabled-gray); display: flex; align-items: center; justify-content: center; font-weight: bold;">BL</div>
          <div>
            <h3 style="font-size: 1.1rem; margin: 0;">Bea Lim</h3>
            <p style="font-size: 0.8rem; color: var(--color-muted-gray);">UI/UX Designer[cite: 95]</p>
          </div>
        </div>
        <p style="font-size: 0.85rem; color: var(--color-warning-text); font-weight: bold; margin-bottom: 0.5rem;">★ 4.8 (27 reviews)</p>
        <p style="font-size: 0.85rem; color: var(--color-muted-gray); margin-bottom: 1.5rem;">Rate: ₱600 / hr • 31 completed projects[cite: 95]</p>
      </div>

      <div style="display: flex; gap: 0.5rem;">
        <a href="<?php echo $base_url; ?>client/hire-freelancer.php?freelancer=2" class="btn-primary" style="flex: 1; text-align: center; padding: 0.4rem; font-size: 0.85rem;">Hire</a>
        <button class="btn-outline" style="padding: 0.4rem; font-size: 0.85rem; color: var(--color-error-base);">Remove</button>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>