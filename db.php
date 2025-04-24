<?php
$host = 'localhost'; // Change if hosted elsewhere
$db = 'pharmacy_db';
$user = 'root'; // Replace with your DB user
$pass = ''; // Replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
