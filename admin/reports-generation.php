<?php
$page_title = "Reports Generation";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <div class="card">
    <h2>Reports & Data Export</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 2rem;">Generate and export operational reports for platform accounting and oversight[cite: 10, 78].</p>

    <form action="#" method="POST">
      <div style="margin-bottom: 1rem;">
        <label for="report_type" style="display: block; font-weight: 600; font-size: 0.9rem;">Select Report Module</label>
        <select name="report_type" id="report_type" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
          <option value="financial">Financial & 10% Revenue Fee Log</option>
          <option value="users">Registered Client & Freelancer Accounts</option>
          <option value="projects">Project Postings & Status Summary</option>
          <option value="disputes">Dispute Resolution History</option>
        </select>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label for="start_date" style="display: block; font-weight: 600; font-size: 0.9rem;">Start Date</label>
          <input type="date" name="start_date" id="start_date" value="2026-01-01" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div>
          <label for="end_date" style="display: block; font-weight: 600; font-size: 0.9rem;">End Date</label>
          <input type="date" name="end_date" id="end_date" value="2026-10-08" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label for="export_format" style="display: block; font-weight: 600; font-size: 0.9rem;">Export Format</label>
        <div style="display: flex; gap: 1.5rem; margin-top: 0.4rem;">
          <label><input type="radio" name="export_format" value="pdf" checked> PDF Document</label>
          <label><input type="radio" name="export_format" value="csv"> CSV Spreadsheet</label>
        </div>
      </div>

      <button type="submit" class="btn-primary">Generate & Download Report</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>