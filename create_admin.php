<?php
require 'db.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_BCRYPT);

$query = "INSERT INTO admins (username, password) VALUES (:username, :password)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->execute();

echo "Admin user created successfully.";
?>
