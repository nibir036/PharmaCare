<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $userId = $data['user_id'];
    $fullName = $data['full_name'];
    $address = $data['address'];
    $phone = $data['phone'];
    $paymentMethod = $data['payment_method'];

    // Start a transaction to ensure all related tables are updated correctly
    try {
        $pdo->beginTransaction();

        // Calculate the total amount from the cart and fetch product details
        $query = "SELECT p.id AS product_id, p.name, p.price, c.quantity 
                  FROM cart c 
                  JOIN medicines p ON c.product_id = p.id 
                  WHERE c.user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cartItems)) {
            throw new Exception("Cart is empty. Cannot place an order.");
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Insert into orders table
        $query = "INSERT INTO orders (user_id, full_name, address, phone, payment_method, order_date, total_amount) 
                  VALUES (:user_id, :full_name, :address, :phone, :payment_method, NOW(), :total_amount)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':total_amount', $totalAmount);
        $stmt->execute();

        $orderId = $pdo->lastInsertId();

        // Insert cart items into order_items table
        foreach ($cartItems as $item) {
            $query = "INSERT INTO order_items (order_id, product_id, quantity) 
                      VALUES (:order_id, :product_id, :quantity)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $item['product_id']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->execute();
        }

        // Commit the transaction
        $pdo->commit();

        // Clear the cart after placing the order
        $query = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        // Return success with order details
        echo json_encode([
            'success' => true,
            'order_id' => $orderId,
            'total_amount' => $totalAmount,
            'products' => $cartItems
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
