<?php
// Start session
session_start();

// Include database connection
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate form data (you should perform more robust validation and sanitize user inputs)
    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Prepare SQL statement to retrieve user information based on username
        $sql = "SELECT id, username, email, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            // Fetch user data
            $row = $result->fetch_assoc();
            $user_id = $row["id"];
            $stored_username = $row["username"];
            $stored_email = $row["email"];
            $hashed_password = $row["password"];

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Authentication successful
                // Set session variables (you can store more user data in session if needed)
                $_SESSION["user_id"] = $user_id;
                $_SESSION["username"] = $stored_username;
                $_SESSION["email"] = $stored_email;

                // Redirect to the dashboard or any other page after successful login
                header("Location: ../dashboard.php");
                exit;
            } else {
                // Incorrect password
                echo "Incorrect password. Please try again.";
            }
        } else {
            // User does not exist
            echo "User does not exist.";
        }

        // Close statement
        $stmt->close();
    }
} else {
    // If the form was not submitted via POST method, redirect to the login page
    header("Location: ../login.php");
    exit;
}

// Close connection (optional, as PHP will automatically close it at the end of script execution)
$conn->close();
?>
