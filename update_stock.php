<?php
require 'db.php';

// Decode JSON payload
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'] ?? null;
$quantity = $data['quantity'] ?? null;

if (!$id || !$quantity || $quantity < 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit();
}

try {
    $query = "UPDATE medicines SET quantity = :quantity WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
