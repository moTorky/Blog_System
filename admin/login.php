<?
include('./inc/db_connection.php');

if (!empty($_POST['username']) && !empty($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $passwprd= password_hash($password,0);
    $errors=[];
    if(!empty($errors)){
        $sql = $db->prepare('SELECT *  FROM `users` WHERE `username` = '.$username);
        $sql -> execute();
        if(password_verify($password,$sql['password'])){
            session_start(['cookie_lifetime' => '86400']); //1 day
            
        }

    }
}