<div class="panel-header panel-header-lg">
	<canvas id="bigDashboardChart"></canvas>
</div>
<div class="content">
	<div class="row">
<!-- 		<div class="col-lg-4">
			<div class="card card-chart">
				<div class="card-header">
					<h5 class="card-category">Monthly Dues</h5>
					<h4 class="card-title">Resident with due bills</h4>
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
		</div> -->
<!-- 		<div class="col-lg-4 col-md-6">
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
		</div> -->
		<!-- <div class="col-lg-4 col-md-6">
			<div class="card card-chart">
				<div class="card-header">
					<h5 class="card-category">Carlton Residence Income</h5>
					<h4 class="card-title">Monthly Dues Amount</h4>
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
		</div> -->
	</div>

	<div class="row">

		<div class="col-9">
			<div class="card">
				<div class="card-header">
					<center><h3>Monthly Dues</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="bills_table">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Type</th>
									<th>Description</th>
									<th>Amount</th>
									<th>Due Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="card">
				<div class="card-header text-center">
					<h3>Informatioon</h3>
				</div>
				<div class="card-body">
					<form method="post" id="registration_form">
						<div class="form-row">
							<div class="form-group col-md-12 mb-3">
								<label for="">Description</label>
								<textarea class="form-control" id="description" name="description"></textarea>
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Amount</label>
								<input type="text" class="form-control" id="amount" name="amount">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Type</label>
								<select class="form-control" onchange="MONTHLY.change_type($(this).val())" id="type" name="bill_type">
									<option value=""></option>
									<option value="MONTHLY">Monthly</option>
									<option value="OCCASIONAL">Occasional</option>
								</select>
							</div>
							<div class="form-group col-md-12 mb-3 ">
								<label for="">Due Date</label>
								<input type="number" class="form-control d-none" id="due_day" name="dueday" min="1" max="31" disabled>
								<input type="text" id="due_date" class="form-control datepicker d-none" name="duedate" disabled></p>
							</div>
						</div>

						<center>
							<button type="submit" class="btn btn-info" ><i class="fa fa-save"></i>&nbsp; Save</button>
							<button type="button" class="btn btn-danger" onclick="MONTHLY.registration_clear()"><i class="fa fa-times"></i>&nbsp; Clear</button>
						</center>
					</form>

					<form method="post" id="update_form" class="d-none">
						<div class="form-row">
							<div class="form-group col-md-12 mb-3">
								<label for="">Description</label>
								<textarea class="form-control" id="_description" name="_description"></textarea>
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Amount</label>
								<input type="text" class="form-control" id="_amount" name="_amount">
							</div>
							<div class="form-group col-md-6 mb-3">
								<label for="">Type</label>
								<select class="form-control" onchange="MONTHLY._change_type($(this).val())" id="_type" name="_bill_type">
									<option value=""></option>
									<option value="MONTHLY">Monthly</option>
									<option value="OCCASIONAL">Occasional</option>
								</select>
							</div>
							<div class="form-group col-md-12 mb-3 ">
								<label for="">Due Date</label>
								<input type="number" class="form-control d-none" id="_due_day" name="_dueday" min="1" max="31" disabled>
								<input type="text" id="_due_date" class="form-control datepicker d-none" name="_duedate" disabled></p>
							</div>
						</div>

						<center>
							<button type="submit" class="btn btn-success" ><i class="fa fa-edit"></i>&nbsp; Update</button>
							<button type="button" class="btn btn-danger" onclick="MONTHLY.update_clear();"><i class="fa fa-times"></i>&nbsp; Clear</button>
						</center>
					</form>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Due Bills</h3></center>
				</div>
				<div class="card-body">
					<table class="table table-bordered" id="duebills_tbl">
						<thead>
							<tr>
								<th>Date</th>
								<th>Name</th>
								<th>Payment for</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class=" col-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Monthly Bills Payment History</h3></center>
				</div>
				<div class="card-body">
					<form method="post" id="search_history_form">
						<div class="form-row">
							<div class="form-group col-md-2">
								<label for="date_from">Date From</label>
								<input type="date" class="form-control" id="date_from" name="date_from">
							</div>
							<div class="form-group col-md-2">
								<label for="date_to">Date To</label>
								<input type="date" class="form-control" id="date_to" name="date_to">
							</div>
							<div class="form-group col-md-auto pt-3">
								<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Search</button>
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manual_payment_modal"><i class="fa fa-cash-register"></i> Create Manual Payment</button>
							</div>
						</div>
					</form>
					<table class="table table-bordered" id="payment_tbl">
						<thead>
							<tr>
								<th>Payment Date</th>
								<th>Name</th>
								<th>Bill Description</th>
								<th>Amount Paid</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="manual_payment_modal">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title text-white">Manual Payment Information</h5>
			</div>
			<div class="modal-body">
				<form method="post" id="manual_payment_form">
					<div class="form-row">
						<div class="form-group col-md-3 offset-md-9 mb-3">
							<h6 for="date_from">Payment Date</h6>
							<input type="date" class="form-control" id="payment_date">
						</div>
						<div class="form-group col-md-3">
							<h6 for="date_from">Resident</h6>
							<input list="residents" class="form-control" style="font-size:15px;" name="resident_id" id="resident_id" onchange="MONTHLY.getResidentInfo()" required>
							<datalist id="residents">
							
							</datalist>
						</div>
						<div class="form-group col-md-3">
							<h6 for="date_from">First Name</h6>
							<input type="text" readonly class="form-control" style="font-size:15px;" id="first_name"> 
						</div>
						<div class="form-group col-md-3">
							<h6 for="date_from">Middle Name</h6>
							<input type="text" readonly class="form-control" style="font-size:15px;" id="middle_name"> 
						</div>
						<div class="form-group col-md-3">
							<h6 for="date_from">Last Name</h6>
							<input type="text" readonly class="form-control" style="font-size:15px;" id="last_name"> 
						</div>
					</div>
					<div class="form-row mt-3">
						<div class="form-group col-md-6">
							<h6 for="date_from">Select Bill</h6>
							<select class="form-control" style="font-size:15px;"  name="bill_id" id="bill_id" >

							</select>
						</div>
						<div class="form-group col-md-2">
							<button type="button" onclick="MONTHLY.add_bills($('#bill_id').val());" class="btn btn-info mt-4" style="font-size:14px;"> Add Bill</button>
						</div>
						<div class="form-group col-md-6 offset-md-3">
							<div class="table-responsive">
								<table class="table table-bordered" id="bills_details">
									<thead>
										<tr>
											<th>No.</th>
											<th>Bill</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3"><h6>Total Amount: <span id="span_total"></span></h6></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group offset-md-4 col-md-5">
							<button type="button" class="btn btn-default" onclick="$('#manual_payment_form')[0].reset();$('#bills_details tbody').html('');$('#span_total').html('₱ 0')"><i class="fa fa-eraser"></i>&emsp;Clear</button>
							<button type="button" onclick="MONTHLY.manual_pay();" class="btn btn-info"><i class="fa fa-save"></i>&emsp;Save Payment</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>