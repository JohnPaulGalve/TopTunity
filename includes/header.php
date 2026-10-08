<?php
/**
 * includes/header.php
 * Opens <html>, outputs <head> and opens <body>.
 * Pages set these BEFORE including it:
 *   $page_title  (string)  e.g. "Home"
 *   $user_role   (string)  public | client | freelancer | admin
 *   $base_url    (string)  e.g. "/Webdev/"  (must end with a slash)
 */
require_once __DIR__ . '/helpers.php';

$base_url   = isset($base_url) ? $base_url : '/Webdev/';
$page_title = isset($page_title) ? $page_title : 'TopTunity';
$user_role  = isset($user_role) ? $user_role : 'public';
$meta_description = isset($meta_description)
    ? $meta_description
    : 'TopTunity connects clients who need projects done with skilled Filipino freelancers.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= e($meta_description) ?>">
  <title><?= e($page_title) ?> | TopTunity</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

  <!-- variables.css MUST load before style.css -->
  <link rel="stylesheet" href="<?= e($base_url) ?>css/variables.css">
  <link rel="stylesheet" href="<?= e($base_url) ?>css/style.css">
</head>
<body>