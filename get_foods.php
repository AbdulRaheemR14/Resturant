<?php
// Connect to the database
$conn = new mysqli('127.0.0.1', 'root', '', 'newra14');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['category_id'])) {
    $category_id = $conn->real_escape_string($_POST['category_id']);

    $select_query = "SELECT * FROM `foods` WHERE category_id = ?";
    $stmt = $conn->prepare($select_query);
    $stmt->bind_param("s", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $options = '<option value="" selected disabled>Select your Food</option>';
    while ($row = $result->fetch_assoc()) {
        $food_title = htmlspecialchars($row['food_title']);
        $food_id = htmlspecialchars($row['food_id']);
        $options .= "<option value='$food_id'>$food_title</option>";
    }

    echo $options;

    $stmt->close();
}

$conn->close();
?>
