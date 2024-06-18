<!DOCTYPE html>
<html lang="en">
<?php
require_once("connection.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to place an order.";
    header("Location: login.php");
}

// new session, check whether got set session cart, if no, create new session cart
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu</title>
    <link rel="stylesheet" href="css/foodmenu_style.css">
    <link rel="stylesheet" href="css/main.css">

</head>
<body>
    <header>
        <img src="img/logo2.png" height="50px" alt="logo2">
        <nav>
            <a href="foodmenu.php">Food Menu</a>
            <a href="mycart.php">Cart</a>
            <a href="myorders.php">My Orders</a>
            <a href="logout.php">Logout</a>
        </nav>
        <div class="profile-icon">👤</div>
    </header>
    <main>
        <h1>Food Menu</h1>
        <div class="categories">
            <button class="category-button active" data-category="all">All</button>
            <button class="category-button" data-category="pasta">Pasta</button>
            <button class="category-button" data-category="burgers">Burgers</button>
            <button class="category-button" data-category="desserts">Desserts</button>
            <button class="category-button" data-category="beverages">Beverages</button>
        </div>
        <div class="order-by">
            <span>Price: </span>
            <select id="price-sort">
                <option value="low-to-high">Low to high</option>
                <option value="high-to-low">High to Low</option>
            </select>
        </div>
        <div class="menu-items" id="menu-items">
        <?php
            // Updated SQL query to include description
            $sql = "SELECT id, category, name, price, image, description FROM menu_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<div id='menu-item-" . $row["id"] . "' class='menu-item' data-category='" . $row["category"] . "' data-price='" . $row["price"] . "'>";
                    echo "<img class='item-image' src='img/foodmenu/" . $row["image"] . "' alt='" . $row["name"] . "'>";
                    echo "<h2 class='item-name'>" . $row["name"] . "</h2>";
                    echo "<p>RM " . number_format($row["price"], 2) . "</p>";
                    echo "<p class='item-description' style='display:none'>" . $row["description"] . "</p>"; // Display item description
                    echo "<button onclick='openModal(" . $row["id"] . ")'>Add to Cart</button>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
        ?>
        </div>
    </main>
    <div id="item-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <img id="modal-item-image" src="" alt="Item Image">
            <div class="modal-details">
                <h2 id="modal-item-name"></h2>
                <p class="modal-item-price" id="modal-item-price"></p>
                <p id="modal-item-description"></p>
                <div class="quantity-selector">
                    <button id="decrease-quantity">-</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button id="increase-quantity">+</button>
                </div>
                <button id="confirm-modal" class="confirm-btn" type='button' onclick="saveItem()">Confirm</button>
            </div>
        </div>
    </div>
    <script src="js/fetch_user_session.js"></script>
    <script src="js/foodmenu_script.js"></script>
</body>
</html>
