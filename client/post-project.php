<?php
$page_title = "Post a Project";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <div class="card">
    <h2>Post a Project</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 2rem;">Set your project requirements, billing type, budget, and deadline[cite: 5, 40].</p>

    <form action="/client/my-projects.php" method="GET" id="postProjectForm">
      <div style="margin-bottom: 1rem;">
        <label for="project_title" style="display: block; font-weight: 600; font-size: 0.9rem;">Project Title</label>
        <input type="text" name="project_title" id="project_title" placeholder="e.g. Build an Online Ordering Website for a Coffee Shop" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
      </div>

      <div style="margin-bottom: 1rem;">
        <label for="project_description" style="display: block; font-weight: 600; font-size: 0.9rem;">Description</label>
        <textarea name="project_description" id="project_description" rows="5" placeholder="Describe what you need done..." required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label for="category" style="display: block; font-weight: 600; font-size: 0.9rem;">Category</label>
          <select name="category" id="category" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
            <option value="web">Web Development</option>
            <option value="mobile">Mobile App Development</option>
            <option value="design">Graphic & UI/UX Design</option>
          </select>
        </div>
        <div>
          <label for="required_skills" style="display: block; font-weight: 600; font-size: 0.9rem;">Required Skills</label>
          <input type="text" name="required_skills" id="required_skills" placeholder="PHP, MySQL, JavaScript" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <!-- Billing Selection -->
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.5rem;">Billing Type</label>
        <div style="display: flex; gap: 2rem;">
          <label><input type="radio" name="billing_type" value="fixed" checked> Fixed Price (One budget for whole project)[cite: 5, 40]</label>
          <label><input type="radio" name="billing_type" value="hourly"> Hourly Rate (Pay for approved hours)[cite: 5, 40]</label>
        </div>
      </div>

      <!-- Calculation Fields -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label for="hourly_rate" style="display: block; font-weight: 600; font-size: 0.9rem;">Hourly Rate (₱/hr)</label>
          <input type="number" name="hourly_rate" id="hourly_rate" placeholder="500" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div>
          <label for="max_hours" style="display: block; font-weight: 600; font-size: 0.9rem;">Maximum Hours</label>
          <input type="number" name="max_hours" id="max_hours" placeholder="40" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <div style="background: var(--color-off-white); padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid var(--color-border-gray);">
        <strong>Hourly Budget Calculation: </strong><span id="computed_budget" style="color: var(--color-vibrant-teal); font-weight: bold;">₱0</span>
        <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-top: 0.2rem;">Hourly budget = Hourly Rate × Maximum Hours[cite: 5, 40]. A 10% platform service fee is deducted from the freelancer's payout[cite: 2, 40].</p>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label for="deadline" style="display: block; font-weight: 600; font-size: 0.9rem;">Project Deadline</label>
        <input type="date" name="deadline" id="deadline" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
      </div>

      <div style="display: flex; gap: 1rem;">
        <button type="submit" class="btn-primary">Post Project</button>
        <a href="<?php echo $base_url; ?>client/my-projects.php" class="btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>