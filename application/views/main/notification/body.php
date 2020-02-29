<div class="panel-header panel-header-lg">
	<canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
	<div class="row">

		<div class="col-lg-8">
			<div class="card">
				<div class="card-header">
					<center><h3>Notifications</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm"> 
						<table class="table table-hover" id="notification_tbl">
							<thead>
								<tr>
									<th>No.</th>
									<th>Title</th>
									<th>Message</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="card">
				<div class="card-header">
					<center>
						<h3>Notification Information</h3>
					</center>

					<form method="post" id="registration_form">
						<div class="form-row">
							<div class="form-group col-md-12 mb-3">
								<label for="title">Title</label>
								<input type="text" class="form-control" id="title" name="title">
							</div>
							<div class="form-group col-md-12 mb-3">
								<label for="content">Message</label>
								<textarea class="form-control" id="content" name="content"></textarea>
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="date">Date</label>
								<input type="date" class="form-control" id="date" name="date">
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
									
								</center>
							</div>
						</div>
					</form>

					<form method="post" id="update_form" class="d-none">
						<div class="form-row">
							<div class="form-group col-md-12 mb-3">
								<label for="_title">Title</label>
								<input type="text" class="form-control" id="_title" name="_title">
							</div>
							<div class="form-group col-md-12 mb-3">
								<label for="_content">Message</label>
								<textarea class="form-control" id="_content" name="_content"></textarea>
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="_date">Date</label>
								<input type="date" class="form-control" id="_date" name="_date">
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Update</button>
								</center>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Notification History</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm"> 
						<table class="table table-hover" id="all_notif_tbl">
							<thead>
								<tr>
									<th>No.</th>
									<th>Title</th>
									<th>Message</th>
									<th>Date</th>
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