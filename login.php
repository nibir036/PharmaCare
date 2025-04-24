<?php
require 'db.php';
session_start();

header('Content-Type: application/json'); // Set response type to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
        exit();
    }

    try {
        // Query the user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Send success response
            echo json_encode([
                'success' => true,
                'message' => 'Login successful!',
                'user_id' => $user['id'],
                'username' => htmlspecialchars($user['username'])
            ]);

        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        error_log($e->getMessage()); // Log the error for debugging
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
