<?php
/**
 * includes/db.php - database connection (PDO with prepared statements).
 * NEW FILE. Change the four values below to match your MySQL setup.
 */
const DB_HOST = '127.0.0.1';
const DB_NAME = 'toptunity';
const DB_USER = 'tt_app';
const DB_PASS = 'tt_app_pw';

/** One shared connection for the whole request. */
function db()
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    }
    return $pdo;
}