<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT item, quantity, price, date, status 
        FROM orders 
        WHERE user_id = ?
        ORDER BY date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['date']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/myorder.css">
</head>
<body>
<header>
    <img src="img/logo2.png" height="50px" alt="logo2">
        <nav>
            <a href="foodmenu.php">Food Menu</a>
            <a href="mycart.php">Cart</a>
            <a href="myOrder.php">My Orders</a>
            <a href="logout.php">Logout</a>

        </nav>
        <div class="profile-icon" alt="Profile">👤</div>
</header>

<main class="main-content">
    <h1>My Orders</h1>
    <?php if (!empty($orders)) { ?>
        <?php foreach ($orders as $date => $orderGroup) { 
            $subtotal = 0; ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderGroup as $order) { 
                        if ($order['status'] !== 'Cancelled') {
                            $subtotal += $order['price'] * $order['quantity'];
                        } ?>
                        <tr>
                            <td><?php echo $order['item']; ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td>RM<?php echo number_format($order['price'], 2); ?></td>
                            <td><?php echo $order['date']; ?></td>
                            <td><?php echo $order['status']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <?php
                    $serviceTax = $subtotal * 0.06;
                    $total = $subtotal + $serviceTax;
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
                        <td>RM<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Service Tax (6%):</strong></td>
                        <td>RM<?php echo number_format($serviceTax, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                        <td>RM<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <br>
        <?php } ?>
    <?php } else { ?>
        <p>You have no orders.</p>
    <?php } ?>
</main>
</body>
</html>
