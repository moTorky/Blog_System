    <div class="sidebar-box">
        <h3 class="heading">Popular Posts</h3>
        <div class="post-entry-sidebar">
            <ul>
                <?php 
                try{
                    $url= parse_url( $_SERVER[ 'REQUEST_URI' ], PHP_URL_PATH ); // -> /Blog_system/category.php
                    $path = explode("/", $url);
                    $endpoint = end($path);
                    $category_name='Business';
                    if(isset($_GET['name']))
                        $category_name=$_GET['name'];
                    // echo $endpoint;
                    switch ($endpoint){
                        case 'single.php':
                            $posts = get_user_posts($post['author_id']);
                            break;
                        default:
                            $posts  = get_category_posts_by_name($category_name,'rate');
                    }

                        // $sql1 = $db->prepare('SELECT id,title,created,cover_img_path FROM `posts` WHERE `id` in '.$ids.' AND published=1 ORDER BY rate DESC LIMIT 3');
                        // $sql1->execute();
                        // $posts = $sql1->fetchALL(PDO::FETCH_ASSOC);
                    }catch(Exception $e){
                        $errors['category_id_n']='category id not exist';
                        header('location: index.php');
                        exit();
                    }
                    foreach($posts as $post){
                ?>
                    <li>
                        <a href=single.php?id=<?php echo $post['id'];?>>
                            <img src=<?php echo $post['cover_img_path'];?> alt="Image placeholder" class="me-4 rounded">
                            <div class="text">
                                <h4><?php echo $post['title'];?></h4>
                                <div class="post-meta">
                                    <span class="mr-2"><?php echo $post['created'];?></span>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
    <!-- END sidebar-box -->

    <div class="sidebar-box">
        <h3 class="heading">Categories</h3>
        <ul class="categories">
            <?php
                $sql=$db->prepare('SELECT c.id, c.name AS category_name, COUNT(p.post_id) AS post_count
                FROM category c
                LEFT JOIN post_category p ON c.id = p.category_id
                GROUP BY c.id, c.name
                ORDER BY post_count DESC');
                $sql->execute();
                $results=$sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($results as $result){
            ?>
            <li><a href="category.php?name=<?php echo $result['category_name'];?>"><?php echo $result['category_name']; ?><span>(<?php echo $result['post_count']; ?>)</span></a></li>
                <?php }?>
        </ul>
    </div>
    <!-- END sidebar-box -->

    <div class="sidebar-box">
        <h3 class="heading">Tags</h3>
        <ul class="tags">
            <li><a href="#">Travel</a></li>
            <li><a href="#">Adventure</a></li>
            <li><a href="#">Food</a></li>
            <li><a href="#">Lifestyle</a></li>
            <li><a href="#">Business</a></li>
            <li><a href="#">Freelancing</a></li>
            <li><a href="#">Travel</a></li>
            <li><a href="#">Adventure</a></li>
            <li><a href="#">Food</a></li>
            <li><a href="#">Lifestyle</a></li>
            <li><a href="#">Business</a></li>
            <li><a href="#">Freelancing</a></li>
        </ul>
    </div>
