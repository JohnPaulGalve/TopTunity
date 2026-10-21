<?php
/**
 * includes/client-nav.php
 * Sidebar + top bar for the CLIENT, FREELANCER and ADMIN areas (the menu follows $user_role).
 * Pages set before including:
 *   $user_role     'client' | 'freelancer' | 'admin'
 *   $active_client the sidebar key of the current page
 *   $page_title, $base_url
 * Pages must set $app_shell = true (footer.php closes the shell using it).
 */
$base_url      = isset($base_url) ? $base_url : '/TopTunity/';
$active_client = isset($active_client) ? $active_client : '';
$role          = (isset($user_role) && in_array($user_role, ['freelancer', 'admin'], true)) ? $user_role : 'client';
$app_shell     = true;

require_once __DIR__ . '/data.php';

$me = $role === 'freelancer' ? toptunity_current_freelancer()
    : ($role === 'admin' ? toptunity_current_admin() : toptunity_current_client());
$msg_unread = $role === 'client'
    ? count(array_filter(toptunity_client_threads(), function ($t) { return !empty($t['unread']); }))
    : ($role === 'freelancer'
        ? count(array_filter(toptunity_freelancer_threads(), function ($t) { return !empty($t['unread']); })) : 0);
$note_new = $role === 'client'
    ? count(array_filter(toptunity_client_notifications_all(), function ($n) { return !empty($n['new']); }))
    : count(array_filter(toptunity_freelancer_notifications(), function ($n) { return !empty($n['new']); }));
if ($role === 'admin') {
    $note_new = count(array_filter(toptunity_admin_notifications(), function ($n) { return !empty($n['new']); }));
}

