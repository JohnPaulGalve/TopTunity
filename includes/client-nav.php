<?php
/**
 * includes/client-nav.php
 * Sidebar + top bar for the CLIENT and FREELANCER areas (the menu follows $user_role).
 * Pages set before including:
 *   $user_role     'client' | 'freelancer'
 *   $active_client the sidebar key of the current page (see the lists below)
 *   $page_title, $base_url
 * Pages must set $app_shell = true (footer.php closes the shell using it).
 */
$base_url      = isset($base_url) ? $base_url : '/Webdev/';
$active_client = isset($active_client) ? $active_client : '';
$role          = (isset($user_role) && $user_role === 'freelancer') ? 'freelancer' : 'client';
$app_shell     = true;

require_once __DIR__ . '/data.php';

$me = $role === 'freelancer' ? toptunity_current_freelancer() : toptunity_current_client();
$msg_unread = $role === 'client'
    ? count(array_filter(toptunity_client_threads(), function ($t) { return !empty($t['unread']); })) : 0;
$note_new   = $role === 'client'
    ? count(array_filter(toptunity_client_notifications_all(), function ($n) { return !empty($n['new']); })) : 0;

if ($role === 'freelancer') {
    $side_links = [
        'dashboard' => ['freelancer/dashboard.php',   'Freelancer Dashboard', 'home'],
        'find'      => ['freelancer/find-projects.php', 'Find Projects',      'search'],
        'proposals' => ['freelancer/my-proposals.php', 'My Proposals',       'clipboard'],
        'projects'  => ['freelancer/my-projects.php',  'My Projects',         'folder'],
        'earnings'  => ['freelancer/earnings.php',     'Earnings and Withdrawals', 'wallet'],
    ];
    $area = 'freelancer';
    $menu = [
        ['freelancer/profile-edit.php',    'My Profile',        'user'],
        ['freelancer/skills.php',          'Skills',            'check-circle'],
        ['freelancer/portfolio.php',       'Portfolio',         'folder'],
        ['freelancer/my-reviews.php',      'My Reviews',        'star'],
        ['freelancer/saved-projects.php',  'Saved Projects',    'heart'],
        ['freelancer/platform-review.php', 'Platform Review',   'message'],
        ['freelancer/report-dispute.php',  'Report and Dispute','flag'],
        ['freelancer/account-settings.php','Account Settings',  'lock'],
    ];
} else {
    $side_links = [
        'dashboard'   => ['client/dashboard.php',         'Client Dashboard',     'home'],
        'post'        => ['client/post-project.php',      'Post a Project',       'plus-circle'],
        'projects'    => ['client/my-projects.php',       'My Projects',          'folder'],
        'freelancers' => ['client/find-freelancers.php',  'Find Freelancers',     'users'],
        'billing'     => ['client/billing.php',           'Billing and Payments', 'wallet'],
    ];
    $area = 'client';
    $menu = [
        ['client/my-profile.php',       'My Profile',        'user'],
        ['client/my-profile.php#reviews','My Reviews',       'star'],
        ['client/saved-freelancers.php', 'Saved Freelancers', 'heart'],
        ['client/platform-review.php',  'Platform Review',   'message'],
        ['client/report-dispute.php',   'Report and Dispute','flag'],
        ['client/account-settings.php', 'Account Settings',  'lock'],
    ];
}
$home_link = $base_url . ($role === 'freelancer' ? 'freelancer/dashboard.php' : 'client/dashboard.php');
?>
<div class="app-shell">

  <aside class="app-sidebar" aria-label="<?= e(ucfirst($area)) ?> navigation">
    <a href="<?= e($home_link) ?>" class="brand-logo brand-logo--light app-brand">TopTunity<span class="logo-star" aria-hidden="true">&#10022;</span></a>

    <nav class="side-nav">
      <?php foreach ($side_links as $key => $link): ?>
        <a href="<?= e($base_url . $link[0]) ?>" class="<?= $active_client === $key ? 'is-active' : '' ?>"
           <?= $active_client === $key ? 'aria-current="page"' : '' ?>>
          <?= icon($link[2], 17) ?> <?= e($link[1]) ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="side-user">
      <?= avatar($me['bg'], $me['hair'], $me['style'], 34) ?>
      <div>
        <strong><?= e($me['name']) ?></strong>
        <small>Signed in as <?= e(ucfirst($area)) ?></small>
      </div>
    </div>
  </aside>

  <div class="app-main">
    <header class="app-topbar">
      <button class="nav-toggle app-menu-btn" type="button" aria-label="Toggle sidebar" aria-expanded="true"><?= icon('menu', 22) ?></button>

      <div class="topbar-right">
        <a href="<?= e($base_url . $area . '/messages.php') ?>" class="topbar-btn" aria-label="Messages">
          <?= icon('message', 18) ?><?php if ($msg_unread): ?><span class="badge-count"><?= (int) $msg_unread ?></span><?php endif; ?>
        </a>
        <a href="<?= e($base_url . $area . '/notifications.php') ?>" class="topbar-btn" aria-label="Notifications">
          <?= icon('bell', 18) ?><?php if ($note_new): ?><span class="badge-count"><?= (int) $note_new ?></span><?php endif; ?>
        </a>

        <details class="profile-menu">
          <summary class="profile-trigger">
            <?= avatar($me['bg'], $me['hair'], $me['style'], 26) ?>
            My Profile <?= icon('chevron-down', 13) ?>
          </summary>
          <div class="profile-dropdown">
            <?php foreach ($menu as $item): ?>
              <a href="<?= e($base_url . $item[0]) ?>"><?= icon($item[2], 15) ?> <?= e($item[1]) ?></a>
            <?php endforeach; ?>
            <a href="<?= e($base_url) ?>pages/login.php?action=logout" class="is-danger"><?= icon('logout', 15) ?> Logout</a>
          </div>
        </details>
      </div>
    </header>

    <main class="app-content">
      <?php if ($__flash = tt_flash()): ?>
        <div class="form-alert" role="status" style="background:var(--color-success-bg); border-color:#BBF7D0; color:var(--color-success-text); margin:0 0 1.2rem;"><?= icon('check-circle', 15) ?> <?= e($__flash) ?></div>
      <?php endif; ?>