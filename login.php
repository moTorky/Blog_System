<?php
include('./inc/db_connection.php');
session_start(); //1 day

if (!empty($_POST['username']) && !empty($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $password_hash= password_hash($password,PASSWORD_DEFAULT);
    $errors=[];
    try{
        $sql = $db->prepare('SELECT *  FROM `users` WHERE `username`="'.$username.'"');
        $sql->execute();
        $record = $sql->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password,$record['password'])){
            $_SESSION['id'] = $record['id'];
            // var_dump($record);
            // var_dump($_SESSION);
            header("location: index.php");
            exit();
        }else{
            $errors['auth_error']='wronge username or password \n';
        }
    }catch(Exception $e){
        echo $e;
        $errors['sql_error']='can\'t connect to DB\n';
    }

}
?>
<div><?php if(!empty($errors)) var_dump($errors); ?></div>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&amp;display=swap">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css">
<title>Todo App Login</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }
  .container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 300px;
    text-align: center;
  }
  h1 {
    margin-bottom: 20px;
  }
  input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  input[type="submit"] {
    background-color: #007BFF;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
  }
  input[type="submit"]:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
<div class="container">
  <h1>Welcome to:
  <a href="index.php" class="logo m-0 float-start">Blogy<span class="text-primary">.</span></a>
  </h1>
  <!-- <h1>Todo App</h1> -->
  <form method="POST" action="login.php"> <!-- Replace 'dashboard.html' with your actual dashboard page -->
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="submit" value="Login">
    <?php
    // Display errors to the user
    if (isset($error['sql'])) {
        echo "<div class='alert alert-danger'>" . $error['sql'] . "</div>";
    }
    if (isset($error['login'])) {
        echo "<div class='alert alert-danger'>" . $error['login'] . "</div>";
    }
    if (isset($error['database'])) {
        echo "<div class='alert alert-danger'>" . $error['database'] . "</div>";
    }
    ?>
  </form>
<div class="text-center mt-3">
                    <p>Don't have an account? </br><a href="register.php" data-toggle="collapse">Register here</a></p>
                </div>
                </div>

</body>
</html>


