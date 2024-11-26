<?php
include('db_connection.php'); // Include your database connection

$sql = "SELECT user_email, guest_name, status FROM guest_requests";
$result = mysqli_query($conn, $sql);

$guestRequests = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $guestRequests[] = $row;
    }
    echo json_encode($guestRequests); // Echo the data to check output
} else {
    echo json_encode(["success" => false, "error" => mysqli_error($conn)]); // Error message
}

mysqli_close($conn); // Close connection
?>
