<?php
include("../connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to edit an order.";
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    // Delete the record from the database
    $sql = "DELETE FROM orders WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Menu item deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect back to the add_fooditem.php page
    header("Location: all_order.php");
    exit();
} else {
    echo "No menu item ID provided.";
}
?>
