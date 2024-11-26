<?php
include('db_connection.php');

// Check if the request is a POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID and type (table) from the POST request
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    // Map the type to the correct table
    $table = '';
    if ($type == 'announcement') {
        $table = 'announcements';
    } elseif ($type == 'event') {
        $table = 'events';
    } elseif ($type == 'information') {
        $table = 'information';
    }

    // Check if we have a valid ID and a valid table name
    if ($id > 0 && !empty($table)) {
        // Prepare the SQL statement to delete the record from the corresponding table
        $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo ucfirst($type) . " deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid ID or type.";
    }
}

$conn->close();
?>
