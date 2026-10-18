<?php
/**
 * includes/header.php
 * Opens <html>, outputs <head> and opens <body>. Also protects client/freelancer/admin pages.
 * Pages set these BEFORE including it:
 *   $page_title  (string)  e.g. "Home"
 *   $user_role   (string)  public | client | freelancer | admin
 *   $base_url    (string)  e.g. (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/')  (must end with a slash)
 */
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/auth.php';

$base_url   = isset($base_url) ? $base_url : (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$page_title = isset($page_title) ? $page_title : 'TopTunity';
$user_role  = isset($user_role) ? $user_role : 'public';
$meta_description = isset($meta_description)
    ? $meta_description
    : 'TopTunity connects clients who need projects done with skilled Filipino freelancers.';

/* Access rule: a protected area needs a signed-in user with the matching role */
if (in_array($user_role, ['client', 'freelancer', 'admin'], true)) {
    $signed_in = tt_current_user();
    if ($signed_in && $signed_in['role'] !== $user_role) {
        // Signed in, but this page belongs to another role: send them to their own dashboard
        header('Location: ' . $base_url . tt_home_for($signed_in['role']));
        exit;
    }
    if (!$signed_in) {
        $here = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        if (strpos($here, $base_url) === 0) {
            $here = substr($here, strlen($base_url));
        }
        header('Location: ' . $base_url . 'pages/login.php?next=' . urlencode($here));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= e($meta_description) ?>">
  <title><?= e($page_title) ?> | TopTunity</title>
  <link rel="icon" type="image/svg+xml" href="<?= e(tt_image_url($base_url, 'images/Logo/favicon.svg')) ?>">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

  <!-- variables.css MUST load before style.css -->
  <link rel="stylesheet" href="<?= e($base_url) ?>css/variables.css">
  <link rel="stylesheet" href="<?= e($base_url) ?>css/style.css?v=<?= @filemtime(__DIR__ . '/../css/style.css') ?>">
</head>
<body>
<?php if ($user_role === 'public' && ($flash = tt_flash())): ?>
  <div class="flash-banner" role="status"><?= e($flash) ?></div>
<?php endif; ?>