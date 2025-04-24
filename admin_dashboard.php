<?php
session_start();
require 'db.php';

// Ensure only admin has access
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch medicines
$query = "SELECT * FROM medicines";
$stmt = $pdo->prepare($query);
$stmt->execute();
$medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch orders
$query = "SELECT * FROM orders";
$stmt = $pdo->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <button onclick="window.location.href='admin_logout.php'" style="float: right;">Logout</button>
    </header>

    <section>
        <h2>Available Medicines</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicines as $medicine): ?>
                    <tr>
                        <td><?= $medicine['id'] ?></td>
                        <td><?= $medicine['name'] ?></td>
                        <td><?= $medicine['price'] ?></td>
                        <td><?= $medicine['quantity'] ?></td>
                        <td>
                            <button onclick="editMedicine(<?= $medicine['id'] ?>)">Edit</button>
                            <button onclick="deleteMedicine(<?= $medicine['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button onclick="openAddMedicineForm()">Add Medicine</button>
    </section>

    <section>
        <h2>Orders</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['user_id'] ?></td>
                        <td><?= $order['total_amount'] ?></td>
                        <td><?= $order['status'] ?></td>
                        <td>
                            <button onclick="updateOrderStatus(<?= $order['id'] ?>)">Update Status</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <script src="admin_dashboard.js"></script>
</body>
</html>
