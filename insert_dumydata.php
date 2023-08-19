<?php
include('./inc/db_connection.php');

$categories = ['Lifestyle','Travel','Fashion','news','politics'];
$sql =  $db->prepare('INSERT INTO `category`(`id`, `name`) VALUES (?,?)');
foreach($categories as $category){
    echo $category;
    $sql->execute(['',$category]);
}
