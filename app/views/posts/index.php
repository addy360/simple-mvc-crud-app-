<?php include APPROOT.'/views/inc/header.php' ?>
<?php flash('post_message');?>
	<div class="row">
		<div class="col-md-6">
			<h1>Posts</h1>
		</div>
		<div class="col-md-6">
			<a href="<?php echo URLROOT ?>/posts/add" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Add Post</a>
		</div>
	</div>
	<?php foreach ($data['posts'] as $post) :?>
		<div class="card my-4">
			<div class="card-header">
				<h1 class="card-title">
					<?php echo $post->title ?>
				</h1>
				<div class="bg-primary text-white  p-2">
					Written by <?php echo $post->name ?> on <?php echo $post->postDate ?>
				</div>
			</div>
			<div class="card-body">
				<p class="card-text">
					
					<?php echo $post->body; ?>
				</p>
			</div>
			<div class="card-footer">
				<a class="btn btn-outline-dark btn-block" href="<?php echo URLROOT ?>/posts/show/<?php echo $post->postId ?>">Read more</a>
			</div>
		</div>
	<?php endforeach; ?>	


<?php include APPROOT.'/views/inc/footer.php' ?>