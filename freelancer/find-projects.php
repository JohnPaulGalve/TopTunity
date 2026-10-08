<?php
$page_title = "Find Projects";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Find Projects</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Search open projects and view your automated skill match scores[cite: 8, 58].</p>

  <div style="display: grid; grid-template-columns: 260px 1fr; gap: 2rem;">
    <!-- Sidebar Filter -->
    <aside class="card" style="height: fit-content;">
      <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Filter Projects</h3>
      <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.9rem;">
        <div>
          <strong>Billing Type</strong>
          <div style="margin-top: 0.4rem;">
            <label style="display: block;"><input type="checkbox" checked> Fixed Price</label>
            <label style="display: block;"><input type="checkbox" checked> Hourly Rate</label>
          </div>
        </div>
        <div>
          <strong>Category</strong>
          <div style="margin-top: 0.4rem;">
            <label style="display: block;"><input type="checkbox"> Web Development</label>
            <label style="display: block;"><input type="checkbox"> Mobile Apps</label>
            <label style="display: block;"><input type="checkbox"> UI/UX Design</label>
          </div>
        </div>
      </div>
    </aside>

    <!-- Project Listings -->
    <main>
      <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem;">
        <input type="text" placeholder="Search by keyword or skill tag..." style="flex: 1; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        <button class="btn-primary">Search</button>
      </div>

      <!-- Recommended Section -->
      <h3 style="margin-bottom: 1rem; color: var(--color-vibrant-teal);">Recommended Based on Your Skills</h3>
      <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
        <!-- Job Card 1 -->
        <div class="card" style="border-left: 4px solid var(--color-vibrant-teal);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
              <div style="display: flex; gap: 0.5rem; align-items: center;">
                <span class="badge badge-info">Web Development</span>
                <span class="badge badge-success">95% Match</span>[cite: 8, 58]
              </div>
              <h3 style="margin: 0.5rem 0;"><a href="<?php echo $base_url; ?>freelancer/project-details.php?id=101">Online Ordering Website for a Coffee Shop</a></h3>
            </div>
            <div style="text-align: right;">
              <strong style="color: var(--color-vibrant-teal); font-size: 1.2rem;">₱45,000</strong>
              <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Fixed Price</p>
            </div>
          </div>
          <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin: 0.5rem 0;">We need a simple online ordering website where customers can browse our coffee menu[cite: 91, 93].</p>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <div>
              <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">PHP</span>
              <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">MySQL</span>
              <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">JavaScript</span>
            </div>
            <a href="<?php echo $base_url; ?>freelancer/project-details.php?id=101" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Submit Proposal</a>
          </div>
        </div>

        <!-- Job Card 2 -->
        <div class="card" style="border-left: 4px solid var(--color-vibrant-teal);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
              <div style="display: flex; gap: 0.5rem; align-items: center;">
                <span class="badge badge-info">Web Development</span>
                <span class="badge badge-success">82% Match</span>[cite: 58]
              </div>
              <h3 style="margin: 0.5rem 0;"><a href="<?php echo $base_url; ?>freelancer/project-details.php?id=102">Student Enrollment System for Tutorial Center</a></h3>
            </div>
            <div style="text-align: right;">
              <strong style="color: var(--color-vibrant-teal); font-size: 1.2rem;">₱500 / hr</strong>
              <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Hourly (Max 80 hrs)[cite: 94]</p>
            </div>
          </div>
          <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin: 0.5rem 0;">Build a web-based enrollment and payment tracking system for 300 students[cite: 93, 94].</p>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <div>
              <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">PHP</span>
              <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">MySQL</span>
            </div>
            <a href="<?php echo $base_url; ?>freelancer/project-details.php?id=102" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Submit Proposal</a>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include '../includes/footer.php'; ?>