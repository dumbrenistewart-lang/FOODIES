<?php
/**
 * Database connection — configure for your host.
 *
 * InfinityFree (https://infinityfree.com) example:
 *   Host:     sqlXXX.infinityfree.com   (shown in your MySQL Databases panel)
 *   User:     ifXXXXXX_yourname
 *   Password: (your DB password)
 *   DB name:  ifXXXXXX_shop_db
 *
 * Local XAMPP example:
 *   Host: localhost   User: root   Pass: ''   DB: shop_db
 */

$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'shop_db';

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if(!$conn){
   die('Database connection failed. Please check config.php credentials.');
}
mysqli_set_charset($conn, 'utf8mb4');
?>
