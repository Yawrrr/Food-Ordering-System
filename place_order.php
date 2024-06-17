<?php
session_start();
include("connection.php");

// Example SQL to insert into orders table
$insertOrder = "INSERT INTO orders (item, quantity, price, date, status) 
                   SELECT mi.name, uc.quantity, mi.price, NOW(), 'Pending' 
                   FROM user_cart_items uc
                   JOIN menu_items mi ON uc.menu_items_id = mi.id";

$stmt = $conn->prepare($insertOrder);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Clear the cart after successful order placement
    $clearCart = "DELETE FROM user_cart_items";
    $conn->query($clearCart);

    // Set success message and redirect
    $_SESSION['order_success'] = "Order placed successfully!";
    header("Location: mycart.php");
    exit();
} else {
    // Set error message and redirect
    $_SESSION['order_error'] = "Error placing order: " . $conn->error;
    header("Location: mycart.php");
    exit();
}

$stmt->close();
$conn->close();
?>
