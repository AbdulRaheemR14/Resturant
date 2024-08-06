<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form method="post" action="login.php">
  
        <h1>Login</h1>
        <?php
    // Display PHP error messages here
    if (isset($_GET['error'])) {
        echo '<p class="error">' . $_GET['error'] . '</p>';
    }
    ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="usertype">User Type:</label>
        <select id="usertype" name="usertype" required>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select><br><br>
        <button type="submit" name="login">Login</button><br><br><br>
        </form>
</body>
</html>
