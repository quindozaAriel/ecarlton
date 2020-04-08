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