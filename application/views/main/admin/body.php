<div class="panel-header panel-header-md">
	<div class="overlay-bg">
		
	</div>
	<center><h1>ADMIN MANAGEMENT</h1></center>
</div>
<div class="content">
	<div class="row">

		<div class="col-lg-8">
			<div class="card">
				<div class="card-header">
					<center><h3>Admin List</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive"> 
						<table class="table table-bordered table-hover" id="admin_tbl">
							<caption>List of registered admin</caption>
							<thead>
								<tr>
									<th>No.</th>
									<th>Username</th>
									<th>Name</th>
									<th>Email</th>
									<th>Contact No.</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="card">
				<div class="card-header">
					<center>
						<h3>Profile</h3>
						<img class="avatar_image mb-2" id="image" src="<?php echo base_url('build/images/avatar.png')?>">
					</center>
					<form method="post" id="registration_form">
						<div class="form-row mb-5">
							<div class="col-md-6 offset-md-3">
								<input type="file" class="form-control "  name="image">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6 mb-3">
								<label for="">First Name</label>
								<input type="text" class="form-control" id="first_name" name="first_name">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Middle Name</label>
								<input type="text" class="form-control" id="middle_name" name="middle_name">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Last Name</label>
								<input type="text" class="form-control" id="last_name" name="last_name">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Email</label>
								<input type="email" class="form-control" id="email" name="email">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Contact No.</label>
								<input type="text" class="form-control" id="contact_number" name="contact_number">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Username</label>
								<input type="text" class="form-control" id="username" name="username">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Password</label>
								<input type="password" class="form-control" id="password" name="password">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Confirm Password</label>
								<input type="password" class="form-control" id="confirm_password" name="confirm_password">
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-info" id="save_btn"><i class="fa fa-save"></i> Save User</button>
									<button type="button" class="btn btn-default" onclick="ADMIN.clear();"><i class="fa fa-eraser"></i> Clear</button>
								</center>
							</div>
						</div>
					</form>

					<form method="post" id="update_form" class="d-none">
						<div class="form-row mb-5">
							<div class="col-md-6 offset-md-3">
								<!-- <input type="file" class="form-control "  name="_image"> -->
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6 mb-3">
								<label for="">First Name</label>
								<input type="text" class="form-control" id="_first_name" name="_first_name">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Middle Name</label>
								<input type="text" class="form-control" id="_middle_name" name="_middle_name">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Last Name</label>
								<input type="text" class="form-control" id="_last_name" name="_last_name">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Email</label>
								<input type="email" class="form-control" id="_email" name="_email">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Contact No.</label>
								<input type="text" class="form-control" id="_contact_number" name="_contact_number">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Username</label>
								<input type="text" class="form-control" id="_username" name="_username" readonly>
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Password</label>
								<input type="password" class="form-control" id="_password" name="_password">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Confirm Password</label>
								<input type="password" class="form-control" id="_confirm_password" name="_confirm_password">
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-success" id="update_btn"><i class="fa fa-edit"></i> Update</button>
									<button type="button" class="btn btn-danger" id="delete_btn" onclick="ADMIN.delete();"><i class="fa fa-trash"></i> Delete</button>
									<button type="button" class="btn btn-default" onclick="ADMIN.clear();"><i class="fa fa-eraser"></i> Clear</button>
								</center>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-lg-5">
			<div class="card">
				<div class="card-header">
					<center><h3>Residence Information</h3></center>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="table-responsive">
								<table class="table table-bordered" id="admin_residence">
									<thead>
										<tr>
											<th>Phase No.</th>
											<th>Lot & Block No.</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="card">
				<div class="card-header">
					<center><h3>Add Residence </h3></center>
				</div>
				<div class="card-body">

					<form method="post" id="residence_form">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="phase_no">Phase No.</label>
								<input type="number" class="form-control"id="phase_no" name="phase_no" min="0" required>
							</div>
							<div class="form-group col-md-6">
								<label for="phase_no">Lot No.</label>
								<input type="number" class="form-control"id="lot_no" name="lot_no" onchange="ADMIN.produce_lot()" min="0" required>
							</div>
							<div class="form-group col-12 ">
								<table id="lot_block_tbl">
									
								</table>
							</div>
							<div class="form-group col-12 ">
								<center><button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button></center>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>