<?php
// Database configuration
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "newra14";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = test_input($_POST["fullname"]);
    $phone = test_input($_POST["phone"]);
    $category = test_input($_POST["category"]);
    $items = test_input($_POST["items"]);
    $price = test_input($_POST["price"]);
    $count = test_input($_POST["count"]);
    $total = test_input($_POST["total"]);
    $created_at = date('Y-m-d H:i:s'); // Current date and time

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO delivery (fullname, phone, category, items, price, count, total, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fullname, $phone, $category, $items, $price, $count, $total, $created_at);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Order submitted successfully'); window.location.href = 'menu.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Validation</title>
  <link rel="stylesheet" href="order.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      height: 40px;
      padding: 0 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
      box-sizing: border-box;
    }

    .error-text {
      color: #d93025;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <form action="" method="post">
    <h2>Form Validation</h2>

    <div class="form-group">
      <label for="category">Select Your Food Category</label>
      <select id="category" name="category">
        <option value="" selected disabled>Select your Food Category</option>
        <?php
        // Connect to the database
        $conn = new mysqli('127.0.0.1', 'root', '', 'newra14');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch categories from database
        $select_query = "SELECT * FROM categories";
        $result = $conn->query($select_query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];
                echo "<option value='$category_id'>$category_title</option>";
            }
        }

        $conn->close();
        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="items">Select Your Food</label>
      <select id="items" name="items">
        <option value="" selected disabled>Select your Food</option>
        <!-- Options will be populated dynamically using AJAX -->
      </select>
    </div>
    <div class="form-group">
      <label for="price">One Portion Price</label>
      <input type="text" id="price" name="price" placeholder="Enter the price" readonly>
    </div>
    <div class="form-group">
      <label for="count">Portion Count</label>
      <input type="number" id="count" name="count" placeholder="Enter the portion count">
    </div>
    <div class="form-group">
      <label for="total">Total Price</label>
      <input type="text" id="total" name="total" placeholder="Total price" readonly>
    </div>
    <div class="form-group">
      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">
    </div>
    <div class="form-group">
      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
    </div>

    <div class="form-group">
      <input type="submit" value="Submit">
    </div>
  </form>

  <script>
    $(document).ready(function () {
        // Handle category change
        $('#category').change(function () {
            var selectedCategory = $(this).val();
            $('#items').empty().append('<option value="" selected disabled>Select your Food</option>');
            $('#price').val('');
            $('#total').val('');

            if (selectedCategory !== "") {
                $.ajax({
                    type: 'POST',
                    url: 'get_foods.php',
                    data: { category_id: selectedCategory },
                    success: function (response) {
                        $('#items').html(response);
                    }
                });
            }
        });

        // Handle item change
        $('#items').change(function () {
            var selectedFood = $(this).val();
            var selectedCategory = $('#category').val();

            if (selectedFood !== "") {
                $.ajax({
                    type: 'POST',
                    url: 'get_price.php',
                    data: { category_id: selectedCategory, food_id: selectedFood },
                    success: function (response) {
                        $('#price').val(response);
                        calculateTotal();
                    }
                });
            }
        });

        // Calculate total price
        $('#count').on('input', function () {
            calculateTotal();
        });

        function calculateTotal() {
            var price = parseFloat($('#price').val());
            var count = parseInt($('#count').val());
            if (!isNaN(price) && !isNaN(count)) {
                $('#total').val(price * count);
            } else {
                $('#total').val('');
            }
        }

        // Form validation and submission
        $('form').on('submit', function (e) {
            e.preventDefault();

            const fullname = $('#fullname').val().trim();
            const phone = $('#phone').val().trim();
            const category = $('#category').val();
            const items = $('#items').val();
            const price = $('#price').val();
            const count = $('#count').val();
            const total = $('#total').val();

            const phonePattern = /^[0-9]{10}$/;

            // Clear previous errors
            $('.form-group .error').removeClass('error');
            $('.error-text').remove();

            let hasError = false;

            if (fullname === "") {
                showError('#fullname', "Enter your full name");
                hasError = true;
            }
            if (!phone.match(phonePattern)) {
                showError('#phone', "Enter a valid 10-digit phone number");
                hasError = true;
            }
            if (!category) {
                showError('#category', "Select your Food Category");
                hasError = true;
            }
            if (!items) {
                showError('#items', "Select your Food");
                hasError = true;
            }
            if (!price) {
                showError('#price', "Enter the price");
                hasError = true;
            }
            if (!count) {
                showError('#count', "Enter the portion count");
                hasError = true;
            }
            if (!total) {
                showError('#total', "Enter the total price");
                hasError = true;
            }

            if (!hasError) {
                $(this).off('submit').submit(); // Unbind the submit event to avoid infinite loop
            }

            function showError(selector, message) {
                $(selector).addClass('error');
                $('<small class="error-text">').text(message).appendTo($(selector).closest('.form-group'));
            }
        });
    });
  </script>
</body>
</html>
