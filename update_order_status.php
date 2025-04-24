<?php
require 'db.php';

// Decode JSON payload
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
$orderId = $data['order_id'] ?? null;
$status = $data['status'] ?? null;

if (!$orderId || !$status) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit();
}

try {
    // Update order status
    $query = "UPDATE orders SET status = :status WHERE id = :order_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
