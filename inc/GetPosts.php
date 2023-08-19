<?php
include('./inc/db_connection.php');
function get_user_posts($user_id){
    global $db;
    $sql1 = $db->prepare('SELECT * FROM `posts` WHERE `author_id` = '.$user_id.' AND published=1 ORDER BY created DESC LIMIT 3');
    $sql1->execute();
    $posts = $sql1->fetchALL(PDO::FETCH_ASSOC);
    return $posts;
}
function arr_to_str($post_ids){
    global $ids;
    $ids = '(';
    foreach ($post_ids as $id) {
        $ids .= strval($id) . ',';
    }
    $ids = substr($ids, 0, -1);
    $ids .= ')';
    return $ids;
}
function get_post_ids($category_id){
    global $db;
    $sql = $db->prepare('SELECT * FROM `post_category` WHERE `category_id`='.$category_id); // get category id
    $sql->execute();
    $post_ids = $sql->fetchAll(PDO::FETCH_COLUMN);
    $ids = arr_to_str($post_ids);  
    return $ids; 
}
function get_category_posts($category_id, $order_by){
    global $db;
    $ids=get_post_ids($category_id);
    $sql1 = $db->prepare('SELECT * FROM `posts` WHERE `id` in '.$ids.' AND published=1 ORDER BY '.$order_by.' DESC LIMIT 5');
    $sql1->execute();
    $posts = $sql1->fetchALL(PDO::FETCH_ASSOC);
    return $posts;
}

function get_category_posts_by_name($category_name, $order_by){
    global $db;
    $sql = $db->prepare('SELECT id FROM `category` WHERE `name`="'.$category_name.'" LIMIT 6'); // get category id
    $sql->execute();
    $category_row = $sql->fetch(PDO::FETCH_ASSOC);
    
    if ($category_row) {
        $category_id = $category_row['id'];
        return get_category_posts($category_id, $order_by);
    } else {
        // Handle the case where the category doesn't exist
        return array(); // Return an empty array or handle it as appropriate
    }
}


function get_posts_by_title_keyword($searchKey){
    global $db;
    $sql1 = $db->prepare('SELECT * FROM `posts` WHERE `title` LIKE "%'.$searchKey.'%" AND published=1 ORDER BY created DESC LIMIT 5');
    $sql1->execute();
    $posts = $sql1->fetchALL(PDO::FETCH_ASSOC);
    return $posts;
}

// limit_posts_number, selected_columns, array_to_string:func




// include('./inc/db_connection.php');

// // Set PDO to throw exceptions on errors
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// function get_user_posts($user_id, $limit = 3) {
//     global $db;
//     $sql = $db->prepare('SELECT * FROM `posts` WHERE `author_id` = :user_id AND published=1 ORDER BY created DESC LIMIT :limit');
//     $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $sql->bindParam(':limit', $limit, PDO::PARAM_INT);
//     $sql->execute();
//     $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
//     return $posts;
// }

// function arr_to_str($post_ids) {
//     return implode(',', $post_ids);
// }

// function get_post_ids($category_id) {
//     global $db;
//     $sql = $db->prepare('SELECT * FROM `post_category` WHERE `category_id` = :category_id');
//     $sql->bindParam(':category_id', $category_id, PDO::PARAM_INT);
//     $sql->execute();
//     $post_ids = $sql->fetchAll(PDO::FETCH_COLUMN);
//     return arr_to_str($post_ids);
// }

// function get_category_posts($category_id, $order_by) {
//     global $db;
//     $ids = get_post_ids($category_id);
//     $sql = $db->prepare('SELECT * FROM `posts` WHERE `id` IN (' . $ids . ') AND published=1 ORDER BY ' . $order_by . ' DESC LIMIT 5');
//     $sql->execute();
//     $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
//     return $posts;
// }

// function get_category_posts_by_name($category_name, $order_by) {
//     global $db;
//     $sql = $db->prepare('SELECT id FROM `category` WHERE `name` = :category_name LIMIT 6');
//     $sql->bindParam(':category_name', $category_name, PDO::PARAM_STR);
//     $sql->execute();
//     $category_id = $sql->fetch()['id'];
//     return get_category_posts($category_id, $order_by);
// }

// function get_posts_by_title_keyword($searchKey) {
//     global $db;
//     $searchKey = '%' . $searchKey . '%';
//     $sql = $db->prepare('SELECT * FROM `posts` WHERE `title` LIKE :search_key AND published=1 ORDER BY created DESC LIMIT 5');
//     $sql->bindParam(':search_key', $searchKey, PDO::PARAM_STR);
//     $sql->execute();
//     $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
//     return $posts;
// }

// // Example usage for searching posts by title keyword
// if (isset($_GET['searchKey'])) {
//     $searchKey = filter_input(INPUT_GET, 'searchKey', FILTER_SANITIZE_STRING);
//     $posts = get_posts_by_title_keyword($searchKey);

//     // Process and display $posts
// }
?>
