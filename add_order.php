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

$item = $_POST['item'];
$qty = $_POST['qty'];
$price = $_POST['price'];
$status = $_POST['status'];
$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO orders (item, qty, price, date, status) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $item, $qty, $price, $date, $status);

if ($stmt->execute()) {
    echo "New order added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();

// Redirect back to the main page
header("Location: index.php");
exit();
?>
