<?php
/**
 * admin/notifications.php - Admin notifications with filter tabs (matches the Notifications design).
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

if (isset($_GET['open'])) {
    $target = tt_open_notification((string) $_GET['open'], 'admin');
    if ($target) { header('Location: ' . $target); exit; }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_all'])) {
    tt_mark_demo_notifications_read();
    tt_mark_all_read();
    tt_flash('All notifications marked as read.');
    header('Location: ' . $base_url . 'admin/notifications.php');
    exit;
}

$all  = toptunity_admin_notifications();
$tabs = ['all' => 'All', 'past' => 'Projects Past Deadline', 'reports' => 'New Reports', 'disputes' => 'Disputes',
         'withdrawals' => 'Withdrawal Requests', 'inquiries' => 'Inquiries', 'reviews' => 'New Platform Reviews'];
$cat  = isset($_GET['cat']) && isset($tabs[$_GET['cat']]) ? $_GET['cat'] : 'all';
$rows = array_values(array_filter($all, function ($n) use ($cat) { return $cat === 'all' || $n['cat'] === $cat; }));
$unread = count(array_filter($all, function ($n) { return $n['new']; }));

$page_title = "Notifications";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Notifications</h1>
    <p class="subtle">You have <?= (int) $unread ?> unread notification<?= $unread === 1 ? '' : 's' ?>.</p>
  </div>
  <form method="post" action="notifications.php" style="margin:0;">
    <button type="submit" name="mark_all" value="1" class="btn-link-teal"><?= icon('zap', 14) ?> Mark all as read</button>
  </form>
</div>

<nav class="notif-tabs" aria-label="Filter notifications" style="margin-top:1.25rem;">
  <?php foreach ($tabs as $key => $label): ?>
    <a href="notifications.php<?= $key === 'all' ? '' : '?cat=' . e($key) ?>" class="filter-tab <?= $cat === $key ? 'is-active' : '' ?>"><?= e($label) ?></a>
  <?php endforeach; ?>
</nav>

<div class="notif-list-card">
  <?php if (!$rows): ?>
    <div class="empty-state empty-state--design" style="border:0; border-radius:0;"><div class="empty-art"><?= icon('bell', 40) ?></div><h3>No notifications here</h3><p>New activity in this category will show up here.</p></div>
  <?php endif; ?>
  <?php foreach ($rows as $n): ?>
    <div class="notif-row <?= $n['new'] ? 'notif-row--unread' : '' ?>"<?php if (tt_notification_link('admin', $n['cat'])): ?> data-href="<?= e('notifications.php?open=' . tt_notification_key($n)) ?>"<?php endif; ?>>
      <span class="icon-box icon-box--<?= e($n['tint']) ?>"><?= icon($n['icon'], 16) ?></span>
      <div class="notif-row__body">
        <strong><?= e($n['title']) ?></strong>
        <?php if ($n['new']): ?><span class="status status--ongoing" style="margin-left:0.4rem; padding:0.1rem 0.5rem;">New</span><?php endif; ?>
        <p><?= e($n['text']) ?></p>
      </div>
      <time><?= e($n['time']) ?></time>
      <?php if ($n['new']): ?><span class="unread-dot" aria-label="Unread"></span><?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>

</main>

<?php include '../includes/footer.php'; ?>