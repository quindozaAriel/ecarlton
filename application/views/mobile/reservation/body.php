<style type="text/css">
	.btn-pay:hover {
		cursor: pointer;
	}
</style>
<div class="panel-header panel-header-sm">

</div>
<div class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center>
						<h6>MY RESERVATION</h6>
					</center>
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
					<center>
						<h6>SCHEDULE RESERVATION</h6>
					</center>
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
								<input type="number" class="form-control" id="available_qty" readonly readonly>
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
								<label class="d-block">Payment Type</label>
								<select class="form-control" id="payment_type" name="payment_type">
									<option value="MANUAL">MANUAL</option>
									<option value="GCASH">GCASH</option>
								</select>
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
					<center>
						<h6>AMENITY RESERVATION SCHEDULE</h6>
					</center>
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
<div class="modal fade" tabindex="-1" role="dialog" id="paymode_modal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">







			<form method="post" id="image_form">
				<div class="modal-header" style="background: linear-gradient(90deg,#1ed9f6,#36bee3,#41adae,#1ed9f6);">
					<h5 class="modal-title">Authorize</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<!-- 					<div><center>COPY</center></div> -->
					<div style="font-size: 72px;">
						<center>
							<span style="font-size: 25px; position: relative;top:-32px;">₱</span>
							<span id="spn_amount"></span>
						</center>
					</div>
					<div style="font-size: 25px; color:gray;top:-10px;">
						<center>Amount to Pay</center>
					</div>
					<br><br>

					<span style="margin-left: 4em;">SELECT PAYMENT METHOD</span>


					<div class="row rounded btn-pay" style="border: 1px solid #d2caca; margin-left: 5em; margin-right: 5em;" id="pay_gcash">
						<div style="padding: 3px;"><img src="<?php echo base_url('uploads/icons/gcash.jpeg') ?>" height=70 width=70>
							<span style="margin-left: 5px;">GCash</span>
						</div>
					</div>

					<div class="row rounded btn-pay" style="border: 1px solid #d2caca; margin-left: 5em; margin-right: 5em; margin-top: 1em;" id="pay_card">
						<div style="padding: 3px;"><img src="<?php echo base_url('uploads/icons/card3.jpg') ?>" height=70 width=70>
							<span style="margin-left: 5px;">Credit/Debit Card</span>
						</div>
					</div>






					<!-- 					<label id="label_date"></label>
					<h6 id="label_title"></h6>
					<p id="label_description"></p> -->
				</div>
			</form>



		</div>
	</div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="card_payment_modal">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<form method="post" id="image_form">
				<div class="modal-header">
					<h5 class="modal-title">Card Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="container">
						<div class="row">
							<div class="col-8">
								<div class="row" style="background: linear-gradient(25deg,#f37b26,#fdb731);border-radius: 1em;">
									<div class="card-body">
										<div>
											<img src="<?php echo base_url('uploads/icons/sim.png') ?>" height="35" width="50">
											<img style="margin-left: 10em;" src="<?php echo base_url('uploads/icons/mastercard.png') ?>" height="45" width="50">
										</div>
										<!-- 						<h5 class="card-title">Special title treatment</h5> -->


										<center>
											<div id="cont_number" style="color:white;font-size: 1.5em;font-weight: 500; margin-left: .5em;margin-right: 1em;margin-top: 1em;">•••• •••• •••• ••••</div>
										</center>


										<div style="margin-left: 14em;color:white">
											<span style="font-size: .7em;">valid thru</span><br>
											<span style="font-size: 1em;"><i><span id="spn_month"></span>/<span id="spn_year"></span></i></span>
										</div>


									</div>
								</div>
							</div>

							<div class="col-4">

								<label>Card Number:</label>
								<input type="text" class="form-control" name="" id="txt_card_number">
								<label>Month:</label>
								<select id="slc_month" class="form-control"></select>
								<label>Year:</label>
								<select id="slc_year" class="form-control"></select>

								<button type="button" class="btn btn-primary form-control" id="btn_via_card">Confirm</button>

							</div>

							<ul id="spn_card_errors"></ul>

						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="reason_modal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title">Rejection Reason</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea class="form-control" id="reason_textarea"></textarea>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="cancel_modal">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title">Cancellation Reason</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea class="w-100" id="cancellation_reason"></textarea>
				<input type="hidden" id="hidden_cancel_id">
			</div>
			<div class="modal-footer">
				<button class="btn btn-info" onclick="RESERVATION.cancel_request()">Submit Cancellation</button>
			</div>
		</div>
	</div>
</div>