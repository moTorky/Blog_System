    <?php
    include('./inc/db_connection.php');
    $user_id=$_SESSION['id'];
    $sql = $db->prepare('SELECT * FROM `users` WHERE `id`='.$user_id);
    $sql -> execute();
    $user=$sql->fetch(PDO::FETCH_ASSOC);
    ?>
    <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
        <li class="has-children">
        <div class="post-meta align-items-center text-center">
              <figure class="author-figure mb-0 me-3 d-inline-block"><img src=<?php echo $user['pic_path'];?> alt="Image" class="img-fluid"></figure>
        </div>
            <ul class="dropdown">
                    <li><a href="profile.php">profile</a></li>
                    <li><a href="logout.php">logout</a></li>
            </ul>
        </li>
    </ul>
    <!-- <div class="post-meta align-items-right text-right clearfix has-children">
        <figure class="author-figure mb-0 me-3 float-end">
            <img src="assets/user/images/person_1.jpg" alt="Image" class="img-fluid">
            <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto dropdown">
                <li><a href="search-result.html">Search Result</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="single.html">Blog Single</a></li>
            </ul>
        </figure>
    </div>
</div> -->