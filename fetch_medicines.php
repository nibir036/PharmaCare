<?php
require 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM medicines");
    $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return medicines as JSON
    header('Content-Type: application/json');
    echo json_encode($medicines);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
