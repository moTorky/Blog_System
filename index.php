<?php
include('./inc/db_connection.php');
include('./inc/header.php');
include('./inc/GetPosts.php');

if(!empty($_SESSION['id'])){
    $sql = $db->prepare('SELECT * FROM `users` WHERE `id`='.$_SESSION['id']);
    $sql -> execute();
    $user=$sql->fetchAll(PDO::FETCH_ASSOC);
    if($user[0]['user_role']==0) { //check if admin user, to inclue admin navebar
        include('./inc/admin/navbar.php');
    }   
    // include('./inc/navbar.php');
}

$posts=[];
// TO-DO user select many categories
// if ( !empty($_GET['category']) ){
//     $sql = $db->prepare('SELECT id FROM `category` WHERE `name` IN'.$_GET['category']); // get category id
//     $sql->execute();
//     $category_ids = $sql->fetchAll(PDO::FETCH_ASSOC);

//     $sql2 = $db->prepare('SELECT * FROM `posts` WHERE `category_id` IN '.$category_ids ); // get category id
//     $sql2->execute();
//     $posts = $sql2->fetchAll(PDO::FETCH_ASSOC);
// }
// else{
//     $sql2 = $db->prepare('SELECT * FROM `posts`'); // get category id
//     $sql2->execute();
//     $posts = $sql2->fetchAll(PDO::FETCH_ASSOC);
// }

// var_dump($posts);
?>

<!-- Start retroy layout blog posts -->
<section class="section bg-light">
    <div class="container">
        <div class="row align-items-stretch retro-layout">
            <div class="col-md-4">
                <a href="single.html" class="h-entry mb-30 v-height gradient">

                    <div class="featured-img" style="background-image: url('assets/user/images/img_2_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>AI can now kill those annoying cookie pop-ups</h2>
                    </div>
                </a>
                <a href="single.html" class="h-entry v-height gradient">

                    <div class="featured-img" style="background-image: url('assets/user/images/img_5_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <span class="date">Abo Ali</span>
                        <h2>Don’t assume your user data in the cloud is safe</h2>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="single.html" class="h-entry img-5 h-100 gradient">

                    <div class="featured-img" style="background-image: url('assets/user/images/img_1_vertical.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>Why is my internet so slow?</h2>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="single.html" class="h-entry mb-30 v-height gradient">

                    <div class="featured-img" style="background-image: url('assets/user/images/img_3_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>Startup vs corporate: What job suits you best?</h2>
                    </div>
                </a>
                <a href="single.html" class="h-entry v-height gradient">

                    <div class="featured-img" style="background-image: url('assets/user/images/img_4_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>Thought you loved Python? Wait until you meet Rust</h2>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- End retroy layout blog posts -->

<!-- Start posts-entry -->
<section class="section posts-entry">
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h2 class="posts-entry-title">Business</h2>
            </div>
            <div class="col-sm-6 text-sm-end"><a href="category.php?name=Business" class="read-more">View All</a></div>

        </div>
        <div class="row g-3">
            <div class="col-md-9">
                <div class="row g-3">
                <?php 
                //select posts related to Business and published
                try{
                    $posts=get_category_posts_by_name('Business','rate');
                    // var_dump($posts);
                }catch(Exception $e){
                    $errors['fetch_fild_p']='faild to fetch Fashion posts';
                }
                for($i=0;$i<2;$i++){
                ?>
                    <div class="col-md-6">
                        <div class="blog-entry">
                            <a href="single.php?id=<?php echo $posts[$i]['id'];?>" class="img-link">
                                <img src=<?php echo $posts[$i]['cover_img_path']; ?> alt="Image" class="img-fluid">
                            </a>
                            <span class="date"><?php echo $posts[$i]['updated'];?></span>
                            <h2><a href="single.php?id=<?php echo $posts[$i]['id'];?>"><?php echo $posts[$i]['title'];?></a></h2>
                            <p><?php echo substr($posts[$i]['content'],0,100);?></p>
                            <p><a href="single.php?id=<?php echo $posts[$i]['id'];?>" class="btn btn-sm btn-outline-primary">Read More</a></p>
                        </div>
                    </div>
                <?php }?>
                </div>
            </div>
            <div class="col-md-3">
                <ul class="list-unstyled blog-entry-sm">
                    <?php 
                        for($i=2;$i<count($posts);$i++){
                    ?>
                    <li>
                        <span class="date"><?php echo $posts[$i]['updated'];?></span>
                        <h3><a href="single.php?id<?php echo $posts[$i]['id'];?>"><?php echo $posts[$i]['title'];?></a></h3>
                        <p><?php echo substr($posts[$i]['content'],0,100);?></p>
                        <p><a href="single.php?id<?php echo $posts[$i]['id'];?>" class="read-more">Continue Reading</a></p>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End posts-entry -->


<section class="section">
    <div class="container">

        <div class="row mb-4">
            <div class="col-sm-6">
                <h2 class="posts-entry-title">news</h2>
            </div>
            <div class="col-sm-6 text-sm-end"><a href="category.php?name=news" class="read-more">View All</a></div>
        </div>

        <div class="row">
            <?php 
                //select posts related to news and published
                try{   
                    $posts=get_category_posts_by_name('news','rate');
                }catch(Exception $e){
                    $errors['fetch_fild_p']='faild to fetch Fashion posts';
                }
                // var_dump($post_ids);
                foreach ($posts as $post) {
            ?>
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php?id=<?php echo $post['id'];?>" class="img-link"><img src=<?php echo $post['cover_img_path'];?> alt="Image" class="img-fluid"></a>
                    <div class="excerpt">
                        

                        <h2><a href="single.php?id=<?php echo $post['id'];?>"><?php echo $post['title'];?></a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <?php 
                            //Try to get auther info
                            $user=["username"=>"user" ,"pic_path"=>"assets/user/images/person_1.jpg"];
                            try{
                                $author_id=$post['author_id'];
                                $sql = $db->prepare('SELECT username,pic_path FROM `users` WHERE `id`='.$author_id); // get category id
                                $sql->execute();
                                $user = $sql->fetch();
                                // var_dump($user);
                            }catch(Exception $e){
                                $errors['fetch_fild_a']='faild to fetch author post data of post'.$post['id'];
                            }
                            ?>
                            <figure class="author-figure mb-0 me-3 float-start"><img src=<?php echo $user['pic_path'];?> alt="Image" class="img-fluid"></figure>
                            <span class="d-inline-block mt-1">By <a href=<?php echo $user['pic_path'];?> ><?php echo $user['username'];?> </a></span>
                            <span>&nbsp;-&nbsp; <?php echo $post['updated'];?></span>
                        </div>

                        <p><?php echo substr($post['content'],0,205);?></p>
                        <p><a href="single.php?id=<?php echo $post['id'];?>" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
            <?php }?>

        </div>
        
    </div>
</section>



<?php include('./inc/footer.php');?>