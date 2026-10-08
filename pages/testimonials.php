<?php
$page_title = "Testimonials";
$user_role = "public";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <div style="text-align: center; max-width: 600px; margin: 0 auto 3rem;">
    <h2>What Our Users Say</h2>
    <p style="color: var(--color-muted-gray);">Published platform reviews from our clients and freelancers[cite: 3, 32].</p>
  </div>

  <div class="grid-3">
    <div class="card">
      <p style="color: var(--color-warning-text); font-weight: bold; margin-bottom: 0.5rem;">★★★★★</p>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-bottom: 1rem; font-style: italic;">"I posted our ordering website project and had solid proposals fast. Holding payment until work approval gave peace of mind!"[cite: 92]</p>
      <strong>Andrea Santos</strong>
      <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Client • Kapé Lokal Coffee Co.[cite: 92]</p>
    </div>

    <div class="card">
      <p style="color: var(--color-warning-text); font-weight: bold; margin-bottom: 0.5rem;">★★★★★</p>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-bottom: 1rem; font-style: italic;">"The 10% fee structure is shown upfront so I always know my exact net earnings before submitting proposals."[cite: 92]</p>
      <strong>Rhea Mendoza</strong>
      <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Freelancer • Content Writer[cite: 92]</p>
    </div>

    <div class="card">
      <p style="color: var(--color-warning-text); font-weight: bold; margin-bottom: 0.5rem;">★★★★★</p>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-bottom: 1rem; font-style: italic;">"Tracking the project workflow from initial contract to completion was intuitive. Great experience overall."[cite: 92]</p>
      <strong>Grace Aquino</strong>
      <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Client • Dental Clinic Manager[cite: 92]</p>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>