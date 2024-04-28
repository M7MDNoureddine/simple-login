<?php
// Include database connection
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];

    // Validate form data (you should perform more robust validation and sanitize user inputs)
    if (empty($email)) {
        echo "Please enter your email address.";
    } else {
        // Prepare SQL statement to retrieve user information based on email
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user with the given email exists
        if ($result->num_rows == 1) {
            // Generate a unique token for password reset (you can use a library like PHP's built-in uniqid() function)
            $token = uniqid();

            // Update the user's record in the database with the reset token
            $sql_update = "UPDATE users SET reset_token = ? WHERE email = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ss", $token, $email);
            $stmt_update->execute();

            // Check if the update was successful
            if ($stmt_update->affected_rows > 0) {
                // Send the password reset email
                $to = $email;
                $subject = "Password Reset Request";
                $message = "Dear user,\n\nYou have requested to reset your password. Please click on the following link to reset your password:\n\nhttp://localhost/reset_password.php?token=$token\n\nIf you did not request this, please ignore this email.";
                $headers = "From: your_email@example.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                // Send the email
                $mailSent = mail($to, $subject, $message, $headers);

                // Check if the email was sent successfully
                if ($mailSent) {
                    echo "An email with instructions to reset your password has been sent to your email address.";
                } else {
                    echo "Failed to send email. Please try again later.";
                }
            } else {
                echo "Failed to update reset token. Please try again later.";
            }
        } else {
            // User with the given email does not exist
            echo "User with this email address does not exist.";
        }

        // Close statements
        $stmt->close();
        $stmt_update->close();
    }
} else {
    // If the form was not submitted via POST method, redirect to the forgot password page
    header("Location: forgot_password.php");
    exit;
}

// Close connection (optional, as PHP will automatically close it at the end of script execution)
$conn->close();
?>
