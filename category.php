<?php
include('./inc/db_connection.php');
include('./inc/header.php');
include('./inc/GetPosts.php');
if (empty($_GET['name']) && empty($_GET['searchKey'])){
    $errors['category_id']='category id not set';
    header('location: index.php');
    exit();
}
try{
	if(!empty($_GET['searchKey'])){
		$title='Search: '.$_GET['searchKey'];
		$name=$_GET['searchKey'];
		$posts = get_posts_by_title_keyword($_GET['searchKey']);
		$category_id=5;
	}
	if(!empty($_GET['name'])){
		$category_name=$name=$_GET['name'];
		// $sql = $db->prepare('SELECT * FROM `category` WHERE `name`='.$category_name); // get category id
		// $sql->execute();
		// $category = $sql->fetch();
		// $category_id=$category['id'];
		$posts = get_category_posts_by_name($category_name,'created');
		$title='Category: '.$_GET['name'];
	}
}catch(Exception $e){
    $errors['category_id_n']='category id not exist';
    // header('location: index.php');
    // exit();
}
?>

<div class="section search-result-wrap">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="heading"><?php echo $title;?></div>
				</div>
			</div>
			<div class="row posts-entry">
				<div class="col-lg-8">
                    <?php foreach($posts as $post){?>
					<div class="blog-entry d-flex blog-entry-search-item">
						<a href="single.php?id=<?php echo $post['id'];?>" class="img-link me-4">
							<img src=<?php echo $post['cover_img_path'];?> alt="Image" class="img-fluid">
						</a>
						<div>
							<span class="date"><?php echo $post['updated'];?> &bullet; <a href="#"><?php echo $name;?></a></span>
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
				<div class="col-lg-4 sidebar">
					<div class="sidebar-box search-form-wrap mb-4">
						<form action="category.php"  class="sidebar-search-form">
							<span class="bi-search"></span>
							<input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter" name='searchKey'>
						</form>
					</div>
					  <!-- END sidebar-box -->
					<?php include('./inc/r_side_bar.php');?>
				</div>
			</div>
		</div>
	</div>

<?php include('./inc/footer.php');?>