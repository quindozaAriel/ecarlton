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
					<div class="row">
						<div class="col-12">
							<center><label>NOTHING RESERVED</label></center>
						</div>
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
							<div class="col-4 mt-3">
								<label class="d-block">Available Qty</label>
								<input type="number" class="form-control" id="available_qty" name="available_qty" readonly disabled>
							</div>
							<div class="col-4 mt-3">
								<label class="d-block">Amount</label>
								<input type="text" class="form-control" id="amount" name="amount" readonly disabled>
							</div>
							<div class="col-4 mt-3">
								<label class="d-block">Quantity</label>
								<input type="text" class="form-control" id="quantity" name="quantity">
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Date From</label>
								<input type="text" id="date_from" class="form-control datepicker" name="date_from"></p>
							</div>
							<div class="col-6 mt-3">
								<label class="d-block">Date To</label>
								<input type="date_to" id="" class="form-control datepicker" name="date_to"></p>
							</div>
							<div class="col-12">
								<center><button class="btn btn-info">Place Reservation</button></center>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>