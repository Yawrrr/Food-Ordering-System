<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $image = $_POST["image"];

    $item = [
        "id" => $id,
        "name" => $name,
        "price" => $price,
        "quantity" => $quantity,
        "image" => $image
    ];
//new session, check whether got set session cart, if no, create new session cart
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // If item already exists in the cart, update the quantity
    if (isset($_SESSION["cart"][$id])) {
        $_SESSION["cart"][$id]["quantity"] += $quantity;
    } else {
        $_SESSION["cart"][$id] = $item;
    }

    header("Location: foodmenu.php");
    exit();
}
?>
