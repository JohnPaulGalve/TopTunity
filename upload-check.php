<?php
/* Temporary check page: shows the upload limits and the uploads folder status. Delete it when done. */
$dir = __DIR__ . '/storage/uploads';
?>
<!doctype html><meta charset="utf-8"><title>Upload check</title>
<body style="font-family:sans-serif;padding:2rem;line-height:1.8">
<h2>Upload check</h2>
<p><b>upload_max_filesize:</b> <?= htmlspecialchars(ini_get('upload_max_filesize')) ?></p>
<p><b>post_max_size:</b> <?= htmlspecialchars(ini_get('post_max_size')) ?></p>
<p><b>storage/uploads folder exists:</b> <?= is_dir($dir) ? 'yes' : 'NO' ?></p>
<p><b>storage/uploads can be written to:</b> <?= is_dir($dir) && is_writable($dir) ? 'yes' : 'NO' ?></p>
<p><b>.htaccess limits applied:</b> <?= ini_get('upload_max_filesize') === '10M' ? 'yes' : 'NO (the limit is still ' . htmlspecialchars(ini_get('upload_max_filesize')) . ')' ?></p>
</body>