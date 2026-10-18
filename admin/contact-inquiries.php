<?php
/**
 * admin/contact-inquiries.php - Messages sent from the Contact Us page (matches the Contact Inquiries design).
 * Sending a reply is not connected to an email service yet.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "inquiries";

require_once __DIR__ . '/../includes/data.php';

$all  = toptunity_admin_inquiries();
$want = isset($_GET['id']) ? $_GET['id'] : '';
$sel  = null;
foreach ($all as $i) { if ($i['id'] === $want) { $sel = $i; } }
if (!$sel && $all) { $sel = $all[0]; }

$errors = [];
$reply  = isset($_POST['reply']) ? trim($_POST['reply']) : ($sel ? 'Hi ' . explode(' ', $sel['name'])[0] . '! ' : '');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $sel) {
    if (!empty($sel['real'])) {
        $err = tt_reply_contact_inquiry((int) substr($sel['id'], 2), $reply);
        if ($err) { $errors[] = $err; }
    } elseif (mb_strlen($reply) < 10) {
        $errors[] = 'Write a reply of at least 10 characters.';
    } else {
        $_SESSION['demo_admin_inquiry_replies'][$sel['id']] = $reply;
    }
    if (!$errors) {
        tt_flash(!empty($sel['real']) ? 'Your response was saved. Send it to the contact by email.' : 'Demo response recorded for preview.');
        header('Location: ' . $base_url . 'admin/contact-inquiries.php?id=' . urlencode($sel['id']));
        exit;
    }
}

$page_title = "Contact Inquiries";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Contact Inquiries</h1>
    <p class="subtle">Messages sent from the Contact Us page.</p>
  </div>
</div>

<div class="admin-layout">
  <section class="admin-list">
    <p class="section-tag" style="padding:0.9rem 1rem 0;">Inquiry list</p>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Date</th><th>Name</th><th>Subject</th><th>Status</th></tr></thead>
        <tbody>
          <?php if (!$all): ?><tr><td colspan="4" class="muted" style="text-align:center; padding:1.2rem;">No contact inquiries are available.</td></tr><?php endif; ?>
          <?php foreach ($all as $i): ?>
            <tr class="<?= $i['id'] === $sel['id'] ? 'is-selected' : '' ?>">
              <td><?= e($i['date']) ?></td>
              <td><a href="contact-inquiries.php?id=<?= e($i['id']) ?>"><strong><?= e($i['name']) ?></strong></a></td>
              <td><?= e($i['subject']) ?></td>
              <td><span class="status status--<?= $i['status'] === 'new' ? 'ongoing' : 'released' ?>"><?= e($i['status'] === 'new' ? 'New' : 'Responded') ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <aside class="admin-side">
    <?php if (!$sel): ?>
      <h2>Inquiry Details</h2><p class="muted">There are no inquiries to respond to.</p>
    <?php else: ?>
    <h2>Inquiry Details</h2>
    <div class="kv"><span>From</span><strong style="font-size:0.72rem;"><?= e($sel['email']) ?></strong></div>
    <div class="kv"><span>Subject</span><strong><?= e($sel['subject']) ?></strong></div>
    <div class="quote-box" style="margin-top:0.7rem;">“<?= e($sel['message']) ?>”</div>
    <?php if (!empty($sel['reply'])): ?><p class="note-line" style="margin-top:0.7rem;"><strong>Saved response:</strong> <?= e($sel['reply']) ?></p><?php endif; ?>

    <form method="post" action="contact-inquiries.php?id=<?= e($sel['id']) ?>" style="margin-top:0.8rem;">
      <?php if ($errors): ?><div class="form-alert" role="alert" style="margin:0 0 0.5rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div><?php endif; ?>
      <textarea name="reply" class="input" rows="5" minlength="10" style="height:auto; padding:0.7rem; font-size:0.8rem; border-color:var(--color-vibrant-teal);"><?= e($reply) ?></textarea>
      <button type="submit" class="btn btn--primary btn--block" style="margin-top:0.6rem;">↩ Save Response</button>
    </form>
    <?php endif; ?>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>