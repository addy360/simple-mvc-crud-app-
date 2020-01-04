<?php include APPROOT.'/views/inc/header.php'; ?>
	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body bg-light mt-5 ">
				<?php flash('register_success') ?>
				<h2>Create An Account</h2>
				<p>Please fill out this form to register eith us</p>
				<form method="POST" action="<?php echo URLROOT; ?>/users/login">
					
					<div class="form-group">
						<label for="email">Email  <sup>*</sup></label>
						<input type="email" id="email" name="email" class="form-control form-control-lg <?php echo !empty($data['email_err'])? 'is-invalid': ''; ?> " value="<?php echo $data['email']; ?>">
						<span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
					</div>
					<div class="form-group">
						<label for="password">Password  <sup>*</sup></label>
						<input type="password" id="password" name="password" class="form-control form-control-lg <?php echo !empty($data['password_err'])? 'is-invalid': ''; ?> " value="<?php echo $data['password']; ?>">
						<span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
					</div>
					
					<div class="row">
						<div class="col">
							<button type="submit" class="btn btn-success btn-block" >Login</button>

						</div>
						<div class="col">
							<a href="<?php echo URLROOT ?>/users/register" class="btn btn-light btn-block" >No account? register</a>
						</div>
					</div>

				</form>
				
			</div>
		</div>
	</div>
<?php include APPROOT.'/views/inc/footer.php' ?>