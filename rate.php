<?php
include('./inc/db_connection.php');
session_start();
$errors = array();
if(empty($_SESSION['id'])){
    $errors['not_auth'] = 'You are not authorized to rate a posts. Please login first.';
    $_SESSION['errors'] = $errors;
    header('Location: login.php');
    exit();
}
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['post_id'])) {
    // Get the posted rating value
    $rating = isset($_POST['rate']) ? intval($_POST['rate']) : 0;
    $comment = $_POST['comment'];
    $rating=intval($rating);
  
    
    // You can also get other data from the POST request if needed
    
    // Get the post ID from the URL parameter (assuming you've extracted it)
    $postId = $_POST['post_id'];
    $user_id= $_SESSION['id'];
    // Validate the rating value (e.g., ensure it's within a valid range)
    // if (!empty(isset($_POST['id'])) && $rating >= 1 && $rating <= 5) {
    //     var_dump($_POST);
    //   die();    
        // Perform database operations to store the rating for the post with $postId
          
          // Example: Update the database with the rating
          // You'll need to replace this with your actual database update logic
          // For demonstration purposes, we're assuming a fictional database connection variable $db
          // and a fictional table called 'post_ratings' with columns 'post_id' and 'rating'
          // This is a simplified example and should be adapted to your actual database structure
          try {            
              // Prepare the SQL statement
              //INSERT INTO `comments_and_rates`(`post_id`, `user_id`, `rate`, `comment`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
              $sql = $db->prepare('INSERT INTO `comments_and_rates`(`post_id`, `user_id`, `rate`, `comment`) VALUES (:post_id, :user_id, :rating, :comment)');
              $sql->bindParam(':post_id', $postId, PDO::PARAM_INT);
              $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
              $sql->bindParam(':rating', $rating, PDO::PARAM_INT);
              $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
              
              // Execute the SQL statement
              if ($sql->execute()) {
                  // Rating successfully recorded
                  echo 'Rating submitted successfully!';
                  header('location: single.php?id='.$postId);
                  exit();
              } else {
                  // Error occurred while recording the rating
                  echo 'Error submitting rating.';
              }
          } catch (PDOException $e) {
              // Handle database connection error
              echo 'Database connection error: ' . $e->getMessage();
          }
//       } else {
//           // Invalid rating value
//           echo 'Invalid rating value.';
//       }
  }
  