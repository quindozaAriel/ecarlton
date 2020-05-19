<style>

</style>
<div class="panel-header panel-header-lg">
	<canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
	<div class="row">
		<div class="col-lg-6 col-md-12">
			<div class="card card-chart">
				<div class="card-header">
					<h5 class="card-category">Carlton Residence Income</h5>
					<h4 class="card-title">Reservation Sales</h4>
				</div>
				<div class="card-body">
					<div class="chart-area">
						<canvas id="barChartSimpleGradientsNumbers"></canvas>
					</div>
				</div>
				<div class="card-footer">
					<div class="stats">
						<i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-9 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Amenities List</h3></center>
				</div>
				<div class="card-body">
					
					<div class="table-responsive ">
						<table class="table table-bordered" id="amenities_tbl">
							<thead>
								<tr>
									<th>No.</th>
									<th>Amenities</th>
									<th>Qty</th>
									<th>Available Qty</th>
									<th>Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>

				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Amenities Information</h3></center>
				</div>
				<div class="card-body">
					<form method="post" id="registration_form">

						<div class="form-row">
							<div class="form-group col-md-12 mb-3">
								<label for="">Amenity</label>
								<input type="text" class="form-control" id="description" name="description">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Quantity</label>
								<input type="number" class="form-control" id="quantity" name="quantity">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Amount</label>
								<input type="text" class="form-control" id="amount" name="amount">
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-info" id="save_btn"><i class="fa fa-save"></i> Save Amenity</button>
									<button type="button" class="btn btn-default" onclick="AMENITY.clear();"><i class="fa fa-eraser"></i> Clear</button>
								</center>
							</div>
						</div>
					</form>

					<form method="post" id="update_form" class="d-none">

						<div class="form-row">
							<div class="form-group col-md-12 mb-3">
								<label for="">Amenity</label>
								<input type="text" class="form-control" id="_description" name="_description">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Quantity</label>
								<input type="number" class="form-control" id="_quantity" name="_quantity">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Available_qty</label>
								<input type="number" class="form-control" id="_available_qty" name="_quantity">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Amount</label>
								<input type="text" class="form-control" id="_amount" name="_amount">
							</div>
							<div class="col-md-12 mb-3">
								<center>
									<button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Update</button>
									<button type="button" class="btn btn-default" onclick="AMENITY.clear();"><i class="fa fa-eraser"></i> Clear</button>
								</center>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Reservation Request</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<center>
							<table class="table table-bordered" id="reservation_request">
								<thead>
									<tr>
										<th>Date Requested</th>
										<th>Reservation Date</th>
										<th>Name</th>
										<th>Amenity</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</center>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>For Payment Reservation</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<center>
							<table class="table table-bordered" id="forpayment_reservation">
								<thead>
									<tr>
										<th>Date Requested</th>
										<th>Reservation Date</th>
										<th>Name</th>
										<th>Amenity</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</center>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Reserved Amenities</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<center>
							<table class="table table-bordered" id="pending_reservation">
								<thead>
									<tr>
										<th>Date Requested</th>
										<th>Reservation Date</th>
										<th>Name</th>
										<th>Amenity</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</center>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Reservation History</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="reservation_history">
							<thead>
								<tr>
									<th>Date Requested</th>
									<th>Reservation Date</th>
									<th>Name</th>
									<th>Amenity</th>
									<th>Quantity</th>
									<th>Amount</th>
									<th>Status</th>
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

