<?php
$page_title = "About Us";
$user_role = "public";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <div class="card" style="margin-bottom: 2rem;">
    <h2>Connecting Talent with Best Opportunities</h2>
    <p style="color: var(--color-muted-gray); margin-top: 0.5rem; margin-bottom: 1.5rem;">TopTunity is an academic freelance marketplace prototype designed by Team KitInClass[cite: 1, 4].</p>
    <p style="line-height: 1.8; color: var(--color-deep-slate);">
      Our mission is to create a seamless digital standard where local clients and skilled independent talents can connect efficiently[cite: 2, 4]. The platform provides built-in tools for contract generation, structured project tracking, work logging, and clear financial record keeping[cite: 2].
    </p>
  </div>

  <div class="grid-3">
    <div class="card" style="text-align: center;">
      <h3 style="color: var(--color-vibrant-teal); margin-bottom: 0.5rem;">Skill-Based Match</h3>
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Automated skill comparison percentage calculation between projects and freelancers[cite: 5, 8, 33].</p>
    </div>
    <div class="card" style="text-align: center;">
      <h3 style="color: var(--color-vibrant-teal); margin-bottom: 0.5rem;">Escrow Safety</h3>
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Simulated deposit protection ensures payments are held safely until completed work is approved[cite: 6, 33].</p>
    </div>
    <div class="card" style="text-align: center;">
      <h3 style="color: var(--color-vibrant-teal); margin-bottom: 0.5rem;">Two-Way Reviews</h3>
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Transparent mutual feedback system builds digital trust for both clients and talent[cite: 6, 9, 33].</p>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>