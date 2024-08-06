<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup Form</title>

  <!-- CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <style>
    /* Google Fonts - Poppins */
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #4070f4;
    }

    .container {
      position: relative;
      max-width: 370px;
      width: 100%;
      padding: 25px;
      border-radius: 8px;
      background-color: #fff;
    }

    .container header {
      font-size: 22px;
      font-weight: 600;
      color: #333;
    }

    .container form {
      margin-top: 30px;
    }

    form .field {
      margin-bottom: 20px;
    }

    form .input-field {
      position: relative;
      height: 55px;
      width: 100%;
    }

    .input-field input {
      height: 100%;
      width: 100%;
      outline: none;
      border: none;
      border-radius: 8px;
      padding: 0 15px;
      border: 1px solid #d1d1d1;
    }

    .invalid input {
      border-color: #d93025;
    }

    .input-field .show-hide {
      position: absolute;
      right: 13px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: #919191;
      cursor: pointer;
      padding: 3px;
    }

    .field .error {
      display: flex;
      align-items: center;
      margin-top: 6px;
      color: #d93025;
      font-size: 13px;
      display: none;
    }

    .invalid .error {
      display: flex;
    }

    .error .error-icon {
      margin-right: 6px;
      font-size: 15px;
    }

    .create-password .error {
      align-items: flex-start;
    }

    .create-password .error-icon {
      margin-top: 4px;
    }

    .button {
      margin: 25px 0 6px;
    }

    .button input {
      color: #fff;
      font-size: 16px;
      font-weight: 400;
      background-color: #4070f4;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .button input:hover {
      background-color: #0e4bf1;
    }
  </style>
</head>
<body>
  <div class="container">
    <header>Signup</header>
    <form id="signupForm" action="" method="post">
      <div class="field email-field">
        <div class="input-field">
          <input type="email" placeholder="Enter your email" name="email" class="email" required />
        </div>
        <span class="error email-error">
         
          <p class="error-text">Please enter a valid email</p>
        </span>
      </div>
      <div class="field create-password">
        <div class="input-field">
          <input
            type="password"
            placeholder="Create password"
            name="password"
            class="password"
            required
          />
          <i class="bx bx-hide show-hide"></i>
        </div>
        <span class="error password-error">
         
          <p class="error-text">
            Please enter at least 8 characters with number, symbol, small and
            capital letter.
          </p>
        </span>
      </div>
      <div class="field confirm-password">
        <div class="input-field">
          <input
            type="password"
            placeholder="Confirm password"
            name="cPassword"
            class="cPassword"
            required
          />
          <i class="bx bx-hide show-hide"></i>
        </div>
        <span class="error cPassword-error">
         
          <p class="error-text">Passwords don't match</p>
        </span>
      </div>
      <div class="field phone-field">
        <div class="input-field">
          <input type="text" placeholder="Enter your phone number Ex-07XXXXXXXX" name="phone" class="phone" required />
        </div>
        <span class="error phone-error">
          <i class="bx bx-error-circle error-icon"></i>
          <p class="error-text">Please enter a valid phone number</p>
        </span>
      </div>
      <div class="input-field button">
        <input type="submit" value="Submit Now" />
      </div>
    </form>
  </div>

  <!-- JavaScript -->
  <script>
    const form = document.getElementById("signupForm");
    const emailInput = form.querySelector(".email");
    const passInput = form.querySelector(".password");
    const cPassInput = form.querySelector(".cPassword");
    const phoneInput = form.querySelector(".phone");

    // Password Validation (JavaScript)
    function createPass() {
      const passPattern =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

      if (!passInput.value.match(passPattern)) {
        return form.querySelector(".create-password").classList.add("invalid");
      }
      form.querySelector(".create-password").classList.remove("invalid");
    }

    // Confirm Password Validation (JavaScript)
    function confirmPass() {
      if (passInput.value !== cPassInput.value || cPassInput.value === "") {
        return form.querySelector(".confirm-password").classList.add("invalid");
      }
      form.querySelector(".confirm-password").classList.remove("invalid");
    }

    // Phone Number Validation (JavaScript)
    function checkPhone() {
      const phonePattern = /^[0-9]{10}$/; // Example pattern for 10-digit phone number
      if (!phoneInput.value.match(phonePattern)) {
        return form.querySelector(".phone-field").classList.add("invalid");
      }
      form.querySelector(".phone-field").classList.remove("invalid");
    }

    // Form Submission Validation (JavaScript)
    form.addEventListener("submit", function(e) {
      e.preventDefault(); // Prevent form submission

      createPass();
      confirmPass();
      checkPhone();

      if (
        !form.querySelector(".email-field").classList.contains("invalid") &&
        !form.querySelector(".create-password").classList.contains("invalid") &&
        !form.querySelector(".confirm-password").classList.contains("invalid") &&
        !form.querySelector(".phone-field").classList.contains("invalid")
      ) {
        // Submit the form if all validations pass
        this.submit();
      }
    });
  </script>
</body>
</html>


<?php

if (
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['cPassword']) &&
    isset($_POST['phone'])
) {
  $conn = new mysqli('127.0.0.1', 'root', '','newra14');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into database
    $sql = "INSERT INTO users (email, password, phone) VALUES ('$email', '$hashed_password', '$phone')";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to a success page or do something else on success
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
