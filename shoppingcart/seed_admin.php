<?php
/**
 * seed_admin.php
 * Run this ONCE in your browser to create the admin account.
 * Then DELETE this file immediately from your server.
 */

@include 'config.php';

$hashed = password_hash('Admin@123', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO `users` (username, password, role) VALUES (?, ?, 'admin')");
$stmt->bind_param("ss", $username, $hashed);
$username = 'admin';  // stored lowercase

if ($stmt->execute()) {
    echo "<b style='color:green'>✔ Admin account created successfully!</b><br>";
    echo "<b style='color:red'>⚠ DELETE this file (seed_admin.php) from your server now!</b>";
} else {
    echo "<b style='color:red'>✖ Failed: " . htmlspecialchars($conn->error) . "</b>";
}
