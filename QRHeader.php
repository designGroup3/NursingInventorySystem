<?php
//unused
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url("https://images.freecreatives.com/wp-content/uploads/2015/12/Plaid-Texture-Seamless-Pattern.jpg");
            background-size: 100%;
        }
    </style>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <?php
            if(isset($_SESSION['id'])){
                $inv_id = $_GET['show'];
                  echo "<li>&nbsp<a href=\"index.php\">Home</a></li>
                  <li><a href=\"\">Checkout Item</a></li>
                  <li><a href=\"\">Check-in Item</a></li>";
            } else {
                echo "<li><a href='login.php'>Log In</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>
