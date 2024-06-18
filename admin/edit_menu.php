<?php
include('../connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM menu_items WHERE id=$id");
    if ($result->num_rows > 0) {
        $menu_item = $result->fetch_assoc();
    } else {
        echo "Menu item not found";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        // Image upload path
        $target_dir = "../img/foodmenu/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // If the upload is successful, set the new image name
            $image = basename($_FILES["image"]["name"]);
        } else {
            // If the upload fails, set the image to the existing one
            $image = $menu_item['image'];
        }
    } else {
        // If no new image is uploaded, retain the existing image
        $image = $menu_item['image'];
    }

    $sql = "UPDATE menu_items SET category='$category', name='$name', price='$price', image='$image', description='$description' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Menu item updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: add_fooditem.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="../css/add_food.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="container">
        <h2>Edit Menu Item</h2>
        <form action="edit_menu.php?id=<?php echo $menu_item['id']; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $menu_item['id']; ?>">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="<?php echo $menu_item['category']; ?>" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $menu_item['name']; ?>" required>

            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="<?php echo $menu_item['price']; ?>" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            <?php if (!empty($menu_item['image'])): ?>
                <img src="../img/foodmenu/<?php echo $menu_item['image']; ?>" alt="<?php echo $menu_item['name']; ?>" width="50">
            <?php endif; ?>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $menu_item['description']; ?></textarea>

            <input type="submit" value="Update Menu Item">
        </form>
    </div>
</body>
</html>
