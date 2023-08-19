<?php
include('./inc/db_connection.php');
session_start();
$errors = array();
function verfiy_author($session_id,$post_id){
    //using session id we get the created user's posts
    //if the post_id is in this posts we can delete it
    global $db;
    $sql=$db->prepare('SELECT `id` FROM `posts` WHERE `author_id`='.$session_id);
    $sql->execute();
    $user_posts=$sql->fetchAll(PDO::FETCH_COLUMN);
    return in_array($post_id,$user_posts);
}
function delete_related_categories($post_id){
    global $db;
    $sql=$db->prepare('DELETE FROM `post_category` WHERE `post_id`='.$post_id);
    $res=$sql->execute();
    return $res;
}
function delete_urelated_images($post_id){
    global $db;
    $sql=$db->prepare('DELETE FROM `inc_images_path` WHERE `post_id`='.$post_id);
    $res=$sql->execute();
    return $res;
    
}
//TO_DO delete image from the server
function delete_post($post_id){
    global $db;
    $sql=$db->prepare('DELETE FROM `posts` WHERE `id`='.$post_id);
    $res=$sql->execute();
    return $res;
}
if(empty($_SESSION['id'])){
    $errors['not_auth'] = 'You are not authorized to do this action posts. Please login first.';
    $_SESSION['errors'] = $errors;
    header('Location: login.php');
    exit();
} else {
    if(empty($_POST['post_id'])){
        $errors['del_id_err'] = 'post id not set.';
        header('Location: profile.php');
        exit();
    }
    $post_id=$_POST['post_id'];
    $session_id=$_SESSION['id'];
    echo $post_id.'  '.$session_id;
    if(!verfiy_author($session_id,$post_id)){
        $errors['del_id_msg'] = 'u not allow to del post id not relate to u.';
        header('Location: profile.php');
        exit();
    }
    try{
        $state1=delete_related_categories($post_id);
        $state2=delete_urelated_images($post_id);
        $state3=delete_post($post_id);
        if($state1 &&$state2 &&$state3){
            $errors['del_suc'] = 'post deleted succssfully';
            header('Location: profile.php');
            exit(); 
        }
    }catch(Exception $e){
        $errors['db_error'] = 'An error occurred while deleteing the post.';
    }

    // if (!empty($errors)) {
    //     echo '<pre>'.var_dump($errors).'</pre>';
    // }
}
