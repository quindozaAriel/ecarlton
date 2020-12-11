<style type="text/css">
	.btn-pay:hover
	{
		cursor: pointer;
	}
</style>
<div class="panel-header panel-header-sm">

</div>
<div class="content">
	<div class="row">

		<div class="col-12">
			<div class="card">
				<form method="post" id="payment_form">
					<div class="card-header">
						<center><h3>Bills</h3></center>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<h6>Your Current Bills</h6>
							</div>
							<div class="col-5">
								<div id="description_container" class="">

								</div>
							</div>
							<div class="col-3">
								<div id="amount_container" class="text-center">

								</div>
							</div>
							<div class="col-4">
								<div id="duedate_container" class="text-center">

								</div>
							</div>
							<div class="col-12 mt-3">
								<h6>Specific Bills</h6>
							</div>
							<div class="col-5">
								<div id="specific_description_container" class="">

								</div>
							</div>
							<div class="col-3">
								<div id="specific_amount_container" class="text-center">

								</div>
							</div>
							<div class="col-4">
								<div id="specific_duedate_container" class="text-center">

								</div>
							</div>
							<div class="col-12 mt-3">
								<h6>Due Bills</h6>
							</div>
							<div class="col-5">
								<div id="due_description_container" class="">

								</div>
							</div>
							<div class="col-3">
								<div id="due_amount_container" class="text-center">

								</div>
							</div>
							<div class="col-4">
								<div id="due_duedate_container" class="text-center">

								</div>
							</div>
							<div class="col-8 offset-4 mt-3">
								<h6>GRAND TOTAL : ₱ <span id="total_amount"></span></h6>
								<input type="hidden" name="total_amount" id="hidden_total_amount">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<center><button  type="submit" id="payment_btn" class="btn btn-info" disabled="true">PROCEED TO PAYMENT</button></center>
					</div>
				</form>

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Transaction Histroy</h3></center>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="transaction_history_table">
							<thead>
								<tr>
									<th width="">Description</th>
									<th width="">Amount</th>
									<th width="">Payment Date</th>
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
					<div style="font-size: 25px; color:gray;top:-10px;"><center>Amount to Pay</center></div>
					<br><br>

					<span style="margin-left: 4em;">SELECT PAYMENT METHOD</span>

					<span id="spn_1">
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
					</span>


					<span id="spn_2">
						<div class="row rounded btn-pay" style="border: 1px solid #d2caca; margin-left: 5em; margin-right: 5em;" id="pay_via_gcash">
							<div style="padding: 3px;"><img src="<?php echo base_url('uploads/icons/gcash.jpeg') ?>" height=70 width=70>
								<span style="margin-left: 5px;">Pay via GCASH</span>
							</div>
						</div>

						<div id="div_iframe">
							
						</div>
					</span>






					


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