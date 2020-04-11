<div class="panel-header panel-header-sm">

</div>
<div class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h6>MY RESERVATION</h6></center>
				</div>
				<div class="card-body">

					<div class="table-responsive">
						<table class="table table-bordered" id="my_reservation_table">
							<thead>
								<tr>
									<th>Date</th>
									<th>Description</th>
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
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h6>SCHEDULE RESERVATION</h6></center>
				</div>
				<div class="card-body">
					<form method="post" id="reservation_form">
						<div class="row">

							<div class="col-12">
								<label class="d-block">Amenity</label>
								<select class="form-control" id="amenities" name="amenities" onchange="RESERVATION.load_amenities_information();"></select>
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Quantity</label>
								<input type="number" class="form-control" id="available_qty"  readonly readonly>
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Amount</label>
								<input type="text" class="form-control d-inline" id="amount" readonly readonly>
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Date From</label>
								<input type="text" id="date_from" class="form-control datepicker" name="date_from"></p>
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Date To</label>
								<input type="date_to" id="date_to" class="form-control datepicker" name="date_to"></p>
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Reserve Qty</label>
								<input type="number" min="0" class="form-control" id="quantity" name="quantity">
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Total Amount</label>
								<input type="number" class="form-control" id="total_amount" name="total_amount" readonly>
							</div>

							<div class="col-12 mt-3">
								<center>
									<button type="button" id="ca_btn" class="btn btn-secondary " onclick="RESERVATION.check_availability();"><i class="fa fa-check"></i> Check Availability</button>
									<button type="submit" id="pr_btn" class="btn btn-info d-none"><i class="fas fa-paper-plane"></i> Place Reservation</button>
								</center>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h6>AMENITY RESERVATION SCHEDULE</h6></center>
				</div>
				<div class="card-body">

					<div class="table-responsive">
						<table class="table table-bordered" id="amenity_reservation">
							<thead>
								<tr>
									<th width="35%">Date</th>
									<th width="35%">Name</th>
									<th width="30%">Quantity</th>
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


<div class="modal fade" tabindex="-1" role="dialog" id="schedule_modal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="post" id="image_form">
				<div class="modal-header">
					<h5 class="modal-title">Amenity Schedule</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label id="label_date"></label>
					<h6 id="label_title"></h6>
					<p id="label_description"></p>
				</div>
			</form>
		</div>
	</div>
</div>