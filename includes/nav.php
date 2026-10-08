<?php
/**
 * includes/nav.php
 * Context-aware navigation for: public, client, freelancer, admin.
 * Uses $user_role and $base_url set by the page (defaults below).
 *
 * Highlighting: the link whose page matches the current file is underlined.
 * Detail pages belong to a section, so they highlight that section instead
 * ($page_aliases). A page can also force a highlight by setting
 * $nav_active = 'pages/some-page.php' before including this file.
 */
$base_url  = isset($base_url) ? $base_url : '/Webdev/';
$user_role = isset($user_role) ? $user_role : 'public';

$menus = [
    'public' => [
        'pages/browse-projects.php'    => 'Browse Projects',
        'pages/browse-freelancers.php' => 'Browse Freelancers',
        'pages/pricing.php'            => 'Pricing',
    ],
    'client' => [
        'client/dashboard.php'        => 'Dashboard',
        'client/my-projects.php'      => 'My Projects',
        'client/find-freelancers.php' => 'Find Freelancers',
        'client/messages.php'         => 'Messages',
    ],
    'freelancer' => [
        'freelancer/dashboard.php'     => 'Dashboard',
        'freelancer/find-projects.php' => 'Find Projects',
        'freelancer/my-proposals.php'  => 'My Proposals',
        'freelancer/earnings.php'      => 'Earnings',
    ],
    'admin' => [
        'admin/dashboard.php'          => 'Dashboard',
        'admin/user-management.php'    => 'Users',
        'admin/project-moderation.php' => 'Projects',
        'admin/dispute-management.php' => 'Disputes',
    ],
];

$menu        = isset($menus[$user_role]) ? $menus[$user_role] : $menus['public'];
$script_path = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';

// Detail pages that belong to a menu section
$page_aliases = [
    'project-details.php'    => 'pages/browse-projects.php',
    'freelancer-profile.php' => 'pages/browse-freelancers.php',
];

$current_file = basename($script_path);
if (isset($nav_active)) {
    $active_href = $nav_active;
} elseif (isset($page_aliases[$current_file])) {
    $active_href = $page_aliases[$current_file];
} else {
    $active_href = null;
    foreach (array_keys($menu) as $href) {
        if (substr($script_path, -strlen($href)) === $href) {
            $active_href = $href;
            break;
        }
    }
}
?>
<header class="navbar">
  <div class="container navbar__inner">
    <a href="<?= e($base_url) ?>pages/index.php" class="brand-logo" aria-label="TopTunity home">TopTunity<span class="logo-star" aria-hidden="true">&#10022;</span></a>

    <button class="nav-toggle" type="button" aria-controls="site-menu" aria-expanded="false" aria-label="Toggle navigation">
      <?= icon('menu', 24) ?>
    </button>

    <nav class="navbar__menu" id="site-menu" aria-label="Main">
      <ul class="nav-links">
        <?php foreach ($menu as $href => $label): ?>
          <li>
            <a href="<?= e($base_url . $href) ?>"
               <?= $href === $active_href ? 'aria-current="page"' : '' ?>><?= e($label) ?></a>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="nav-auth">
        <?php if ($user_role === 'public'): ?>
          <a href="<?= e($base_url) ?>pages/login.php" class="nav-login">Login</a>
          <a href="<?= e($base_url) ?>pages/register.php" class="btn btn--primary btn--sm">Register</a>
        <?php else: ?>
          <a href="<?= e($base_url . $user_role) ?>/notifications.php" class="nav-login">Notifications</a>
          <?php /* TODO: point this at your real logout handler */ ?>
          <a href="<?= e($base_url) ?>pages/login.php" class="btn btn--outline btn--sm">Log out</a>
        <?php endif; ?>
      </div>
    </nav>
  </div>
</header>