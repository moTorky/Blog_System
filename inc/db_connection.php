<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=blog_system","root","");
} catch (Exception $e){
    echo "Error : ".$e->getMessage();
    die('Could not connect to the database.');  //die() terminates execution of a script.
}
