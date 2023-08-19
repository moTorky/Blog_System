<?php
include('./inc/db_connection.php');

if(empty($_GET['id'])){
    $id=$_GET['id'];
        $errors['view_id_err']='id not set in view profile id';
        header('location: index.php');
        exit();
}

include('./inc/header.php');
$id=$_GET['id'];
try{
    $sql = $db->prepare('SELECT `pic_path` , `username` , `bio` FROM `users` WHERE `id`='.$id);
    $sql->execute();
    $user=$sql->fetch(PDO::FETCH_ASSOC);
    if (!$user){
        $errors['not_user']='user not found';
        // header('location: index.php');
        exit();
    }
}catch(Exception $e){
    $errors['not_user']='user not found';
    header('location: index.php');
    exit();
}

try{
    $sql2 = $db->prepare('SELECT * FROM `posts` WHERE `author_id`='.$id.' AND `published`=1');
    $sql2->execute();
    $posts=$sql2->fetchAll(PDO::FETCH_ASSOC);
}catch(Exception $e){
    $errors['not_user']='user not found';
    header('location: index.php');
    die();
}
;
?>

  <div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('images/hero_5.jpg');">
    <div class="container">
      <div class="row same-height justify-content-center">
        <div class="col-md-6">
          <div class="post-entry text-center">
            <div class="bio text-center">
              <img src=<?php echo $user['pic_path'];?> alt="Image Placeholder" class="img-fluid mb-3">
              <div class="bio-body">
                <h2><?php echo $user['username'];?></h2>
                <p class="mb-4"><?php echo $user['bio'];?></p>
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
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">

      <div class="row blog-entries element-animate">

        <div class="col-md-12 col-lg-8 main-content">

          <div class="row posts-entry">
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
					</div>
                    <?php }?>
    
              <div class="row text-start pt-5 border-top">
                <div class="col-md-12">
                  <div class="custom-pagination">
                    <span>1</span>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <span>...</span>
                    <a href="#">15</a>
                  </div>
                </div>
              </div>
    
            </div>
    
    
            </div>
          </div>

        </div>

        <!-- END main-content -->

      </div>
    </div>
  </section>


<?php include('./inc/footer.php');?>