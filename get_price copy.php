<?php
// Connect to the database
$conn = new mysqli('127.0.0.1', 'root', '', 'newra14');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['category_id']) && isset($_POST['food_id'])) {
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $food_id = $conn->real_escape_string($_POST['food_id']);

    $select_query = "SELECT price FROM `foods` WHERE category_id = ? AND food_id = ?";
    $stmt = $conn->prepare($select_query);
    $stmt->bind_param("ss", $category_id, $food_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo htmlspecialchars($row['price']);
    }

    $stmt->close();
}

$conn->close();
?>
