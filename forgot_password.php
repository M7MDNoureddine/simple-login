<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="process/forgot_password_process.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
