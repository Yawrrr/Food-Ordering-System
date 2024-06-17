<!DOCTYPE html>
<html lang="en">
<?php
require_once("connection.php");  
error_reporting(0);  
session_start(); 
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="home">
  <header>
  <div class="container-fluid px-5 bg-primary">
    <nav class="navbar navbar-expand-sm navbar-light bg-body-light">
      <a href="index.php" class="navbar-brand"> SIXG CAFE </a>
      <button 
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#toggleMobileMenu"
        aria-controls="toggleMobileMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="toggleMobileMenu">
        <ul class="navbar-nav ms-auto ">
          <li class="nav-item">
            <a href="index.php" class="nav-link text-light">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link text-light">Restaurants</a>
          </li>
          
          <?php
          if (!empty($_SESSION['username'])) {
            echo '<li class="nav-item">
                    <a href="#" class="nav-link text-light">Cart</a>
                  </li>
            <li class="nav-item">
                    <a href="logout.php" class="nav-link text-light">Logout</a>
                  </li>';
          } else {
            echo '<li class="nav-item">
                    <a href="login.php" class="nav-link text-light">Login</a>
                  </li>';
          }
          ?>
          </li>

        </ul>
      </div>
    </nav>
  </div>
</header>
</body>
