<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>All Orders</title>
    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    padding: 20px;
    background-color: #f4f4f4;
}
.menu{
    display:flex;
    align-items:center;
    justify-content:space-between;
}
/* Header styles */
h3 {
    text-align: center;
    margin-bottom: 20px;
}

/* Form styles */
form {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 20px;
}

form label {
    margin: 10px;
}

form input[type="date"] {
    margin: 10px;
    padding: 5px;
}

form button {
    margin: 10px;
    padding: 5px 10px;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

thead th {
    background-color: #333;
    color: #fff;
    text-align: left;
    padding: 10px;
}

tbody td {
    border: 1px solid #ddd;
    padding: 10px;
}

/* Responsive styles */
@media (max-width: 768px) {
    table,
    thead,
    tbody,
    th,
    td,
    tr {
        display: block;
    }

    thead {
        display: none;
    }

    tr {
        margin-bottom: 10px;
    }

    td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        position: relative;
        padding-left: 50%;
    }

    td:before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: bold;
    }
}

@media (max-width: 480px) {
    form {
        flex-direction: column;
        align-items: center;
    }

    form label,
    form input[type="date"],
    form button {
        width: 100%;
        margin: 5px 0;
    }
}
    </style>
</head>
<body>
<div class="menu">
<a href="../user/Home.html">Back to Home</a>
<a href="adminpage.php">Booking Details</a>
<a href="#">Order Details</a>
<a href="userdetails.php">User Details</a>
<a href="admindetails.php">Admin details</a>
<a href="feedback.php">Feed Back</a>
<a href="registeradmin.php">Create Register</a>
</div>
<h3>All Food Order Details Deatils</h3>



<!-- Search Form -->
<form method="post" action="">
    <label for="search_name">Search by dates:</label>
    <input type="date" name="search_name" id="search_name" placeholder="Enter date" autocomplete="off">
    <button type="submit" name="submit_search">Search</button>
</form>


<table>
    <thead>
        <?php
        // Connect to the database
        $conn = new mysqli('127.0.0.1', 'root', '', 'newra14');

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Handle Order Deletion
        if (isset($_GET['delete_orders'])) {
            $delete_orders = $_GET['delete_orders'];
            $delete = "DELETE FROM `delivery` WHERE id = $delete_orders";
            $result = mysqli_query($conn, $delete);
            if ($result) {
                echo "<script>alert('Order deleted successfully');</script>";
            } else {
                echo "<script>alert('Failed to delete order');</script>";
            }
        }

        // Initialize the error message variable
        $error_message = "";
        $get_orders = "SELECT * FROM `delivery`";
        
        // Handle Search
        if (isset($_POST['submit_search'])) {
            $search_date = mysqli_real_escape_string($conn, $_POST['search_name']);
            if (!empty($search_date)) {
                $get_orders .= " WHERE fullname = '$search_date'";
            }
        }
        
        $result = mysqli_query($conn, $get_orders);
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
            exit;
        }

        $row_count = mysqli_num_rows($result);

        if ($row_count == 0) {
            echo "<h2>No orders found</h2>";
        } else {
            echo "<tr>
                <th>Order No</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Food Category</th>
                <th>Food</th>
                <th>Person Counts</th>
                <th>Total</th>
                <th>Order time</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>";

            while ($row_data = mysqli_fetch_assoc($result)) {
                $orderid = $row_data['id'];
                $fullname = $row_data['fullname'];
                $phone = $row_data['phone'];
                $category = $row_data['category'];
                $items = $row_data['items'];
                $count = $row_data['count'];
                $total = $row_data['total'];
                $created_at = $row_data['created_at'];
                echo "<tr>
                    <td>$orderid</td>
                    <td>$fullname</td>
                    <td>$phone</td>
                    <td>$category</td>
                    <td>$items</td>
                    <td>$count</td>
                    td>$total</td>
                    <td>$created_at</td>
                    <td><a href='orderdetails.php?delete_orders=$orderid'><i class='fa-solid fa-trash'></i></a></td>
                </tr>";
            }
        }
        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>
