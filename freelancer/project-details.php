<?php
$page_title = "Project Workspace & Hour Log";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <div class="card" style="margin-bottom: 2rem;">
    <span class="badge badge-success">Ongoing Contract</span>
    <h2 style="margin-top: 0.5rem;">Student Enrollment System for Tutorial Center</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem;">Client: Ramon Villanueva • Rate: ₱500/hr • Maximum: 80 hrs[cite: 8, 94]</p>
  </div>

  <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem;">
    <main>
      <!-- Hour Logging Engine -->
      <div class="card" style="margin-bottom: 2rem;">
        <h3>Work Log (Log Hours)</h3>
        <p style="font-size: 0.85rem; color: var(--color-muted-gray); margin-bottom: 1.5rem;">Record hours between Start Date and End Date[cite: 8, 9, 62].</p>

        <form action="#" method="POST" style="margin-bottom: 2rem; background: var(--color-off-white); padding: 1rem; border-radius: 4px; border: 1px solid var(--color-border-gray);">
          <div style="display: grid; grid-template-columns: 120px 100px 1fr; gap: 0.5rem; margin-bottom: 1rem;">
            <div>
              <label style="font-size: 0.8rem; font-weight: 600;">Date</label>
              <input type="date" name="log_date" required style="width: 100%; padding: 0.4rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
            </div>
            <div>
              <label style="font-size: 0.8rem; font-weight: 600;">Hours</label>
              <input type="number" step="0.5" name="log_hours" placeholder="4.0" required style="width: 100%; padding: 0.4rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
            </div>
            <div>
              <label style="font-size: 0.8rem; font-weight: 600;">Task Summary</label>
              <input type="text" name="log_task" placeholder="e.g. Developed student intake registration form" required style="width: 100%; padding: 0.4rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
            </div>
          </div>
          <button type="submit" class="btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Log Hours</button>
        </form>

        <!-- Logged Table -->
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
          <thead>
            <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
              <th style="padding: 0.5rem;">Date</th>
              <th style="padding: 0.5rem;">Hours</th>
              <th style="padding: 0.5rem;">Task Description</th>
              <th style="padding: 0.5rem;">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.5rem;">Oct 05, 2026</td>
              <td style="padding: 0.5rem;">5.0</td>
              <td style="padding: 0.5rem;">Database setup for review classes[cite: 94]</td>
              <td style="padding: 0.5rem;"><span class="badge badge-success">Approved</span>[cite: 62]</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Deliverables Submission Form -->
      <div class="card">
        <h3>Submit Finished Deliverables</h3>
        <form action="#" method="POST" style="margin-top: 1rem;">
          <div style="margin-bottom: 1rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 600;">Delivery Message</label>
            <textarea name="submission_notes" rows="3" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
          </div>
          <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 600;">Attach ZIP / PDF Files</label>
            <input type="file" name="submission_file" required style="font-size: 0.85rem;">
          </div>
          <button type="submit" class="btn-primary">Submit Completed Work</button>
        </form>
      </div>
    </main>

    <!-- Side Workspace Box -->
    <aside style="display: flex; flex-direction: column; gap: 1.5rem;">
      <div class="card">
        <h3>Hourly Summary</h3>
        <p style="font-size: 0.9rem; margin-top: 0.5rem;"><strong>Hours Logged:</strong> 5.0 / 80 hrs</p>
        <p style="font-size: 0.9rem;"><strong>Approved Hours:</strong> 5.0 hrs</p>
        <p style="font-size: 1.2rem; font-weight: 700; color: var(--color-vibrant-teal); margin-top: 0.5rem;">Gross Billed: ₱2,500</p>
        <small style="color: var(--color-muted-gray);">Billed on deadline minus 10% platform service fee[cite: 8, 9, 92].</small>
      </div>
    </aside>
  </div>
</div>

<?php include '../includes/footer.php'; ?>