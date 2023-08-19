<?php
include('./inc/db_connection.php');
session_start();
$errors = array();
if(empty($_SESSION['id'])){
    $errors['not_auth'] = 'You are not authorized to write posts. Please login first.';
    $_SESSION['errors'] = $errors;
    header('Location: login.php');
    exit();
} else {
    $sql=$db->prepare('SELECT * FROM `category`');
    $sql->execute();
    $categories=$sql->fetchAll(PDO::FETCH_ASSOC);

    //get image list
    $image_paths = array(); // Array to store image paths
    if (!empty($_FILES['images']['name'][0])) {
        $_SESSION['uploaded_images'] = $_FILES;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title']) && !empty($_POST['content'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        // $content = preg_replace('/img:(\S+)/', '<img src="assets/uploads/images/$1" alt="Image placeholder" class="img-fluid rounded" style="width: 100%;height: auto;max-width: 100vw;">', $content);

        // echo $content; die();
        
        // Validate input fields
        if (empty($title)) {
            $errors['title'] = 'Title is required.';
        }
        
        if (empty($content)) {
            $errors['content'] = 'Content is required.';
        }
        if (isset($_POST['categories']) && is_array($_POST['categories'])) {
            $categories = $_POST['categories'];
        }
        if (empty($_POST['categories'])) {
            $errors['categories'] = 'at least choose one category.';
        }
        $cover_img_path='assets/user/images/img_6_horizontal.jpg';
        if (!empty($_POST['cover_image'])) {
            $cover_img_path= $_POST['cover_image'];
        }
        if (!empty($_POST['image_paths']) && is_array($_POST['image_paths'])) {
            $image_paths= $_POST['image_paths'];
        }

        // Check if there are uploaded image paths in the session
        if (isset($_SESSION['uploaded_images'])) {
            $uploaded_images = $_SESSION['uploaded_images'];
            foreach ($uploaded_images['images']['name'] as $index => $filename) {
                $temp_file = $uploaded_images['images']['tmp_name'][$index];
                $img_path = 'assets/uploads/images/' . uniqid() . '_' . $filename; // Generate a unique name for the image
                move_uploaded_file($temp_file, $img_path); // Move the image to a directory
                array_push($image_paths, $img_path);
            }            
            // Clear the session variable to avoid using outdated data
            unset($_SESSION['uploaded_images']);
        }

            if (empty($errors)) {
            $sql = $db->prepare('INSERT INTO posts (title, cover_img_path, content, published, author_id, rate) VALUES (:title, :cover_img_path, :content, 1, :author_id, 2.5)');
            $author_id = $_SESSION['id'];
            $sql->bindParam(':title', $title, PDO::PARAM_STR);
            $sql->bindParam(':cover_img_path', $cover_img_path, PDO::PARAM_STR);
            $sql->bindParam(':content', $content, PDO::PARAM_STR);
            $sql->bindParam(':author_id', $author_id, PDO::PARAM_INT);
            
            if ($sql->execute()) {
                $post_id = $db->lastInsertId(); // Get the ID of the newly inserted post
                // echo $post_id;
                // Handle image uploads
                if (!empty($image_paths)) {
                    foreach ($image_paths as $img_path) {
                        // Insert image path into inc_images_path table
                        $img_sql = $db->prepare('INSERT INTO `inc_images_path`(`post_id`, `img_path`)  VALUES (:post_id, :img_path)');
                        $img_sql->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                        $img_sql->bindParam(':img_path', $img_path, PDO::PARAM_STR);
                        $img_sql->execute();
                        
                    }                    
                }
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        // Insert category relationship into post_category table
                        $cat_sql = $db->prepare('INSERT INTO post_category (post_id, category_id) VALUES (:post_id, :category_id)');
                        $cat_sql->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                        $cat_sql->bindParam(':category_id', $category, PDO::PARAM_INT);
                        $cat_sql->execute();
                    }
                }
                
                
                // header('Location: success.php');
                // exit();
            } 
            else {
                $errors['db_error'] = 'An error occurred while adding the post.';
            }
            header('location: profile.php');
            exit();
        }
    }
}
include('./inc/header.php');
?>
	<div class="hero overlay inner-page bg-primary py-5">
		<div class="container">
			<div class="row align-items-center justify-content-center text-center pt-5">
				<div class="col-lg-6">
					<h1 class="heading text-white mb-3" data-aos="fade-up">Create Post</h1>
				</div>
			</div>
		</div>
	</div>
	
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
					<div class="contact-info">
							<h3 class="mb-1">hints:</h3>
							<p>to include images in your post: <br></p>
                            <ol>
                                <li>upload your images</li>
                                <li>from the list of imgs, copy image name</li>
                                <li>place the name in content of post like:
                                    <p><code>img:image1.png</code></p>
                                </li>
                            </ol>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="images">Upload included Images:</label>
                                    <input type="file" name="images[]" multiple id="images" class="form-control">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Upload Images</button>
                            </div>
                        </form>
                </div>

				</div>
				<div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <form method="post" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="text" name="title" class="form-control" placeholder="post title">
                                    <?php if (isset($errors['title'])) { echo '<span class="error">'.$errors['title'].'</span>'; } ?>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="categories">Select post categories:</label>
                                    <div class="dropdown" name="categories">
                                        <?php foreach($categories as $category){?>
                                            <input type="checkbox" value=<?php echo $category['id'];?> name="categories[]">
                                            <label><?php echo $category['name'];?> </label>
                                        <?php }
                                        if (isset($errors['title'])) { echo '<span class="error">'.$errors['categories'].'</span>'; } ?>

                                        <!-- <input type="radio" name="categories[]" id="">
                                        <select type="radio" class="btn btn-primary dropdown-toggle" name='categories[]'>
                                            <option value="0" <?php  ?>>not started</option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="cover_image">Upload included Images:</label>
                                    <input type="file" name="cover_image" multiple id="cover_image" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                <?php
                                    if (!empty($_FILES['images']['name'][0])) {
                                        // var_dump($_FILES);
                                        echo '<p>Uploaded Images:</p>';
                                        echo '<ul>';
                                        foreach ($_FILES['images']['name'] as $index => $filename) {
                                            echo '<li><input type="text" disabled name="image_names[]" value="' . $filename . '"></li>'; // Display the image file name
                                        }
                                        // foreach ($image_paths as $img_path) {
                                        //     // list($path,$img_name)=implode('_',$img_path);
                                        //     // $parts = pathinfo($img_path);
                                        //     // $filename_without_identifier = substr($parts['filename'], strpos($parts['filename'], '_') + 1);
                                        //     echo '<li><input type="text" name="image_paths[]" value="' . basename($img_path) . '"></li>'; // Display the image file name
                                        // }
                                        echo '</ul>';
                                    }
                                ?>    
                                </div>
                                <div class="col-12 mb-3">
                                    <textarea name="content" id="" cols="30" rows="7" class="form-control" placeholder="Contnet"></textarea>
                                    <?php if (isset($errors['content'])) { echo '<span class="error">'.$errors['content'].'</span>'; } ?>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Create Post</button>
                                </div>
                            </div>
                    </form>
				</div>
			</div>
		</div>
	</div> <!-- /.untree_co-section -->

    <?php
    if (isset($errors['db_error'])) {
        echo '<span class="error">'.$errors['db_error'].'</span>';
    }
    include('./inc/footer.php');
?>