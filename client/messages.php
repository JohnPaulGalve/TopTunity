<?php
$page_title = "Messages";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
  <h2>Messages</h2>
  <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Communicate with freelancers about projects, proposals, and contracts[cite: 7, 51].</p>

  <!-- Dual-Pane Chat Layout -->
  <div class="card" style="display: grid; grid-template-columns: 300px 1fr; gap: 0; padding: 0; overflow: hidden; min-height: 550px;">
    
    <!-- Left Pane: Conversation List -->
    <div style="border-right: 1px solid var(--color-border-gray); background: var(--color-off-white);">
      <div style="padding: 1rem; border-bottom: 1px solid var(--color-border-gray);">
        <input type="text" placeholder="Search conversations..." style="width: 100%; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px; font-size: 0.85rem;">
      </div>
      <div style="display: flex; flex-direction: column;">
        <!-- Active Chat Item -->
        <div style="padding: 1rem; border-bottom: 1px solid var(--color-border-gray); background: #FFF; border-left: 4px solid var(--color-vibrant-teal); cursor: pointer;">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong>Miguel Reyes</strong>
            <small style="color: var(--color-muted-gray); font-size: 0.75rem;">10:42 AM</small>
          </div>
          <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-top: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Attached the updated menu layout preview.</p>
        </div>

        <!-- Inactive Chat Item -->
        <div style="padding: 1rem; border-bottom: 1px solid var(--color-border-gray); cursor: pointer;">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong>Bea Lim</strong>
            <small style="color: var(--color-muted-gray); font-size: 0.75rem;">Yesterday</small>
          </div>
          <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-top: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Thanks! I'll review the Figma prototype shortly.</p>
        </div>
      </div>
    </div>

    <!-- Right Pane: Active Message Thread -->
    <div style="display: flex; flex-direction: column; justify-content: space-between; background: #FFF;">
      <!-- Thread Header -->
      <div style="padding: 1rem; border-bottom: 1px solid var(--color-border-gray); display: flex; justify-content: space-between; align-items: center;">
        <div>
          <h3 style="font-size: 1.1rem; margin: 0;">Miguel Reyes</h3>
          <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Project: Online Ordering Website for a Coffee Shop[cite: 51, 91]</p>
        </div>
        <a href="<?php echo $base_url; ?>client/report-dispute.php?user=MiguelReyes" style="font-size: 0.8rem; color: var(--color-error-base);">Report User</a>
      </div>

      <!-- Message History Feed -->
      <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; overflow-y: auto; max-height: 380px;">
        <!-- Incoming Message -->
        <div style="align-self: flex-start; max-width: 70%; background: var(--color-off-white); border: 1px solid var(--color-border-gray); padding: 0.8rem; border-radius: 8px;">
          <p style="font-size: 0.9rem;">Hello Andrea! I have finished setting up the menu categories for Kapé Lokal[cite: 51, 91]. Please check the file below.</p>
          <small style="color: var(--color-muted-gray); font-size: 0.75rem; display: block; margin-top: 0.4rem;">10:30 AM</small>
        </div>

        <!-- Outgoing Message -->
        <div style="align-self: flex-end; max-width: 70%; background: var(--color-deep-slate); color: #FFF; padding: 0.8rem; border-radius: 8px;">
          <p style="font-size: 0.9rem;">Looks great! Thanks for sending this over. I will review it with our staff today[cite: 51].</p>
          <small style="color: var(--color-disabled-gray); font-size: 0.75rem; display: block; margin-top: 0.4rem; text-align: right;">10:42 AM</small>
        </div>
      </div>

      <!-- Message Input Form -->
      <form action="#" method="POST" style="padding: 1rem; border-top: 1px solid var(--color-border-gray); display: flex; gap: 0.5rem; align-items: center;">
        <label class="btn-outline" style="padding: 0.6rem 0.8rem; font-size: 0.85rem; cursor: pointer;">
          📎 Attach
          <input type="file" name="attachment" id="attachment" style="display: none;">
        </label>
        <input type="text" name="message" placeholder="Type a message..." required style="flex: 1; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px; font-size: 0.9rem;">
        <button type="submit" class="btn-primary">Send</button>
      </form>
    </div>

  </div>
</div>

<?php include '../includes/footer.php'; ?>