<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}   
include('./inc/db_connection.php');
if(empty($_SESSION['id'])){
    $errors['not_auth']='u not authorized to see profile page, plz login first';
    header('location: login.php');
    exit();
    //can we send msg to other pages using die('msg'); ??
}
//redirect other users to index.php ; :) but why u just use the session id to retrive user's data
// if(isset($_GET['id'])){
//     $id=$_GET['id'];
//     $cid=$_SESSION['id'];
//     if ($cid !== $id){
//         $errors['not_auth']='u not authorized to access other profiles data';
//         header('location: index.php');
//         exit();
//     }
// }
// var_dump($_SESSION);

include('./inc/header.php');
if(isset($_POST['password']) ||isset($_POST['bio']) ||isset($_FILES['pic_path'])){
    $bio=$user['bio'];
    if(isset($_POST['bio'])){
        $bio=$_POST['bio'];
    }
    $password=$user['password'];
    if(isset($_POST['password'])){
        $password=$_POST['password'];
        $password=password_hash($password,PASSWORD_DEFAULT);
    }
    $pic_path=$user['pic_path'];
    $typeallowed = ['jpg', 'png', 'pjpg'];
    // var_dump($_FILES);
    if (isset($_FILES['pic_path'])) {
        $from = $_FILES['pic_path']['tmp_name'];
        $name = $_FILES['pic_path']['name'];
        $strr2arr = explode(".", $name);
        //to get extention 
        $ext = end($strr2arr);
        $ext = strtolower($ext);
        if (in_array($ext, $typeallowed)) {
            $to = "assets/uploads/images/" . $user['username'] . '_' . md5($name) . "$name";
            move_uploaded_file($from, $to);
            $pic_path= $to;
        } else {
            $errors['img_err']="image type not alowed";
            die();
        }
    }
    $sql=$db->prepare('UPDATE `users` SET `bio`=? , `password`=? , `pic_path`=? WHERE `id`='.$_SESSION['id']);
    $res=$sql->execute([$bio,$password,$pic_path]);
    if($res){
        $errors['update']='account updated sucssfully';
        // header('location: profile.php');
        // die();
    }else{
        $errors['update_err']='something go wrong when try to update user\'s profile';
    }
}

$sql2 = $db->prepare('SELECT * FROM `posts` WHERE `author_id`='.$user_id);
$sql2 -> execute();
$posts=$sql2->fetchAll(PDO::FETCH_ASSOC);
// var_dump($user);
?>

<div class="section">
    <div class="container">
        <form action="profile.php" method="post" enctype="multipart/form-data"
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <div class="post-entry text-center">
                        <div class="bio text-center">
                            <img src=<?php echo $user['pic_path'];?> alt="Image Placeholder" class="img-fluid mb-3">
                            <div class="bio-body">
                                <label for="file">Upload Your account image</label>
                                <input id="file" type="file" name="pic_path">
                                <p class="social">
                                <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                                <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                                <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                                <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-8 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <div class="row">
                            <div class="col-6 mb-3">
                                username: <input type="text" class="form-control" placeholder="Your Name" disabled value=<?php    echo $user['username'];?>>
                            </div>
                            <div class="col-12 mb-3">
                                bio: <input type="text" class="form-control" name="bio" value=<?php echo $user['bio'];?>>
                            </div>
                            <div class="col-12 mb-3">
                                update password: <input type="password" name="password" id="" class="form-control" placeholder="new password">
                            </div>
                        </div>
                    </div>
                <div class="col-6 text-end align-items-right">
                    <input type="submit" value="update account" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</div>

  <section class="section">
    <div class="container">
      <div class="row blog-entries element-animate">
        <div class="col-md-12 col-lg-12 main-content">
          <div class="row posts-entry">
            <div class="col-12 text-end align-items-right heading">
                        <form action="CreatePost.php" method="get">
                            <input type="submit" value="create new post" class="btn btn-success">
                        </form>
                </div>
            <div class="col-lg-12">
            <?php foreach($posts as $post){?>
					<div class="blog-entry d-flex blog-entry-search-item">
						<a href="single.php?id=<?php echo $post['id'];?>" class="img-link me-4">
							<img src=<?php echo $post['cover_img_path'];?> alt="Image" class="img-fluid">
						</a>
						<div>
							<span class="date"><?php echo $post['updated'];?> &bullet; <?php if($post['published']){echo "published";}else{echo "admin not publish it yet";}?></span>
                            <h2><a href="single.php?id=<?php echo $post['id'];?>"><?php echo $post['title'];?></a></h2>
							<p><?php echo substr($post['content'],0,80);?></p>
							<p><a href="single.php?id=<?php echo $post['id'];?>" class="btn btn-sm btn-outline-primary">Read More</a></p>
						</div>
                        <div class="col d-flex align-items-center justify-content-end">
                            <form action="EditPost.php" method="post">
                                <h5 class="m-0 p-0 px-2">
                                    <input type="text" name="post_id" id="" value=<?php echo $post['id'];?> hidden="">                                    
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                        </svg>
                                        Update
                                    </button>
                                </h5>
                            </form>
                            <form action="DeletePost.php" method="post">
                                <h5 class="m-0 p-0 px-2">
                                    <input type="text" name="post_id" id="" value=<?php echo $post['id'];?> hidden="">                                    
                                    <!-- <button type="submit">
                                    <i class="bi bi-trash text-danger" title="Delete post"></i>
                                    </button> -->
                                    <button type="sumbit" class="btn btn-outline-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"></path>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </h5>
                            </form>
                        </div>
					</div>
                    
                    <?php }?>
    
            </div>
    
    
            </div>
          </div>

        </div>

        <!-- END main-content -->

      </div>
    </div>
  </section>
<?php include('./inc/footer.php');?>