
<?php
// Connect to the database
$conn = new mysqli('127.0.0.1', 'root', '', 'newra14');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (isset($_POST['register'])) {
$username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $usertype = $_POST['usertype'];

    // Check if the username already exists
    $sql = "SELECT * FROM admin_details WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Username is available
        if ($password === $confirm_password) {
            // Passwords match, insert the new user
            $sql = "INSERT INTO admin_details (username, email, password, usertype) VALUES ('$username', '$email', '$password', '$usertype')";
            if ($conn->query($sql) === TRUE) {
                // Registration successful
                echo "<script>alert('register Successfully')</script>";
                echo "<script>window.open('../user/Home.html','_self')</script>";

            } else {
                // Registration failed
                $error_message = "Error: " . $conn->error;
                header("Location: registeradmin.php?error=" . urlencode($error_message));
                exit();
            }
        } else {
            // Passwords do not match, display an error message
            $error_message = "Passwords do not match";
            header("Location: registeradmin.php?error=" . urlencode($error_message));
            exit();
        }
    } else {
        // Username is taken, display an error message
        $error_message = "Username is already taken";
        header("Location: registeradmin.php?error=" . urlencode($error_message));
        exit();
    }
    
    
}

$conn->close();
?>