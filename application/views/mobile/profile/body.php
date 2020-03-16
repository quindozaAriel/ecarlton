<div class="panel-header panel-header-md">
	<center>
		<img class="" id="user_image" src="<?php echo base_url('uploads/resident/').$_SESSION['image'];?>"> 
	</center>
</div>
<div class="content">
	<div lo,class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-header text-center">
					<h6>Account Information</h6>
					<input type="hidden" id="user_id" value="<?php echo $_SESSION['id']?>">
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 mb-3">
							<label>First Name</label>
							<p class="text-center"><?php echo $_SESSION['first_name']?></p>
							<hr class="mt-1">
						</div>
						<div class="col-12 mb-3">
							<label>Middle Name</label>
							<p class="text-center"><?php echo $_SESSION['middle_name']?></p>
							<hr class="mt-1">
						</div>
						<div class="col-12 mb-3">
							<label>Last Name</label>
							<p class="text-center"><?php echo $_SESSION['last_name']?></p>
							<hr class="mt-1">
						</div>
						<div class="col-12 mb-3">
							<label>Address</label>
							<p class="text-center">
								<?php echo 'Phase No. '. $_SESSION['phase_no'] .' Lot No.'. $_SESSION['lot_no'] .' Block No.'. $_SESSION['block_no'];?>
							</p>
							<hr class="mt-1">
						</div>
						<div class="col-12 mb-3">
							<label>Username</label>
							<p class="text-center"><?php echo $_SESSION['username']?></p>
							<hr class="mt-1">
						</div>
						<div class="col-12 mb-3 text-center">
							<button class="btn btn-info" data-target="#image_modal" data-toggle="modal"> Change Image</button> <button class="btn btn-info" data-target="#password_modal" data-toggle="modal"> Change Password</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="image_modal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="post" id="image_form">
				<div class="modal-header">
					<h5 class="modal-title">Change Image</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label>Choose Image</label>
					<center>
						<input type="file" class="form-control w-75" name="image" id="image">
					</center>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save changes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="password_modal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="post" id="password_form">
				<div class="modal-header">
					<h5 class="modal-title">Change Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-row">
						<div class="col-5 mb-3">
							<label>Current Password :</label>
						</div>
						<div class="col-7">
							<input type="password" id="current_password" name="current_password">
						</div>
						<div class="col-5 mb-3">
							<label>New Password :</label>
						</div>
						<div class="col-7">
							<input type="password" id="new_password" name="new_password">
						</div>					
						<div class="col-5 mb-3">
							<label>Confirm Password :</label>
						</div>
						<div class="col-7">
							<input type="password" id="confirm_password" name="confirm_password">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save changes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>