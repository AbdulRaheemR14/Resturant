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

// Validate and sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = test_input($_POST["fullname"]);
    $date = test_input($_POST["date"]);
    $phone = test_input($_POST["phone"]);
    $category = test_input($_POST["category"]);
    $items = test_input($_POST["items"]);
    $price = test_input($_POST["price"]);
    $count = test_input($_POST["count"]);
    $total = test_input($_POST["total"]);
    $car = test_input($_POST["car"]);

    // Additional server-side validation can be added here

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO orderdetails (fullname, booking_date, phone, category, items, price, count, total, vehicle_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $fullname, $date, $phone, $category, $items, $price, $count, $total, $car);

    // Execute the statement
    if ($stmt->execute()) {
      echo "<script>alert('Orders are Submitted Successfully')</script>";
      echo "<script>window.open('menu.html','_self')</script>";
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
  <!-- Fontawesome CDN Link For Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* Styles for form and error messages */
    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"],
    select,
    input[type="date"],
    input[type="number"] {
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

    .pass-toggle-btn {
      cursor: pointer;
      position: relative;
      top: -32px;
      right: 10px;
    }
  </style>
</head>
<body>
  <form action="" method="post">
    <h2>Form Validation</h2>

    <div class="form-group date">
      <label for="date">Booking Date</label>
      <input type="date" id="date" name="date">
    </div>
    <div class="form-group country">
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
    <div class="form-group country">
      <label for="items">Select Your Food</label>
      <select id="items" name="items">
        <option value="" selected disabled>Select your Food</option>
        <!-- Options will be populated dynamically using AJAX -->
      </select>
    </div>
    <div class="form-group email">
      <label for="price">One Portion Price</label>
      <input type="text" id="price" name="price" placeholder="Enter the price" readonly>
    </div>
    <div class="form-group email">
      <label for="count">Portion Count</label>
      <input type="number" id="count" name="count" placeholder="Enter the portion count">
    </div>
    <div class="form-group email">
      <label for="total">Total Price</label>
      <input type="text" id="total" name="total" placeholder="Total price" readonly>
    </div>
    <div class="form-group fullname">
      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">
    </div>
    <div class="form-group phone">
      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
    </div>
    <div class="form-group email">
      <label for="car">Vehicle Count</label>
      <input type="number" id="car" name="car" placeholder="Enter the vehicle count">
    </div>
    <div class="form-group submit-btn">
      <input type="submit" value="Submit">
    </div>
  </form>

  <!-- JavaScript -->
  <script>
    // Selecting form and input elements
    const form = document.querySelector("form");

    // Function to display error messages
    const showError = (field, errorText) => {
      field.classList.add("error");
      const errorElement = document.createElement("small");
      errorElement.classList.add("error-text");
      errorElement.innerText = errorText;
      field.closest(".form-group").appendChild(errorElement);
    }

    // Function to handle form submission
    const handleFormData = (e) => {
      e.preventDefault();

      // Retrieving input elements
      const fullnameInput = document.getElementById("fullname");
      const dateInput = document.getElementById("date");
      const phoneInput = document.getElementById("phone");
      const category = document.getElementById("category");
      const items = document.getElementById("items");
      const price = document.getElementById("price");
      const count = document.getElementById("count");
      const total = document.getElementById("total");
      const car = document.getElementById("car");

      // Getting trimmed values from input fields
      const fullname = fullnameInput.value.trim();
      const date = dateInput.value;
      const phone = phoneInput.value.trim();
      const categoryname = category.value;
      const itemsyname = items.value;
      const pricename = price.value;
      const countname = count.value;
      const totalname = total.value;
      const carn = car.value;

      // Regular expression pattern for phone number (10 digits)
      const phonePattern = /^[0-9]{10}$/;

      // Clearing previous error messages
      document.querySelectorAll(".form-group .error").forEach(field => field.classList.remove("error"));
      document.querySelectorAll(".error-text").forEach(errorText => errorText.remove());

      // Performing validation checks
      if (fullname === "") {
        showError(fullnameInput, "Enter your full name");
      }
      if (date === "") {
        showError(dateInput, "Select your booking date");
      }
      if (!phone.match(phonePattern)) {
        showError(phoneInput, "Enter a valid 10-digit phone number");
      }
      if (categoryname === "") {
        showError(category, "Select your Food Category");
      }
      if (itemsyname === "") {
        showError(items, "Select your Food");
      }
      if (pricename === "") {
        showError(price, "Enter the price");
      }
      if (countname === "") {
        showError(count, "Enter the portion count");
      }
      if (totalname === "") {
        showError(total, "Enter the total price");
      }
      if (carn === "") {
        showError(car, "Enter the vehicle count");
      }

      // Checking for any remaining errors before form submission
      const errorInputs = document.querySelectorAll(".form-group .error");
      if (errorInputs.length > 0) return;

      // Submitting the form
      form.submit();
    }

    // Handling form submission event
    form.addEventListener("submit", handleFormData);

    // Fetch items dynamically based on selected category using jQuery
    $(document).ready(function () {
        $('#category').change(function () {
            var selectedCategory = $(this).val();

            // Clear the existing options in the items select
            $('#items').empty().append('<option value="" selected disabled>Select your Food</option>');
            $('#price').val('');
            $('#total').val('');

            if (selectedCategory !== "") {
                // Fetch items for the selected category using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'get_foods.php', // Replace with the correct path to your PHP script
                    data: { category_id: selectedCategory },
                    success: function (response) {
                        // Update the items select with the fetched items
                        $('#items').html(response);
                    }
                });
            }
        });

        // Fetch price dynamically based on selected item using jQuery
        $('#items').change(function () {
            var selectedFood = $(this).val();
            var selectedCategory = $('#category').val();

            if (selectedFood !== "") {
                // Fetch price for the selected item using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'get_price.php', // Replace with the correct path to your PHP script
                    data: { category_id: selectedCategory, food_id: selectedFood },
                    success: function (response) {
                        // Update the price input with the fetched price
                        $('#price').val(response);
                        calculateTotal();
                    }
                });
            }
        });

        // Calculate total price dynamically
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
    });
  </script>
</body>
</html>
