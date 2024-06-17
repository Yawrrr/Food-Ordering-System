<?php
// Database connection settings
$host = 'localhost';
$db = 'your_database';
$user = 'your_username';
$pass = 'your_password';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders from the database
$sql = "SELECT item, qty, price, date, status FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order</title>
    <link rel="stylesheet" href="myorder.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <span> 
                <img src="logo2.png" alt="Logo">
            </span>
        </div>
        <nav class="nav">
            <a href="#">Food Menu</a>
            <a href="#">Cart</a>
            <a href="#">My Orders</a>
            <a href="#"><img src="profile.png" alt="Profile"></a>
        </nav>
    </header>
    
    <main class="main-content">
        <h1>My Order</h1>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['item']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['qty']) . "</td>";
                        echo "<td>RM " . htmlspecialchars(number_format($row['price'], 2)) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td><span class='status " . strtolower(htmlspecialchars($row['status'])) . "'>" . htmlspecialchars($row['status']) . "</span></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No orders found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        
        <div class="continue-ordering">
            <h2>Add New Item</h2>
            <form action="add_order.php" method="post">
                <label for="item">Item:</label>
                <input type="text" id="item" name="item" required><br>
                <label for="qty">Qty:</label>
                <input type="number" id="qty" name="qty" required><br>
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" required><br>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Preparing">Preparing</option>
                    <option value="Served">Served</option>
                    <option value="Cancelled">Cancelled</option>
                </select><br>
                <button type="submit">Add Item</button>
            </form>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Name. All rights reserved.</p>
    </footer>
</body>
</html>
