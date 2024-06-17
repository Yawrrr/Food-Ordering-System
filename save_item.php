<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_menu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['itemId'];
    $quantity = $_POST['quantity'];

    // Check if the item already exists in the cart
    $check_sql = "SELECT quantity FROM user_cart_items WHERE menu_items_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $item_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Item exists, update the quantity
        $update_sql = "UPDATE user_cart_items SET quantity = quantity + ? WHERE menu_items_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("is", $quantity, $item_id);

        if ($update_stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }

        $update_stmt->close();
    } else {
        // Item does not exist, insert a new record
        $insert_sql = "INSERT INTO user_cart_items (menu_items_id, quantity) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("si", $item_id, $quantity);

        if ($insert_stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
}

$conn->close();
?>
