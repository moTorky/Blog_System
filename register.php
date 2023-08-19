<?php
include('./inc/db_connection.php');

if (!empty($_POST['username']) && !empty($_POST['password'])){

    $username = $_POST['username'];
    $passowrd = $_POST['password'];
    $passowrd = password_hash($passowrd,PASSWORD_DEFAULT);
    $errors=[];

    try{
        $sql= $db->prepare('INSERT INTO `users` (`username`,`password`) VALUES (?,?)');
        $inserted = $sql->execute([$username,$passowrd]);
        if ($inserted){
            header('location: login.php');
        }

    }catch(Exception $e){
        $errors['insert_error']='faild to insert new author';
    }
}


?>
<form action="./register.php" method="post">
    username: <input type="text" name="username" id=""></br>
    password: <input type="password" name="password" id=""></br>
    <button type="submit">regeister</button>
</form>