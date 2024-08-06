<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
<a href="../user/Home.html">Back to Home</a>
    <h1>Register</h1>
    <?php
    // Display PHP error messages here
    if (isset($_GET['error'])) {
        echo '<p class="error">' . $_GET['error'] . '</p>';
    }
    ?>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <label for="usertype">User Type:</label>
        <select id="usertype" name="usertype" required>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select><br><br>
        <button type="submit" name="register">Register</button>
        <br><br>
    </form>
  
</body>
</html>