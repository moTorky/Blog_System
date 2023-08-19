<?php
include('./inc/db_connection.php');
if(empty($_GET['id'])){
    $previousPage = 'index.php';
    if(isset($_SERVER['HTTP_REFERER'])){
        $previousPage = $_SERVER['HTTP_REFERER'];
    }
        $errors['blog_id']='not blog id set';
        header("Location: $previousPage");
        exit();
}
include('./inc/header.php');
include('./inc/GetPosts.php');
try{
    $post_id = $_GET['id'];
    $sql = $db->prepare('SELECT * FROM `posts` WHERE id='.$post_id.' AND published=1');
    $sql->execute();
    $post=$sql->fetch(PDO::FETCH_ASSOC);

    $sql1 = $db->prepare('SELECT username,pic_path,bio FROM `users` WHERE id='.$post['author_id']);
    $sql1->execute();
    $user=$sql1->fetch(PDO::FETCH_ASSOC);
    
}catch(Exception $e){
  $errors['read_post']='can\'t get data of the selected post';
}


function get_related_img($post_id){
  global $db;
  $imgs_path=array();
  $sql = $db->prepare('SELECT `img_path` FROM `inc_images_path` WHERE post_id='.$post_id);
  $sql->execute();
  $imgs_path=$sql->fetchAll(PDO::FETCH_COLUMN);
  return $imgs_path;
}
// var_dump($post);
?>

