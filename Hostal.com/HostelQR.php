<?php
// process-entry-exit.php
header('Content-Type: application/json');

include('db_connection.php');

// Get the JSON input from the request
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];

if (!$email) {
  echo json_encode(['success' => false, 'message' => 'Invalid User email']);
  exit;
}

// Check if user exists in the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
  echo json_encode(['success' => false, 'message' => 'User not found']);
  exit;
}

// Toggle user status (entry/exit)
if ($user['status'] == 'outside') {
  // Update user status to 'inside'
  $stmt = $pdo->prepare("UPDATE users SET status = 'inside' WHERE email = ?");
  $stmt->execute([$userId]);
  echo json_encode(['success' => true, 'action' => 'entered']);
} else {
  // Update user status to 'outside'
  $stmt = $pdo->prepare("UPDATE users SET status = 'outside' WHERE email = ?");
  $stmt->execute([$userId]);
  echo json_encode(['success' => true, 'action' => 'exited']);
}

?>

