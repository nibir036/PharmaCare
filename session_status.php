<?php
session_start();
echo json_encode(['isLoggedIn' => isset($_SESSION['user_id'])]);
?>
