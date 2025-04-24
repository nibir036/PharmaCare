<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($userId === 0) {
        echo json_encode([]);
        exit();
    }

    $query = "SELECT c.id, p.name, p.price, c.quantity 
              FROM cart c 
              JOIN medicines p ON c.product_id = p.id 
              WHERE c.user_id = :user_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Make sure price is numeric (casting)
    foreach ($cartItems as &$item) {
        $item['price'] = floatval($item['price']);
    }

    echo json_encode($cartItems);

}
?>
