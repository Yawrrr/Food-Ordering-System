<!DOCTYPE html>
<html lang="en">
<?php
require_once("connection.php");
session_start();

// Check for order success message
if (isset($_SESSION['order_success'])) {
    echo "<script>alert('" . $_SESSION['order_success'] . "');</script>";
    unset($_SESSION['order_success']); // Clear success message
}

// Check for order error message
if (isset($_SESSION['order_error'])) {
    echo "<script>alert('" . $_SESSION['order_error'] . "');</script>";
    unset($_SESSION['order_error']); // Clear error message
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to place an order.";
    header("Location: login.php");
    exit();
}

// Fetch the username from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="css/mycart.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
        <img src="img/logo2.png" height="50px" alt="logo2">
        <div class="welcome-message">Welcome, <?php echo htmlspecialchars($username); ?>!</div>
        <nav>
            <a href="foodmenu.php">Food Menu</a>
            <a href="mycart.php">Cart</a>
            <a href="myOrder.php">My Orders</a>
            <a href="logout.php">Logout</a>
        </nav>
        <div class="profile-icon" alt="Profile">👤</div>
    </header>
    <div class="container">
        <div class="cart">
            <h2>My Cart</h2>
            <table>
                <thead>
                    <tr>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $sql = "SELECT uc.menu_items_id, uc.quantity, mi.name, mi.price, mi.image 
                            FROM user_cart_items uc
                            JOIN menu_items mi ON uc.menu_items_id = mi.id
                            WHERE uc.user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <img src="img/foodmenu/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" width="50" style="margin-right: 10px;">
                                        <div><?php echo htmlspecialchars($row['name']); ?></div>
                                    </div>
                                </td>
                                <td class="price">RM<?php echo number_format($row['price'], 2); ?></td>
                                <td class="quantity"><?php echo $row['quantity']; ?></td>
                                <td><a href="remove_from_cart.php?id=<?php echo $row['menu_items_id']; ?>" style="color: red; cursor: pointer;">Delete</a></td>
                            </tr>
                        <?php }} else { ?>
                            <tr><td colspan='4'>Your cart is empty.</td></tr>
                        <?php }
                    $stmt->close();
                    ?>
                </tbody>
            </table>

        </div>
        <div class="order-summary">
            <h3>ORDER SUMMARY</h3>
            <p>Subtotal: RM <span id="summary-subtotal"></span></p>
            <p>Service Tax (6%): RM <span id="service-tax"></span></p>
            <div class="total">
                <p>TOTAL</p>
                <p>RM <span id="total"></span></p>
            </div>
            <?php if ($result->num_rows > 0) { ?>
                <a href="place_order.php" class="place-order-btn">Place Order</a>
            <?php } ?>
        </div>
    </div>
    <a href="foodmenu.php" class="continue-ordering">← Continue Ordering</a>
    <script>
        function calculateTotals() {
            let subtotal = 0;
            document.querySelectorAll('tbody tr').forEach(function (row) {
                const priceText = row.querySelector('.price').textContent.replace('RM', '');
                const price = parseFloat(priceText);
                const quantity = parseInt(row.querySelector('.quantity').textContent);
                subtotal += price * quantity;
            });

            document.getElementById('summary-subtotal').textContent = subtotal.toFixed(2);

            const serviceTax = subtotal * 0.06;
            document.getElementById('service-tax').textContent = serviceTax.toFixed(2);

            const total = subtotal + serviceTax;
            document.getElementById('total').textContent = total.toFixed(2);
        }

        window.onload = calculateTotals;
    </script>
</body>
</html>
