<div class="panel-header panel-header-sm">

</div>
<div class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<center><h3>Bills</h3></center>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<h6>For Month of <?php echo date("F", strtotime(date('Y-m-d')));?></h6>
						</div>
						<div class="col-6">
							<div id="description_container" class="text-center">
							
							</div>
						</div>
						<div class="col-6">
							<div id="amount_container" class="text-center">
							
							</div>
						</div>
						<div class="col-8 offset-4 mt-3">
							<h6>GRAND TOTAL : ₱ <span id="total_amount"></span></h6>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<center><button class="btn btn-info">PROCEED TO PAYMENT</button></center>
				</div>
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