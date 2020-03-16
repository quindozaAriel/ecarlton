<div class="panel-header panel-header-md">
	<center><img class="" id="user_image" src="<?php echo base_url('uploads/resident/').$_SESSION['image'];?>"></center>
</div>
<div class="content">
	<div lo,class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Hi <span style="color:gray;"><?php echo $_SESSION['first_name']?></span>!</h3></center>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-4 mb-4 pl-1 pr-2">
							<a style="text-decoration:none;" href="<?php echo base_url('mobile-home')?>">
							<div class="option-group p-1 mt-1">
								<i class="fas fa-money-bill fa-3x mb-2"></i>
								<label>Bills<span class="badge text-danger"></span></label>
							</div>
							</a>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<div class="option-group p-1 mt-1">
								<i class="fas fa-calendar-alt fa-3x mb-2"></i>
								<label>Reservation<span class="badge text-danger"></span></label>
							</div>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<div class="option-group p-1 mt-1">
								<i class="fas fa-bell fa-3x mb-2"></i>
								<label>Notification<span class="badge text-danger"></span></label>
							</div>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<div class="option-group p-1 mt-1">
								<i class="fas fa-envelope fa-3x mb-2"></i>
								<label>Messages<span class="badge text-danger"></span></label>
							</div>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<div class="option-group p-1 mt-1">
								<i class="fas fa-user fa-3x mb-2"></i>
								<label>Profile</label>
							</div>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<div class="option-group p-1 mt-1">
								<i class="fas fa-user-times fa-3x mb-2"></i>
								<label>Logout</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>