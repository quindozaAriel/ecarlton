<div class="panel-header panel-header-lg">
	<canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
	<div class="row">
		<div class="col-lg-4">
			<div class="card card-chart">
				<div class="card-header">
					<h5 class="card-category">Reservation</h5>
					<h4 class="card-title">Past Reservation</h4>
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
					<h5 class="card-category">Reservation</h5>
					<h4 class="card-title">Incoming Reservation</h4>
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

		<div class="col-lg-5 col-md-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Amenities List</h3></center>
				</div>
				<div class="card-body">
					<button type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Amenities</button>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Amenities</th>
								<th>Qty</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Function Hall</td>
								<td>2</td>
								<td>5000</td>
								<td>
									<button type="button" class="btn btn-success" title="Edit Amenities"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger" title="Delete Amenities"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Table</td>
								<td>22</td>
								<td>32</td>
								<td>
									<button type="button" class="btn btn-success" title="Edit Amenities"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger" title="Delete Amenities"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Chair</td>
								<td>80</td>
								<td>20</td>
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
					<center><h3>Reservations</h3></center>
				</div>
				<div class="card-body">
				</div>
			</div>
		</div>

	</div>
</div>