/* Sidebar links: [file, label, icon]. Admin uses grouped sections. */
if ($role === 'admin') {
    $area = 'admin';
    $admin_groups = [
        ['label' => null, 'links' => [
            'dashboard' => ['admin/dashboard.php', 'Admin Dashboard', 'home'],
        ]],
        ['label' => 'Users', 'icon' => 'users', 'links' => [
            'users'    => ['admin/user-management.php', 'User Management', null],
            'reported' => ['admin/reported-content.php', 'Reported Content', null],
            'activity' => ['admin/activity-log.php', 'Activity Log', null],
        ]],
        ['label' => 'Projects', 'icon' => 'folder', 'links' => [
            'projects' => ['admin/project-moderation.php', 'Project Management and Moderation', null],
            'skills'   => ['admin/skills-categories.php', 'Skills and Categories Management', null],
            'disputes' => ['admin/dispute-management.php', 'Dispute Management', null],
        ]],
        ['label' => 'Payments', 'icon' => 'wallet', 'links' => [
            'payments' => ['admin/payments.php', 'Payments and Transactions', null],
            'withdraw' => ['admin/withdrawal-requests.php', 'Withdrawal Requests', null],
        ]],
        ['label' => 'Feedback', 'icon' => 'message', 'links' => [
            'reviews'   => ['admin/platform-reviews.php', 'Platform Reviews and Testimonials', null],
            'inquiries' => ['admin/contact-inquiries.php', 'Contact Inquiries', null],
        ]],
    ];
    $menu = [
        ['admin/account-settings.php', 'Account Settings', 'user'],
        ['admin/platform-settings.php', 'Platform Settings', 'settings'],
    ];
    $home_link = $base_url . 'admin/dashboard.php';
} elseif ($role === 'freelancer') {
    $area = 'freelancer';
    $side_links = [
        'dashboard' => ['freelancer/dashboard.php',   'Freelancer Dashboard', 'home'],
        'find'      => ['freelancer/find-projects.php', 'Find Projects',      'search'],
        'proposals' => ['freelancer/my-proposals.php', 'My Proposals',       'clipboard'],
        'projects'  => ['freelancer/my-projects.php',  'My Projects',         'folder'],
        'earnings'  => ['freelancer/earnings.php',     'Earnings and Withdrawals', 'wallet'],
    ];
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
    $home_link = $base_url . 'freelancer/dashboard.php';
} else {
    $area = 'client';
    $side_links = [
        'dashboard'   => ['client/dashboard.php',         'Client Dashboard',     'home'],
        'post'        => ['client/post-project.php',      'Post a Project',       'plus-circle'],
        'projects'    => ['client/my-projects.php',       'My Projects',          'folder'],
        'freelancers' => ['client/find-freelancers.php',  'Find Freelancers',     'users'],
        'billing'     => ['client/billing.php',           'Billing and Payments', 'wallet'],
    ];
    $menu = [
        ['client/my-profile.php',       'My Profile',        'user'],
        ['client/my-profile.php#reviews','My Reviews',       'star'],
        ['client/saved-freelancers.php', 'Saved Freelancers', 'heart'],
        ['client/platform-review.php',  'Platform Review',   'message'],
        ['client/report-dispute.php',   'Report and Dispute','flag'],
        ['client/account-settings.php', 'Account Settings',  'lock'],
    ];
    $home_link = $base_url . 'client/dashboard.php';
}
?>
<div class="app-shell">

  <aside class="app-sidebar" aria-label="<?= e(ucfirst($area)) ?> navigation">
    <a href="<?= e($home_link) ?>" class="brand-logo brand-logo--light app-brand" aria-label="TopTunity home">
      <img src="<?= e(tt_image_url($base_url, 'images/Logo/logo-wordmark-white.svg')) ?>" alt="TopTunity" class="brand-logo__image">
    </a>

    <?php if ($role === 'admin'): ?>
      <nav class="side-nav side-nav--admin">
        <?php foreach ($admin_groups as $group): ?>
          <?php if ($group['label'] === null): ?>
            <?php foreach ($group['links'] as $key => $link): ?>
              <a href="<?= e($base_url . $link[0]) ?>" class="<?= $active_client === $key ? 'is-active' : '' ?>" <?= $active_client === $key ? 'aria-current="page"' : '' ?>><?= icon($link[2], 17) ?> <?= e($link[1]) ?></a>
            <?php endforeach; ?>
          <?php else: ?>
            <?php
              $group_id = 'admin-nav-' . strtolower(preg_replace('/[^a-z0-9]+/i', '-', $group['label']));
              $group_active = in_array($active_client, array_keys($group['links']), true);
            ?>
            <div class="side-group<?= $group_active ? ' is-open' : '' ?>">
              <button type="button" class="side-group__toggle" aria-expanded="<?= $group_active ? 'true' : 'false' ?>" aria-controls="<?= e($group_id) ?>">
                <?= icon($group['icon'], 15) ?><span><?= e($group['label']) ?></span><?= icon('chevron-down', 14) ?>
              </button>
              <div class="side-group__items" id="<?= e($group_id) ?>"<?= $group_active ? '' : ' hidden' ?>>
                <?php foreach ($group['links'] as $key => $link): ?>
                  <a href="<?= e($base_url . $link[0]) ?>" class="side-sub <?= $active_client === $key ? 'is-active' : '' ?>" <?= $active_client === $key ? 'aria-current="page"' : '' ?>><?= e($link[1]) ?></a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </nav>
    <?php else: ?>
      <nav class="side-nav">
        <?php foreach ($side_links as $key => $link): ?>
          <a href="<?= e($base_url . $link[0]) ?>" class="<?= $active_client === $key ? 'is-active' : '' ?>"
             <?= $active_client === $key ? 'aria-current="page"' : '' ?>>
            <?= icon($link[2], 17) ?> <?= e($link[1]) ?>
          </a>
        <?php endforeach; ?>
      </nav>
    <?php endif; ?>

    <div class="side-user">
      <?= tt_avatar_html($me, 34, $base_url) ?>
      <div>
        <strong><?= e($me['name']) ?></strong>
        <small><?= $role === 'admin' ? 'Signed in as Administrator' : 'Signed in as ' . e(ucfirst($area)) ?></small>
      </div>
    </div>
  </aside>

  <div class="app-main">
    <header class="app-topbar">
      <button class="nav-toggle app-menu-btn" type="button" aria-label="Toggle sidebar" aria-expanded="true"><?= icon('menu', 22) ?></button>

      <div class="topbar-right">
        <?php if ($role !== 'admin'): ?>
        <a href="<?= e($base_url . $area . '/messages.php') ?>" class="topbar-btn" aria-label="Messages">
          <?= icon('message', 18) ?><?php if ($msg_unread): ?><span class="badge-count"><?= (int) $msg_unread ?></span><?php endif; ?>
        </a>
        <?php endif; ?>
        <a href="<?= e($base_url . $area . '/notifications.php') ?>" class="topbar-btn" aria-label="Notifications">
          <?= icon('bell', 18) ?><?php if ($note_new): ?><span class="badge-count"><?= (int) $note_new ?></span><?php endif; ?>
        </a>

        <details class="profile-menu">
          <summary class="profile-trigger">
            <?= tt_avatar_html($me, 26, $base_url) ?>
            <?= $role === 'admin' ? 'Account Settings' : 'My Profile' ?> <?= icon('chevron-down', 13) ?>
          </summary>
          <div class="profile-dropdown">
            <?php foreach ($menu as $item): ?>
              <a href="<?= e($base_url . $item[0]) ?>"><?= icon($item[2], 15) ?> <?= e($item[1]) ?></a>
            <?php endforeach; ?>
            <a href="<?= e($base_url . ($role === 'admin' ? 'admin/login.php' : 'pages/login.php')) ?>?action=logout" class="is-danger"><?= icon('logout', 15) ?> Logout</a>
          </div>
        </details>
      </div>
    </header>

    <main class="app-content">
      <?php if ($__flash = tt_flash()): ?>
        <div class="form-alert" role="status" style="background:var(--color-success-bg); border-color:#BBF7D0; color:var(--color-success-text); margin:0 0 1.2rem;"><?= icon('check-circle', 15) ?> <?= e($__flash) ?></div>
      <?php endif; ?>