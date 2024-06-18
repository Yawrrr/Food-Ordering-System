<!DOCTYPE html>
<html lang="en">
<?php
require_once("connection.php");
session_start();
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
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve cart items from the database
                    $sql = "SELECT uc.menu_items_id, uc.quantity, mi.name, mi.price, mi.image 
                            FROM user_cart_items uc
                            JOIN menu_items mi ON uc.menu_items_id = mi.id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<div style='display: flex; align-items: center;'>";
                            echo "<img src='img/foodmenu/{$row['image']}' alt='Food Image' style='margin-right: 10px;'>";
                            echo "<div>";
                            echo "<p style='margin-bottom: 5px;'>{$row['name']}</p>";
                            echo "<a href='remove_from_cart.php?id={$row['menu_items_id']}' class='delete' style='color: red; cursor: pointer;'>Delete</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</td>";
                            echo "<td class='price'>RM " . number_format($row['price'], 2) . "</td>";
                            echo "<td>{$row['quantity']}</td>";
                            echo "<td class='item-total'>" . number_format($row['price'] * $row['quantity'], 2) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <div class="cart-footer">
                <p>Subtotal: RM <span id="subtotal"></span></p>
            </div>
        </div>
        <div class="order-summary">
            <h3>ORDER SUMMARY</h3>
            <p>Subtotal: RM <span id="summary-subtotal"></span></p>
            <p>Service Tax (6%): RM <span id="service-tax"></span></p>
            <div class="total">
                <p>TOTAL</p>
                <p>RM <span id="total"></span></p>
            </div>
            <a href="#" class="place-order-btn">Place Order</a>
        </div>
    </div>
    <a href="foodmenu.php" class="continue-ordering">← Continue Ordering</a>
    <script>
        function updateTotal(element) {
            const row = element.closest('tr');
            const price = parseFloat(row.querySelector('.price').textContent.replace('RM ', ''));
            const qty = parseInt(element.value);
            const itemTotal = row.querySelector('.item-total');
            const newTotal = price * qty;
            itemTotal.textContent = newTotal.toFixed(2);

            let subtotal = 0;
            document.querySelectorAll('.item-total').forEach(function (total) {
                subtotal += parseFloat(total.textContent);
            });

            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('summary-subtotal').textContent = subtotal.toFixed(2);

            const serviceTax = subtotal * 0.06;
            document.getElementById('service-tax').textContent = serviceTax.toFixed(2);

            const total = subtotal + serviceTax;
            document.getElementById('total').textContent = total.toFixed(2);
        }

        window.onload = function () {
            let subtotal = 0;
            document.querySelectorAll('.item-total').forEach(function (total) {
                subtotal += parseFloat(total.textContent);
            });

            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('summary-subtotal').textContent = subtotal.toFixed(2);

            const serviceTax = subtotal * 0.06;
            document.getElementById('service-tax').textContent = serviceTax.toFixed(2);

            const total = subtotal + serviceTax;
            document.getElementById('total').textContent = total.toFixed(2);
        }
    </script>
</body>
</html>
