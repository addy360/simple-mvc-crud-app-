<?php include APPROOT.'/views/inc/header.php'; ?>
		<a href="<?php echo URLROOT ?>/posts" class="btn btn-light"> <i class="fas fa-backward"></i> Back</a>
		<h1 class="lead"><?php echo $data['post']->title ?></h1>
		<div class="bg-primary p-2 mb-3 text-white">
			Written by <?php  echo ($data['user']->name) ?> on <?php echo $data['post']->created_at ?>
		</div>

		<p><?php echo $data['post']->body ?></p>

		<?php if($data['post']->user_id==$_SESSION['user_id']): ?>
			<div class="row">
				<div class="col-md-6">
					
					<a href="<?php echo URLROOT ?>/posts/edit/<?php echo $data['post']->id ?>" class="btn btn-outline-dark btn-block">Edit</a>
				</div>
				<div class="col-md-6">
					<form action="<?php echo URLROOT ?>/posts/delete/<?php echo $data['post']->id ?>" method="post">
						<input type="submit" value="delete" class="btn btn-outline-danger btn-block">
					</form>
				</div>
			</div>
			
		<?php endif; ?>	


<?php include APPROOT.'/views/inc/footer.php'; ?>
