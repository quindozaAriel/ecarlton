<div class="panel-header panel-header-md">
	<div class="overlay-bg">
		
	</div>
	<center><h1>RESIDENT MANAGEMENT</h1></center>
</div>
<div class="content">
	<div class="row">

		<div class="col-lg-8">
			<div class="card">
				<div class="card-header">
					<center><h3>Residents</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm"> 
						<table class="table table-hover" id="resident_tbl">
							<caption>List of registered resident</caption>
							<thead>
								<tr>
									<th>No.</th>
									<th>Name</th>
									<th>Contact</th>
									<th>Email</th>
									<th>Username</th>
									<th>Residence</th>
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
								<input type="file" class="form-control" name="image">
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
							<div class="form-group col-md-4 mb-3">
								<label for="">Phase No.</label>
								<select class="form-control" id="phase_no" name="phase_no" onclick="RESIDENT.load_lot()"></select>
							</div>
							<div class="form-group col-md-4 mb-3">
								<label for="">Lot No.</label>
								<select class="form-control" id="lot_no" name="lot_no" onclick="RESIDENT.load_block()" disabled></select>
							</div>
							<div class="form-group col-md-4 mb-3">
								<label for="">Block No.</label>
								<select class="form-control" id="block_no" name="block_no" disabled></select>
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
									<button type="button" class="btn btn-default" onclick="RESIDENT.clear()"><i class="fa fa-eraser"></i> Clear</button>
								</center>
							</div>
						</div>
					</form>

					<form method="post" id="update_form" class="d-none">
						<div class="form-row mb-5">
							<div class="col-md-6 offset-md-3">
								<!-- <input type="file" class="form-control" name="_image"> -->
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
								<input type="text" class="form-control" id="_username" name="_username">
							</div>
							<div class="form-group col-md-4 mb-3">
								<label for="">Phase No.</label>
								<select class="form-control" id="_phase_no" name="_phase_no" onclick="RESIDENT._load_lot()"></select>
							</div>
							<div class="form-group col-md-4 mb-3">
								<label for="">Lot No.</label>
								<select class="form-control" id="_lot_no" name="_lot_no" onclick="RESIDENT._load_block()" disabled></select>
							</div>
							<div class="form-group col-md-4 mb-3">
								<label for="">Block No.</label>
								<select class="form-control" id="_block_no" name="_block_no" disabled></select>
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Update</button>
									<button type="button" class="btn btn-danger" onclick="RESIDENT.delete()"><i class="fa fa-trash"></i> Delete</button>
									<button type="button" class="btn btn-default" onclick="RESIDENT.clear()"><i class="fa fa-eraser"></i> Clear</button>
								</center>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>

	</div>
</div>