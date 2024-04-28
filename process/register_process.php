<?php
// Start session
session_start();

// Include database connection
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate form data (you should perform more robust validation and sanitize user inputs)
    if (empty($username) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        $stmt->execute();

        // Check if the statement was executed successfully
        if ($stmt->affected_rows > 0) {
            echo "Registration successful. You can now <a href='../login.php'>login</a>.";
        } else {
            echo "Registration failed. Please try again.";
        }

        // Close statement
        $stmt->close();
    }
} else {
    // If the form was not submitted via POST method, redirect to the registration page
    header("Location: register.php");
    exit;
}

// Close connection (optional, as PHP will automatically close it at the end of script execution)
$conn->close();
?>
