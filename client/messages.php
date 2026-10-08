<?php
/**
 * client/messages.php - Conversations with freelancers.
 * Open a thread with ?c=N (0-based index). Sending is not connected to a database yet.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$me      = toptunity_current_client();
$threads = toptunity_client_threads();

$q      = isset($_GET['q']) ? trim($_GET['q']) : '';
$open   = isset($_GET['c']) ? (int) $_GET['c'] : 0;
if (!isset($threads[$open])) { $open = 0; }
$thread = $threads[$open];

$shown = [];
foreach ($threads as $i => $t) {
    if ($q === '' || stripos($t['name'] . ' ' . $t['project'], $q) !== false) { $shown[$i] = $t; }
}

function msg_url($i, $q)
{
    $p = ['c' => $i];
    if ($q !== '') { $p['q'] = $q; }
    return 'messages.php?' . http_build_query($p);
}

$page_title = "Messages";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Messages</h1>
    <p class="subtle">Talk with your freelancers about projects, proposals and contracts.</p>
  </div>
</div>

<div class="msg-layout">

  <!-- Conversation list -->
  <aside class="convo-pane">
    <form class="convo-search" method="get" action="messages.php" role="search">
      <div class="search-compact" style="width:100%;">
        <?= icon('search', 15) ?>
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search conversations…" aria-label="Search conversations">
      </div>
    </form>

    <div class="convo-list">
      <?php if (!$shown): ?>
        <p class="muted" style="padding:1rem;">No conversations match your search.</p>
      <?php endif; ?>
      <?php foreach ($shown as $i => $t): ?>
        <a href="<?= e(msg_url($i, $q)) ?>" class="convo-item <?= $i === $open ? 'is-active' : '' ?>" style="display:flex; text-decoration:none;">
          <?= avatar($t['bg'], $t['hair'], $t['style'], 36) ?>
          <div class="convo-item__body">
            <div class="convo-item__top">
              <strong><?= e($t['name']) ?><?php if ($t['unread']): ?><span class="unread-dot"></span><?php endif; ?></strong>
              <time><?= e($t['time']) ?></time>
            </div>
            <small><?= e($t['project']) ?></small>
            <p><?= e($t['preview']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </aside>

  <!-- Chat -->
  <section class="chat-pane">
    <header class="chat-head">
      <div>
        <strong><?= e($thread['name']) ?></strong>
        <small>Conversation · <a href="project-tracking.php?id=<?= (int) $thread['project_id'] ?>"><?= e($thread['project']) ?> · View Project</a></small>
      </div>
      <a href="#" class="btn btn--row-outline"><?= icon('flag', 13) ?> Report User</a>
    </header>

    <div class="chat-body">
      <div class="day-tag">Today</div>
      <?php foreach ($thread['messages'] as $m): ?>
        <?php if (!empty($m['file'])): ?>
          <div class="bubble-row bubble-row--<?= $m['from'] === 'me' ? 'me' : 'them' ?>">
            <div class="bubble-file"><?= icon('file', 18) ?><span><?= e($m['file']['name']) ?></span><small><?= e($m['file']['size']) ?></small></div>
            <div class="bubble" style="margin-top:0.4rem;"><?= e($m['text']) ?></div>
            <span class="bubble-time"><?= e($m['time']) ?></span>
          </div>
        <?php else: ?>
          <div class="bubble-row bubble-row--<?= $m['from'] === 'me' ? 'me' : 'them' ?>">
            <div class="bubble"><?= e($m['text']) ?></div>
            <span class="bubble-time"><?= e($m['time']) ?></span>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <form class="composer" method="post" action="">
      <textarea name="message" placeholder="Write a message…" rows="1" aria-label="Write a message"></textarea>
      <button type="submit" class="btn btn--primary"><?= icon('send', 14) ?> Send</button>
    </form>
    <p class="msg-foot"><?= icon('lock', 11) ?> Messages are saved securely. The administrator can only view them when they are part of a report or dispute.</p>
  </section>

</div>

</main>

<?php include '../includes/footer.php'; ?>