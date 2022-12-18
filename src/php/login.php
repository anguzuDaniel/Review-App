<?php

// Connect to the database
$conn = mysqli_connect('localhost', 'username', 'password', 'database');

// Check the connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit;
}

// Get the form data
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Retrieve the user's account from the database
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
  // No account found
  echo "Invalid email or password";
} else {
  // Account found, verify the password
  $user = mysqli_fetch_assoc($result);
  if (password_verify($password, $user['password'])) {
    // Password is correct, log the user in
    session_start();
    $_SESSION['user_id'] = $user['id'];
    header('Location: dashboard.php');
  } else {
    // Password is incorrect
    echo "Invalid email or password";
  }
}

mysqli_close($conn);
?>