<div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('assets/user/images/hero_5.jpg');">
    <div class="container">
      <div class="row same-height justify-content-center">
        <div class="col-md-6">
          <div class="post-entry text-center">
            <h1 class="mb-4"><?php echo $post['title'];?></h1>
            <div class="post-meta align-items-center text-center">
              <figure class="author-figure mb-0 me-3 d-inline-block"><img src=<?php echo $user['pic_path'];?> alt="Image" class="img-fluid"></figure>
              <span class="d-inline-block mt-1">By <?php echo $user['username'];?></span>
              <span>&nbsp;-&nbsp; <?php echo $post['updated'];?></span>
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

          <div class="post-content-body">
            <?php 
              $imgs_path = get_related_img($post_id);
              $imgs_path_with_key_name=array();
              foreach($imgs_path as $img_path){
                $imgs_path_with_key_name[substr($img_path,strpos($img_path,'_')+1,strlen($img_path))]=$img_path;
              }
              var_dump($imgs_path_with_key_name);
              $pieces = explode("img:",$post['content']);
              foreach ($pieces as $piec){
                $included_img=explode(' ',$piec)[0];
                echo $included_img.'</br>';
                // if(in_array($included_img,$imgs_path_with_key_name)){
                  echo '<img src="'.$imgs_path_with_key_name[$included_img].'" alt="Image placeholder" class="img-fluid rounded" style="width: 100%;height: auto;max-width: 100vw;">';
                // }
                // echo $piec.' '.strpos($piec,'_').'  '.substr($piec,strpos($piec,'_')+1,-1).'</br>'; 
              }
              $content = preg_replace('/img:(\S+)/', '<img src="$imgs_path_with_key_name[$1]" alt="Image placeholder" class="img-fluid rounded" style="width: 100%;height: auto;max-width: 100vw;">', $post['content']);
              // //TO_DO get inc_img_path , then find it and replace it with apove img tag
              echo $content;
            ?>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium nam quas inventore, ut iure iste modi eos adipisci ad ea itaque labore earum autem nobis et numquam, minima eius. Nam eius, non unde ut aut sunt eveniet rerum repellendus porro.</p>
            <p>Sint ab voluptates itaque, ipsum porro qui obcaecati cumque quas sit vel. Voluptatum provident id quis quo. Eveniet maiores perferendis officia veniam est laborum, expedita fuga doloribus natus repellendus dolorem ab similique sint eius cupiditate necessitatibus, magni nesciunt ex eos.</p>
            <p>Quis eius aspernatur, eaque culpa cumque reiciendis, nobis at earum assumenda similique ut? Aperiam vel aut, ex exercitationem eos consequuntur eaque culpa totam, deserunt, aspernatur quae eveniet hic provident ullam tempora error repudiandae sapiente illum rerum itaque voluptatem. Commodi, sequi.</p>
            <div class="row my-4">
              <div class="col-md-12 mb-4">
                <img src="assets/user/images/hero_1.jpg" alt="Image placeholder" class="img-fluid rounded">
              </div>
              <div class="col-md-6 mb-4">
                <img src="assets/user/images/img_2_horizontal.jpg" alt="Image placeholder" class="img-fluid rounded">
              </div>
              <div class="col-md-6 mb-4">
                <img src="assets/user/images/img_3_horizontal.jpg" alt="Image placeholder" class="img-fluid rounded">
              </div>
            </div>
            <p>Quibusdam autem, quas molestias recusandae aperiam molestiae modi qui ipsam vel. Placeat tenetur veritatis tempore quos impedit dicta, error autem, quae sint inventore ipsa quidem. Quo voluptate quisquam reiciendis, minus, animi minima eum officia doloremque repellat eos, odio doloribus cum.</p>
            <p>Temporibus quo dolore veritatis doloribus delectus dolores perspiciatis recusandae ducimus, nisi quod, incidunt ut quaerat, magnam cupiditate. Aut, laboriosam magnam, nobis dolore fugiat impedit necessitatibus nisi cupiditate, quas repellat itaque molestias sit libero voluptas eveniet omnis illo ullam dolorem minima.</p>
            <p>Porro amet accusantium libero fugit totam, deserunt ipsa, dolorem, vero expedita illo similique saepe nisi deleniti. Cumque, laboriosam, porro! Facilis voluptatem sequi nulla quidem, provident eius quos pariatur maxime sapiente illo nostrum quibusdam aliquid fugiat! Earum quod fuga id officia.</p>
            <p>Illo magnam at dolore ad enim fugiat ut maxime facilis autem, nulla cumque quis commodi eos nisi unde soluta, ipsa eius aspernatur sint atque! Nihil, eveniet illo ea, mollitia fuga accusamus dolor dolorem perspiciatis rerum hic, consectetur error rem aspernatur!</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus magni explicabo id molestiae, minima quas assumenda consectetur, nobis neque rem, incidunt quam tempore perferendis provident obcaecati sapiente, animi vel expedita omnis quae ipsa! Obcaecati eligendi sed odio labore vero reiciendis facere accusamus molestias eaque impedit, consequuntur quae fuga vitae fugit?</p>
           -->
          </div>


          <div class="pt-5">
            <p>Categories:  <a href="#">Food</a>, <a href="#">Travel</a> </p>
          </div>


          <div class="pt-5 comment-wrap">
            <h3 class="mb-5 heading">6 Comments</h3>
            <ul class="comment-list">
              <li class="comment">
                <div class="vcard">
                  <img src="images/person_1.jpg" alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3>Jean Doe</h3>
                  <div class="meta">January 9, 2018 at 2:21pm</div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                  <p><a href="#" class="reply rounded">Reply</a></p>
                </div>
              </li>

              <li class="comment">
                <div class="vcard">
                  <img src="images/person_2.jpg" alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3>Jean Doe</h3>
                  <div class="meta">January 9, 2018 at 2:21pm</div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                  <p><a href="#" class="reply rounded">Reply</a></p>
                </div>

                <ul class="children">
                  <li class="comment">
                    <div class="vcard">
                      <img src="images/person_3.jpg" alt="Image placeholder">
                    </div>
                    <div class="comment-body">
                      <h3>Jean Doe</h3>
                      <div class="meta">January 9, 2018 at 2:21pm</div>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                      <p><a href="#" class="reply rounded">Reply</a></p>
                    </div>


                    <ul class="children">
                      <li class="comment">
                        <div class="vcard">
                          <img src="images/person_4.jpg" alt="Image placeholder">
                        </div>
                        <div class="comment-body">
                          <h3>Jean Doe</h3>
                          <div class="meta">January 9, 2018 at 2:21pm</div>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                          <p><a href="#" class="reply rounded">Reply</a></p>
                        </div>

                        <ul class="children">
                          <li class="comment">
                            <div class="vcard">
                              <img src="images/person_5.jpg" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                              <h3>Jean Doe</h3>
                              <div class="meta">January 9, 2018 at 2:21pm</div>
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                              <p><a href="#" class="reply rounded">Reply</a></p>
                            </div>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li class="comment">
                <div class="vcard">
                  <img src="images/person_1.jpg" alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3>Jean Doe</h3>
                  <div class="meta">January 9, 2018 at 2:21pm</div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                  <p><a href="#" class="reply rounded">Reply</a></p>
                </div>
              </li>
            </ul>
            <!-- END comment-list -->

            <div class="comment-form-wrap pt-5">
              <h3 class="mb-5">Leave a comment</h3>
              <form action="#" class="p-5 bg-light">
                <div class="form-group">
                  <label for="name">Name *</label>
                  <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                  <label for="email">Email *</label>
                  <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                  <label for="website">Website</label>
                  <input type="url" class="form-control" id="website">
                </div>

                <div class="form-group">
                  <label for="message">Message</label>
                  <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" value="Post Comment" class="btn btn-primary">
                </div>

              </form>
            </div>
          </div>

        </div>

        <!-- END main-content -->

        <div class="col-md-12 col-lg-4 sidebar">
          <div class="sidebar-box search-form-wrap">
            <form action="category.php" class="sidebar-search-form">
              <span class="bi-search"></span>
              <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter" name='searchKey'>
            </form>
          </div>
          <!-- END sidebar-box -->
          <div class="sidebar-box">
            <div class="bio text-center">
              <img src=<?php echo $user['pic_path']?> alt="Image Placeholder" class="img-fluid mb-3">
              <div class="bio-body">
                <h2><?php echo $user['username'];?></h2>
                <p class="mb-4"><?php echo $user['bio'];?></p>
                <p><a href="publicProfile.php?id=<?php echo $post['author_id'];?> "class="btn btn-primary btn-sm rounded px-2 py-2">View my Profile</a></p>
                <p class="social">
                  <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                </p>
              </div>
            </div>
          </div>
          <!-- END sidebar-box -->  
            <?php include('./inc/r_side_bar.php');?>


        </div>
        <!-- END sidebar -->

      </div>
    </div>
  </section>


<?php include('./inc/footer.php');?>