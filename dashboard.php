<?php
// dashboard.php

session_start();

// if (!isset($_SESSION['loggedin'])) {
//     header('Location: login.php');
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and validate form data
    $pizza_type = htmlspecialchars($_POST['pizza_type']);
    $pizza_size = htmlspecialchars($_POST['pizza_size']);
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        // Display order confirmation
        $order_confirmation = "You have ordered $quantity $pizza_size $pizza_type pizza(s).";
    } else {
        $error_message = "Please enter a valid quantity.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Delivery Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Pizza Delivery Service</h1>
        <p>Place your order below:</p>

        <form action="dashboard.php" method="post">
            <label for="pizza_type">Pizza Type:</label>
            <select name="pizza_type" id="pizza_type" required>
                <option value="Margherita">Margherita</option>
                <option value="Pepperoni">Pepperoni</option>
                <option value="BBQ Chicken">BBQ Chicken</option>
                <option value="Vegetarian">Vegetarian</option>
            </select>

            <label for="pizza_size">Pizza Size:</label>
            <select name="pizza_size" id="pizza_size" required>
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" required>

            <button type="submit">Place Order</button>
        </form>

        <?php
        if (isset($order_confirmation)) {
            echo "<p class='confirmation'>$order_confirmation</p>";
        } elseif (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>
