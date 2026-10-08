<?php
$page_title = "Report & File Dispute";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 700px;">
  <div class="card">
    <h2>Report Content or File Dispute</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Submit an issue or project dispute for administrative moderation review[cite: 7, 56].</p>

    <!-- Tab Switching -->
    <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-border-gray); padding-bottom: 0.5rem;">
      <button class="tab-btn active" data-tab="report" data-group="dispute">Report User / Content</button>
      <button class="tab-btn" data-tab="dispute" data-group="dispute">File Project Dispute</button>
    </div>

    <!-- Form 1: Report User -->
    <div id="report" class="tab-content" data-group="dispute" style="display: block;">
      <form action="#" method="POST">
        <div style="margin-bottom: 1rem;">
          <label for="report_type" style="display: block; font-weight: 600; font-size: 0.9rem;">What are you reporting?</label>
          <select name="report_type" id="report_type" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
            <option value="user">User Profile</option>
            <option value="messages">Chat / Messages</option>
          </select>
        </div>
        <div style="margin-bottom: 1.5rem;">
          <label for="report_reason" style="display: block; font-weight: 600; font-size: 0.9rem;">Reason & Details</label>
          <textarea name="report_reason" id="report_reason" rows="4" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
        </div>
        <button type="submit" class="btn-primary">Submit Report</button>
      </form>
    </div>

    <!-- Form 2: File Dispute -->
    <div id="dispute" class="tab-content" data-group="dispute" style="display: none;">
      <form action="#" method="POST">
        <div style="margin-bottom: 1rem;">
          <label for="dispute_project" style="display: block; font-weight: 600; font-size: 0.9rem;">Select Ongoing Project</label>
          <select name="dispute_project" id="dispute_project" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
            <option value="101">Online Ordering Website for a Coffee Shop</option>
          </select>
        </div>
        <div style="margin-bottom: 1.5rem;">
          <label for="dispute_details" style="display: block; font-weight: 600; font-size: 0.9rem;">Dispute Explanation</label>
          <textarea name="dispute_details" id="dispute_details" rows="5" required placeholder="Explain why you are filing a dispute regarding escrow funds or work quality..." style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
        </div>
        <button type="submit" class="btn-primary" style="background: var(--color-error-base);">Submit Dispute to Administrator</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>