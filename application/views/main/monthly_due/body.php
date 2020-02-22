<div class="panel-header panel-header-lg">
	<canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
	<div class="row">
		<div class="col-lg-4">
			<div class="card card-chart">
				<div class="card-header">
					<h5 class="card-category">Monthly Dues</h5>
					<h4 class="card-title">Late Payment</h4>
					<div class="dropdown">
						<button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
							<i class="now-ui-icons loader_gear"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
							<a class="dropdown-item text-danger" href="#">Remove Data</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="chart-area">
						<canvas id="lineChartExample"></canvas>
					</div>
				</div>
				<div class="card-footer">
					<div class="stats">
						<i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="card card-chart">
				<div class="card-header">
					<h5 class="card-category">Monthly Dues</h5>
					<h4 class="card-title">Paid Resident</h4>
					<div class="dropdown">
						<button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
							<i class="now-ui-icons loader_gear"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
							<a class="dropdown-item text-danger" href="#">Remove Data</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="chart-area">
						<canvas id="lineChartExampleWithNumbersAndGrid"></canvas>
					</div>
				</div>
				<div class="card-footer">
					<div class="stats">
						<i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="card card-chart">
				<div class="card-header">
					<h5 class="card-category">Carlton Residence Income</h5>
					<h4 class="card-title">Monthly Dues</h4>
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

		<div class="col-lg-5 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Monthly Dues</h3></center>
				</div>
				<div class="card-body">
					<button type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Bills</button>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Description</th>
								<th>Amount</th>
								<th>Due Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Garbage Collector</td>
								<td>50</td>
								<td>Every 20th</td>
								<td>
									<button type="button" class="btn btn-success" title="Edit Amenities"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger" title="Delete Amenities"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Security Guard</td>
								<td>100</td>
								<td>Every 15th</td>
								<td>
									<button type="button" class="btn btn-success" title="Edit Amenities"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger" title="Delete Amenities"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Light</td>
								<td>80</td>
								<td>Every 30th</td>
								<td>
									<button type="button" class="btn btn-success" title="Edit Amenities"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger" title="Delete Amenities"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-7 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Resident With Balance</h3></center>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Date</th>
								<th>Name</th>
								<th>Montlhy Bills</th>
								<th>Amount</th>
								<th>Due Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Security<br>
									Light <br>
								</td>
								<td>5000</td>
								<td>02-25-2020</td>
								<td>
									<center>
										<button type="button" class="btn btn-info" title="Approve Request"><i class="fa fa-envelope"></i> Send Notification</button>
									</center>
								</td>
							</tr>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Garbage Collector<br>
									Light <br>
								</td>
								<td>5000</td>
								<td>02-25-2020</td>
								<td>
									<center>
										<button type="button" class="btn btn-info" title="Approve Request"><i class="fa fa-envelope"></i> Send Notification</button>
									</center>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">

		<div class="col-lg-6 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Payments for Current Month Bills</h3></center>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Payment Date</th>
								<th>Name</th>
								<th>Monthly Dues</th>
								<th>Amount Paid</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Garbage Collector<br>
									Light <br>
								</td>
								<td>5000</td>
							</tr>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Security <br>
								</td>
								<td>5000</td>
							</tr>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Garbage Collector<br>
									Light <br>
								</td>
								<td>5000</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Monthly Bills Payment History</h3></center>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Payment Date</th>
								<th>Name</th>
								<th>Monthly Dues</th>
								<th>Amount Paid</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Garbage Collector<br>
									Light <br>
								</td>
								<td>5000</td>
							</tr>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Security <br>
								</td>
								<td>5000</td>
							</tr>
							<tr>
								<td>02-20-2020</td>
								<td>Juan Dela Cruz</td>
								<td>
									Garbage Collector<br>
									Light <br>
								</td>
								<td>5000</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>



	</div>
</div>

