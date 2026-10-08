<?php
$page_title = "Edit Profile";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';

// Mock Freelancer Profile
$freelancer_name = "Miguel Reyes";
$title = "Full-Stack PHP Developer";
$hourly_rate = 650;
$bio = "Full-stack web developer with 5 years of experience building secure web applications, database systems, and custom admin portals for clients[cite: 95, 96].";
$location = "Cebu City, Philippines";
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <div class="card">
    <h2>Edit Freelancer Profile</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 2rem;">Update your public profile, headline, rate, and bio displayed to clients[cite: 9, 66].</p>

    <form action="#" method="POST">
      <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--color-border-gray); padding-bottom: 1.5rem;">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--color-disabled-gray); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: bold;">MR</div>
        <div>
          <button type="button" class="btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Change Avatar</button>
          <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-top: 0.4rem;">JPG or PNG up to 2MB.</p>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label for="full_name" style="display: block; font-weight: 600; font-size: 0.9rem;">Full Name</label>
          <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($freelancer_name); ?>" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div>
          <label for="professional_title" style="display: block; font-weight: 600; font-size: 0.9rem;">Professional Title</label>
          <input type="text" name="professional_title" id="professional_title" value="<?php echo htmlspecialchars($title); ?>" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label for="hourly_rate" style="display: block; font-weight: 600; font-size: 0.9rem;">Hourly Rate (₱/hr)</label>
          <input type="number" name="hourly_rate" id="hourly_rate" value="<?php echo $hourly_rate; ?>" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div>
          <label for="location" style="display: block; font-weight: 600; font-size: 0.9rem;">Location</label>
          <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($location); ?>" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label for="bio" style="display: block; font-weight: 600; font-size: 0.9rem;">Professional Bio</label>
        <textarea name="bio" id="bio" rows="5" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"><?php echo htmlspecialchars($bio); ?></textarea>
      </div>

      <button type="submit" class="btn-primary">Save Profile Updates</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>