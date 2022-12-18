<?php

// Include the Stream library
require 'vendor/autoload.php';

// Initialize the client with your API key and secret
$client = new GetStream\Stream\Client('yaqxxabetrc9', '4fvxru8f9dsjy9c5exzwrxxbymfdmv399yvqc8xryqr2z4g446mtscsj58kn7xjg');
// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$rating = $_POST['rating'];
$review = $_POST['review'];

// Create the data for the activity
$data = [
  "actor" => "SU:$email",
  "verb" => "review",
  "object" => "Product:$productId",
  "review" => $review,
  "rating" => $rating,
];

// Add the activity to the user's feed
$userFeed = $client->feed('user', $email);
$userFeed->addActivity($data);

// Redirect the user back to the form or display a message
header('Location: form.php');
?>
