<?php
require 'db.php'; // Include the db.php file to initialize $pdo

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate JSON input
    if (!isset($input['user_id'], $input['product_id'], $input['quantity'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid input: Missing user_id, product_id, or quantity."
        ]);
        exit;
    }

    $userId = $input['user_id'];
    $productId = $input['product_id'];
    $quantity = $input['quantity'];

    // Validate input further if needed
    if (empty($userId) || empty($productId) || empty($quantity)) {
        echo json_encode([
            "success" => false,
            "message" => "All fields are required."
        ]);
        exit;
    }

    // Check if the item already exists in the cart
    $query = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Update quantity if product exists
        $updateQuery = "UPDATE cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $updateStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $updateStmt->execute();
    } else {
        // Insert new product if it doesn't exist
        $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $insertStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $insertStmt->execute();
    }

    echo json_encode(["success" => true, "message" => "Item added to cart."]);
    exit();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit();
}
?>
