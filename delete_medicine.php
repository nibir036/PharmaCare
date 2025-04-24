<?php
require 'db.php';

// Decode JSON payload
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit();
}

try {
    $query = "DELETE FROM medicines WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
