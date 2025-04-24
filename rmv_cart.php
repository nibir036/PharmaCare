<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['cart_id'])) {
        echo json_encode(['success' => false, 'message' => 'Cart ID is required.']);
        exit();
    }

    $cartId = intval($input['cart_id']);

    // Check the current quantity of the item in the cart
    $checkQuery = "SELECT quantity FROM cart WHERE id = :cart_id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
    $checkStmt->execute();
    $item = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo json_encode(['success' => false, 'message' => 'Item not found in cart.']);
        exit();
    }

    $currentQuantity = $item['quantity'];

    if ($currentQuantity > 1) {
        // If quantity is more than 1, reduce it by 1
        $updateQuery = "UPDATE cart SET quantity = quantity - 1 WHERE id = :cart_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Quantity decreased by 1.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to reduce quantity.']);
        }
    } else {
        // If quantity is 1, delete the item from the cart
        $deleteQuery = "DELETE FROM cart WHERE id = :cart_id";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);

        if ($deleteStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Item removed from cart.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item.']);
        }
    }
}
?>
