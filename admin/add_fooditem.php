<?php
include("../connection.php");

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to place an order.";
    header("Location: ../login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $description = $_POST['description'];

    // Image upload path
    $target_dir = "../img/foodmenu/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the server
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO menu_items (category, name, price, image, description)
                VALUES ('$category', '$name', '$price', '$image', '$description')";

        if ($conn->query($sql) === TRUE) {
            echo "New menu item added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$menu_items = $conn->query("SELECT * FROM menu_items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item</title>
    <link rel="stylesheet" href="../css/add_food.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<header>
        <img src="../img/logo2.png" height="50px" alt="logo2">
        <nav>
            <a href="">DASHBOARD</a>
            <a href="">USER</a>
            <a href="add_fooditem.php">FOOD</a>
            <a href="all_order.php">ORDER</a>
            <a href="../logout.php">Logout</a>
        </nav>
        <div class="profile-icon" alt="Profile">👤</div>
    </header>
<body>
    <div class="container">
        <h2>Add Menu Item</h2>
        <form action="add_fooditem.php" method="post" enctype="multipart/form-data">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <input type="submit" value="Add Menu Item">
        </form>
</div>
        <div class="container">
        <h2>All Menu Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $menu_items->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><img src="../img/foodmenu/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="50"></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <a href="edit_menu.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="delete_fooditem.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
