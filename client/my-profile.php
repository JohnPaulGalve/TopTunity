<?php
$page_title = "My Profile";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';

// Mock Profile Information
$client_name = "Andrea Santos";
$company = "Kapé Lokal Coffee Co.";
$location = "Quezon City, Metro Manila";
$contact = "+63 917 123 4567";
$about = "We operate local coffee shops providing fresh handcrafted Filipino brew. Looking for talented developers and designers to build our online ordering infrastructure.";
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <div class="card">
    <h2>Client Profile</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 2rem;">Manage your public company and personal profile details[cite: 7, 54].</p>

    <form action="#" method="POST">
      <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--color-border-gray); padding-bottom: 1.5rem;">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--color-disabled-gray); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: bold;">AS</div>
        <div>
          <button type="button" class="btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Upload Photo</button>
          <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-top: 0.4rem;">PNG or JPG up to 2MB.</p>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label for="full_name" style="display: block; font-weight: 600; font-size: 0.9rem;">Full Name</label>
          <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($client_name); ?>" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div>
          <label for="company_name" style="display: block; font-weight: 600; font-size: 0.9rem;">Company / Business Name</label>
          <input type="text" name="company_name" id="company_name" value="<?php echo htmlspecialchars($company); ?>" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label for="location" style="display: block; font-weight: 600; font-size: 0.9rem;">Location</label>
          <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($location); ?>" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div>
          <label for="contact_no" style="display: block; font-weight: 600; font-size: 0.9rem;">Contact Number</label>
          <input type="text" name="contact_no" id="contact_no" value="<?php echo htmlspecialchars($contact); ?>" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label for="about" style="display: block; font-weight: 600; font-size: 0.9rem;">About Company / Business</label>
        <textarea name="about" id="about" rows="4" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"><?php echo htmlspecialchars($about); ?></textarea>
      </div>

      <button type="submit" class="btn-primary">Save Profile Changes</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>