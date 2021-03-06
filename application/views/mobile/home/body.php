<div class="panel-header panel-header-md">
	<center><img class="" id="user_image" src="<?php echo base_url('uploads/resident/').$_SESSION['image'];?>"></center>
</div>
<div class="content">
	<div class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Hi <span style="color:gray;"><?php echo $_SESSION['first_name']?></span>!</h3></center>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-4 mb-4 pl-1 pr-2">
							<a style="text-decoration:none;"  href="<?php echo base_url('mobile-bills')?>">
								<div class="option-group p-1 mt-1">
									<i class="fas fa-money-bill fa-3x mb-2"></i><span class="badge" id="span_bills"></span>
									<label>Bills</label>
								</div>
							</a>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<a style="text-decoration:none;"  href="<?php echo base_url('mobile-reservation')?>">
								<div class="option-group p-1 mt-1">
									<i class="fas fa-calendar-alt fa-3x mb-2"></i><span class="badge" id="span_reservation"></span>
									<label>Reservation</label>
								</div>
							</a>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<a style="text-decoration:none;"  href="<?php echo base_url('mobile-notification')?>">
								<div class="option-group p-1 mt-1">
									<i class="fas fa-bell fa-3x mb-2"></i><span class="badge" id="span_notif"></span>
									<label>Notification</label>
								</div>
							</a>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<a style="text-decoration:none;"  href="<?php echo base_url('mobile-profile')?>">
								<div class="option-group p-1 mt-1">
									<i class="fas fa-user fa-3x mb-2"></i>
									<label>Profile</label>
								</div>
							</a>
						</div>
						<div class="col-4 mb-4 pl-1 pr-2">
							<a style="text-decoration:none;"  href="<?php echo base_url('logout')?>">
								<div class="option-group p-1 mt-1">
									<i class="fas fa-user-times fa-3x mb-2"></i>
									<label>Logout</label>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>