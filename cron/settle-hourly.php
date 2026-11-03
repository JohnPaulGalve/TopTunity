<?php
/**
 * Daily job: keeps project statuses in step with their deadlines, and settles hourly projects
 * whose End Date has passed (pays approved hours, refunds the unused deposit, completes the project).
 *
 * Run from the command line once a day, for example with cron:
 *   0 2 * * *  php /path/to/TopTunity/cron/settle-hourly.php >> /path/to/settle.log 2>&1
 * On Windows (XAMPP), schedule the same command in Task Scheduler.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This script runs from the command line only.');
}
require_once __DIR__ . '/../includes/data.php';

tt_refresh_project_statuses();
$settled = tt_settle_all_due_hourly();
echo date('Y-m-d H:i') . ' - settled ' . $settled . " hourly project(s); statuses refreshed\n";