<?php
require_once __DIR__ . '/config.php';

/**
 * includes/db.php - database connection (PDO with prepared statements).
 * Values come from environment variables or an untracked local config file.
 */

function tt_db_error_page($message, $status = 503)
{
    if (PHP_SAPI !== 'cli' && !headers_sent()) {
        http_response_code((int) $status);
        header('Content-Type: text/html; charset=UTF-8');
    }

    $html = '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Service Unavailable</title>'
        . '<style>body{font-family:system-ui,sans-serif;display:grid;place-items:center;height:100vh;margin:0;background:#f4f7fb;color:#1f2937}.'
        . 'box{max-width:560px;padding:2rem 2.25rem;border-radius:16px;background:#fff;border:1px solid #dfe7f2;box-shadow:0 18px 45px rgba(15,23,42,.08)}'
        . 'h1{font-size:1.5rem;margin:0 0 .75rem}p{margin:0;line-height:1.6}</style></head><body><div class="box"><h1>Service unavailable</h1><p>'
        . htmlspecialchars((string) $message, ENT_QUOTES, 'UTF-8')
        . '</p></div></body></html>';

    echo $html;
    exit;
}

/** Hide internal exception details from visitors while preserving useful server logs. */
function tt_handle_uncaught_exception($exception)
{
    error_log('TopTunity uncaught ' . get_class($exception) . ': ' . $exception->getMessage());

    $is_database_error = $exception instanceof PDOException;
    $status = $is_database_error ? 503 : 500;
    $message = $is_database_error
        ? 'The site is temporarily unavailable. Please try again in a few minutes.'
        : 'An unexpected error occurred. Please try again later.';

    if (headers_sent()) {
        return;
    }
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (PHP_SAPI !== 'cli' && (
        strpos((string) ($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json') !== false
        || strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest'
    )) {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['error' => $message]);
        exit;
    }

    tt_db_error_page($message, $status);
}

if (PHP_SAPI !== 'cli') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    set_exception_handler('tt_handle_uncaught_exception');
}

/** One shared connection for the whole request. */
function db()
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $cfg = tt_db_config();
        } catch (RuntimeException $e) {
            error_log('TopTunity database configuration is missing or invalid.');
            tt_db_error_page($e->getMessage());
        }

        try {
            $pdo = new PDO(
                'mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['name'] . ';charset=utf8mb4',
                $cfg['user'],
                $cfg['pass'],
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        } catch (PDOException $e) {
            error_log('TopTunity database connection failed: ' . $e->getMessage());
            tt_db_error_page('The site is temporarily unavailable. Please try again in a few minutes.');
        }
    }
    return $pdo;
}