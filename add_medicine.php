<?php
header('Content-Type: application/json');
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;

    if (!empty($name) && $price > 0 && $quantity > 0) {
        try {
            $query = "INSERT INTO medicines (name, price, quantity) VALUES (:name, :price, :quantity)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Medicine added successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
