<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if meal_type is provided
    if (isset($_POST['meal_type'])) {
        // Get the meal_type from the request
        $meal_type = $_POST['meal_type'];

        // Prepare the SQL statement to delete the meal
        $query = "DELETE FROM meals WHERE meal_type = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters to avoid SQL injection
        $stmt->bind_param("s", $meal_type);

        // Execute the query
        if ($stmt->execute()) {
            // Success response
            echo json_encode(["success" => true, "message" => "Meal deleted successfully."]);
        } else {
            // Error response
            echo json_encode(["success" => false, "message" => "Error deleting meal."]);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error response if meal_type is missing
        echo json_encode(["success" => false, "message" => "Meal type not provided."]);
    }
} else {
    // If the request method is not POST
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
