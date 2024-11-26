<?php

include('db_connection.php');

$sql = "SELECT user_email, rating, review_text FROM reviews ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="review-card">';
        echo '    <div class="review-content">';
        echo '        <div class="review-rating">';
        
        // Generate star rating
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $row['rating']) {
                echo '            <span class="star">★</span>'; // Full star
            } else {
                echo '            <span class="star">☆</span>'; // Empty star
            }
        }

        echo '        </div>';
        echo '        <p class="review-text">' . htmlspecialchars($row['review_text']) . '</p>'; // Display review text
        
        // Display the user's email
        echo '        <p class="review-email">Reviewed by: ' . htmlspecialchars($row['user_email']) . '</p>'; // Display user email
        echo '    </div>';
        echo '</div>';
    }
} else {
    echo "No reviews found.";
}

// Close connection
$conn->close();
?>
