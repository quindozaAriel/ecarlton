<div class="panel-header panel-header-sm">
	<!-- <canvas id="bigDashboardChart"></canvas> -->
</div>
<div class="content">
	<div class="row">

		<div class="col-md-9">
			<div class="card">
				<div class="card-header">
					<center>
						<h3>Resident Billing</h3>
					</center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="bills_table">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Resident</th>
									<th>Bill Description</th>
									<th>Amount</th>
									<th>Type</th>
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
		<div class="col-md-3">
			<div class="card">
				<div class="card-header text-center">
					<h3>Add Resident Bill</h3>
				</div>
				<div class="card-body">
					<form method="post" id="add_bill_form">
						<input type="hidden" id="hidden_id">
						<div class="form-row">
							<div class="form-group col-md-12 mb-3">
								<label for="">Resident Name</label>
								<select class="form-control" id="resident_id" name="resident_id"></select>
							</div>
							<div class="form-group col-md-12 mb-3">
								<label for="">Bill Description</label>
								<textarea class="form-control" id="description" name="description"></textarea>
							</div>
							<div class="form-group col-md-12 mb-3">
								<label for="">Amount</label>
								<input type="number" class="form-control" id="amount" name="amount">
							</div>
							<div class="form-group col-md-12 mb-3">
								<label for="">Bill Type</label>
								<select class="form-control" id="type" name="type" onchange="RESBILL.display_duesec(this.value)">
									<option></option>
									<option value="MONTHLY">Monthly</option>
									<option value="OCCASIONAL">Occasional</option>
								</select>
							</div>
							<div class="form-group col-md-12 mb-3">
								<label for="">Due Date</label>
								<input type="date" class="form-control d-none" id="due_date" name="due_date" disabled>
								<input type="number" class="form-control d-none" id="due_day" min="1" name="due_date" disabled>
							</div>
						</div>

						<center>
							<button type="submit" class="btn btn-info" id="save_btn"><i class="fa fa-save"></i>&nbsp; Save</button>
							<button type="button" class="btn btn-success d-none" id="edit_btn" onclick="RESBILL.update()"><i class="fa fa-edit"></i>&nbsp; Update</button>
							<button type="button" class="btn btn-danger" onclick="RESBILL.reset_form()"><i class="fa fa-times"></i>&nbsp; Clear</button>
						</center>
					</form>

				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class=" col-12">
			<div class="card">
				<div class="card-header">
					<center>
						<h3>Resident Bills </h3>
					</center>
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
							<input list="residents" class="form-control" style="font-size:15px;" name="resident_id" id="resident_id" onchange="RESBILL.getResidentInfo()" required>
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
							<button type="button" onclick="RESBILL.add_bills($('#bill_id').val());" class="btn btn-info mt-4" style="font-size:14px;"> Add Bill</button>
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
							<button type="button" class="btn btn-default" onclick="RESBILL.reset_manual_payment();"><i class="fa fa-eraser"></i>&emsp;Clear</button>
							<button type="button" onclick="RESBILL.manual_pay();" class="btn btn-info"><i class="fa fa-save"></i>&emsp;Save Payment</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>