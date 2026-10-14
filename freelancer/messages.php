<?php
/**
 * freelancer/messages.php - Matches the Messages design. Sending is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$threads = toptunity_freelancer_threads();
$q       = isset($_GET['q']) ? trim($_GET['q']) : '';
$open    = isset($_GET['c']) ? (int) $_GET['c'] : 0;
if (!isset($threads[$open])) { $open = 0; }
if (isset($_GET['with'])) {
    foreach ($threads as $ti => $tt) { if (!empty($tt['real']) && (int) $tt['with'] === (int) $_GET['with']) { $open = $ti; } }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $t = $threads[$open] ?? null;
    if ($t && !empty($t['real'])) {
        $err = tt_send_message($t['with'], $_POST['message']);
        tt_flash($err ? 'Could not send: ' . $err : 'Message sent.');
        header('Location: ' . $base_url . 'freelancer/messages.php?with=' . (int) $t['with']);
    } else {
        $dk = 'demo_' . (int) tt_current_user()['id'];
        $key = ($threads[$open]['name'] ?? '') . '|' . ($threads[$open]['project_id'] ?? 0);
        $body = trim($_POST['message']);
        if ($body !== '' && mb_strlen($body) <= 2000) {
            $_SESSION[$dk][$key][] = ['from' => 'me', 'text' => $body, 'time' => 'Just now'];
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
    exit;
}
if (!empty($threads[$open]['real'])) { tt_mark_thread_read($threads[$open]['with']); }

$thread  = $threads ? $threads[$open] : null;
if ($thread && empty($thread['real'])) {
    $dk = 'demo_' . (int) tt_current_user()['id'];
    $key = $thread['name'] . '|' . ($thread['project_id'] ?? 0);
    if (!empty($_SESSION[$dk][$key])) { $thread['messages'] = array_merge($thread['messages'], $_SESSION[$dk][$key]); }
}

$shown = [];
foreach ($threads as $i => $t) {
    if ($q === '' || stripos($t['name'] . ' ' . $t['project'], $q) !== false) { $shown[$i] = $t; }
}

$page_title = "Messages";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Messages</h1>
    <p class="subtle">Talk with your clients about projects, proposals and contracts.</p>
  </div>
</div>

<div class="msg-layout" style="margin-top:1.25rem;">
  <aside class="convo-pane">
    <form class="convo-search" method="get" action="messages.php" role="search">
      <div class="search-compact" style="width:100%;">
        <?= icon('search', 15) ?>
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search Conversations…" aria-label="Search conversations">
      </div>
    </form>
    <div class="convo-list">
      <?php if (!$shown): ?><p class="muted" style="padding:1rem;">No conversations yet.</p><?php endif; ?>
      <?php foreach ($shown as $i => $t): ?>
        <a href="messages.php?c=<?= (int) $i ?><?= $q !== '' ? '&amp;q=' . e(urlencode($q)) : '' ?>" class="convo-item <?= $i === $open ? 'is-active' : '' ?>" style="display:flex; text-decoration:none;">
          <?= avatar($t['bg'], $t['hair'], $t['style'], 36) ?>
          <div class="convo-item__body">
            <div class="convo-item__top"><strong><?= e($t['name']) ?><?php if ($t['unread']): ?><span class="unread-dot"></span><?php endif; ?></strong><time><?= e($t['time']) ?></time></div>
            <small><?= e($t['project']) ?></small>
            <p><?= e($t['preview']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </aside>

  <?php if (!$thread): ?>
    <section class="chat-pane" style="align-items:center; justify-content:center;">
      <div class="empty-state empty-state--design" style="border:0;">
        <div class="empty-art"><?= icon('message', 40) ?></div>
        <h3>No conversations yet</h3>
        <p>Messages with clients will appear here once you work with them.</p>
      </div>
    </section>
  <?php else: ?>
    <section class="chat-pane">
      <header class="chat-head">
        <div style="display:flex; align-items:center; gap:0.7rem;">
          <?= avatar($thread['bg'], $thread['hair'], $thread['style'], 34) ?>
          <div>
            <strong><?= e($thread['name']) ?></strong>
            <small>Conversation · <a href="project-details.php?id=201"><?= e($thread['project']) ?> · View Project</a></small>
          </div>
        </div>
        <a href="report-dispute.php" class="btn btn--row-outline"><?= icon('flag', 13) ?> Report User</a>
      </header>
      <div class="chat-body">
        <div class="day-tag">Today</div>
        <?php foreach ($thread['messages'] as $m): ?>
          <div class="bubble-row bubble-row--<?= $m['from'] === 'me' ? 'me' : 'them' ?>">
            <?php if (!empty($m['file'])): ?>
              <div class="bubble-file"><?= icon('file', 18) ?><span><?= e($m['file']['name']) ?></span><small><?= e($m['file']['size']) ?></small></div>
            <?php endif; ?>
            <div class="bubble" style="<?= !empty($m['file']) ? 'margin-top:0.4rem;' : '' ?>"><?= e($m['text']) ?></div>
            <span class="bubble-time"><?= e($m['time']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <form class="composer" method="post" action="">
        <textarea name="message" placeholder="Write a message…" rows="1" aria-label="Write a message"></textarea>
        <button type="submit" class="btn btn--primary"><?= icon('send', 14) ?> Send</button>
      </form>
      <p class="msg-foot"><?= icon('lock', 11) ?> Messages are saved securely. The administrator can only view them when they are part of a report or dispute.</p>
    </section>
  <?php endif; ?>
</div>

</main>

<?php include '../includes/footer.php'; ?>