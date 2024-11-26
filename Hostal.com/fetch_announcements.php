<?php
include('db_connection.php');

$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    $announcements = [];
    // Fetch each announcement
    while($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
    // Return the data as a JSON response
    echo json_encode($announcements);
} else {
    echo json_encode([]);
}

$conn->close();
?>
