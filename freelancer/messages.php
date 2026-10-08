<?php
$page_title = "Messages";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
  <h2>Messages</h2>
  <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Direct chat communication threads with client accounts[cite: 9, 72].</p>

  <!-- Dual-Pane Interface -->
  <div class="card" style="display: grid; grid-template-columns: 300px 1fr; gap: 0; padding: 0; overflow: hidden; min-height: 550px;">
    
    <!-- Left List -->
    <div style="border-right: 1px solid var(--color-border-gray); background: var(--color-off-white);">
      <div style="padding: 1rem; border-bottom: 1px solid var(--color-border-gray);">
        <input type="text" placeholder="Search client chats..." style="width: 100%; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px; font-size: 0.85rem;">
      </div>
      <div style="padding: 1rem; border-bottom: 1px solid var(--color-border-gray); background: #FFF; border-left: 4px solid var(--color-vibrant-teal); cursor: pointer;">
        <div style="display: flex; justify-content: space-between;">
          <strong>Andrea Santos</strong>
          <small style="color: var(--color-muted-gray); font-size: 0.75rem;">10:42 AM</small>
        </div>
        <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-top: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Looks great! Thanks for sending this over.</p>
      </div>
    </div>

    <!-- Right Thread -->
    <div style="display: flex; flex-direction: column; justify-content: space-between; background: #FFF;">
      <div style="padding: 1rem; border-bottom: 1px solid var(--color-border-gray); display: flex; justify-content: space-between; align-items: center;">
        <div>
          <h3 style="font-size: 1.1rem; margin: 0;">Andrea Santos</h3>
          <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Client • Kapé Lokal Coffee Co.[cite: 92]</p>
        </div>
        <a href="<?php echo $base_url; ?>freelancer/report-dispute.php?user=AndreaSantos" style="font-size: 0.8rem; color: var(--color-error-base);">Report Client</a>
      </div>

      <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; overflow-y: auto; max-height: 380px;">
        <div style="align-self: flex-end; max-width: 70%; background: var(--color-deep-slate); color: #FFF; padding: 0.8rem; border-radius: 8px;">
          <p style="font-size: 0.9rem;">Hello Andrea! I have finished setting up the menu categories for Kapé Lokal[cite: 91].</p>
          <small style="color: var(--color-disabled-gray); font-size: 0.75rem; display: block; margin-top: 0.4rem; text-align: right;">10:30 AM</small>
        </div>

        <div style="align-self: flex-start; max-width: 70%; background: var(--color-off-white); border: 1px solid var(--color-border-gray); padding: 0.8rem; border-radius: 8px;">
          <p style="font-size: 0.9rem;">Looks great! Thanks for sending this over. I will review it with our staff today.</p>
          <small style="color: var(--color-muted-gray); font-size: 0.75rem; display: block; margin-top: 0.4rem;">10:42 AM</small>
        </div>
      </div>

      <form action="#" method="POST" style="padding: 1rem; border-top: 1px solid var(--color-border-gray); display: flex; gap: 0.5rem;">
        <input type="text" name="message" placeholder="Type your response..." required style="flex: 1; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px; font-size: 0.9rem;">
        <button type="submit" class="btn-primary">Send Message</button>
      </form>
    </div>

  </div>
</div>

<?php include '../includes/footer.php'; ?>