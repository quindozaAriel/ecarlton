$(document).ready(()=>{
	BILLS.load_bills();
	BILLS.load_transaction_history();
});

const BILLS = (()=>{
	

	$('#payment_form').on("submit",(e)=>{
		e.preventDefault();
		iziToast.show({
			theme: 'dark',
			icon: 'fa fa-question',
			message: 'Are you sure to proceed to payment?',
			position: 'center', 
			progressBarColor: 'rgb(0, 255, 184)',
			buttons: [
			['<button style="width:70px;height:30px;">Yes</button>', function (instance, toast) {
				var formData = new FormData($('#payment_form')[0]);	
				$.ajax({
					type:'POST',
					url:base_url+'bills',
					dataType:'json',
					data:formData,
					contentType: false,
					cache:false,
					processData:false,
					success:function(result)
					{	
						if(result == true)
						{
							iziToast.success({
								title: 'Success',
								message: 'Payment Successful.',
								position:'topCenter'
							});
							
						}
						else
						{
							iziToast.error({
								title: 'Invalid',
								message: 'Payment unsuccessful.',
								position:'topCenter'
							});
						}
					},
					error:function()
					{
						iziToast.error({
							title: 'Error',
							message: 'Error occured.',
							position:'topCenter'
						});
					},
					complete:() => {
						BILLS.load_bills();
						BILLS.load_transaction_history();
					}
				});
				instance.hide({
					transitionOut: 'fadeOutUp',
				}, toast, 'buttonName');

			}, true],
			['<button style="width:60px;height:30px;">No</button>', function (instance, toast) {
				instance.hide({
					transitionOut: 'fadeOutUp',
				}, toast, 'buttonName');
			}]
			]
		});

		
	});
	let _this = {};

	_this.check_checkbox = () =>
	{
		if ($("#payment_form input:checkbox:checked").length > 0)
		{
			$('#payment_btn').attr("disabled",false);
			BILLS.compute();
		}
		else
		{
			$('#payment_btn').attr("disabled",true);
			$("#total_amount").html(0);
			$("#hidden_total_amount").val(0);
		}
	}

	_this.compute = () =>
	{
		var total_amount = 0;
		var value_array = [];

		$("#payment_form input:checkbox:checked").each(function(){
			value_array.push($(this).val());
		});
		
		$.each(value_array,(key,val)=>{
			var amount = val.split('-').pop();
			total_amount = total_amount	+ parseFloat(amount);
		});

		$("#total_amount").html(total_amount);
		$("#hidden_total_amount").val(total_amount);
	}

	_this.load_bills = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'bills',
			dataType:'json',
			cache:false,
			success:(result)=>
			{
				
				
				if(result['bills'] != null && result['bills'] != "")
				{
					
					var description = "<b>Bills</b><br>";
					var amount = "<b>Amount</b><br>";
					var due_date = "<b>Due Date</b><br>";

					$.each(result['bills'],(key,val)=>{
						
						description += `<input type="checkbox" name="bills[]" value="normal_${val.bills_id}-${val.amount}" onclick="BILLS.check_checkbox();">&nbsp;<label>${val.description}</label><br>`;
						amount += `<label>₱<b> ${val.amount}</b></label><br>`;
						if(val.bill_type == "MONTHLY")
						{
							due_date += `<label>On <b>${val.due_date}</b></label><br>`;
						}
						else if(val.bill_type == "OCCASIONAL")
						{
							due_date += `<label><b>${val.due_date}</b></label><br>`;
						}

						
					});

					$('#description_container').html(description);
					$('#amount_container').html(amount);
					$('#duedate_container').html(due_date);
				}
				else
				{
					$('#description_container').html('No bills for this month');
					$('#amount_container').html("");
					$('#duedate_container').html("");
				}

				if(result['due_bills'] != null && result['due_bills'] != "")
				{
					var description = "";
					var amount = "";
					var due_date = "";
					
					$.each(result['due_bills'],(key,val)=>{

						description += `<input type="checkbox" name="bills[]" value="due_${val.due_bills_id}-${val.amount}" onclick="BILLS.check_checkbox();">&nbsp;<label>${val.description}</label><br>`;
						amount += `<label>₱<b> ${val.amount}</b></label><br>`;
						due_date += `<label><b>${val.due_date}</b></label><br>`;

						
					});

					$('#due_description_container').html(description);
					$('#due_amount_container').html(amount);
					$('#due_duedate_container').html(due_date);
				}
				else
				{
					$('#due_description_container').html("No due bills");
					$('#due_amount_container').html("");
					$('#due_duedate_container').html("");
				}

				
			},
			error:function()
			{
				iziToast.error({
					title: 'Error',
					message: 'There is problem while logging you in.',
					position:'topCenter'
				});
			},
			complete:() => {

			}

		});
	}

	_this.load_transaction_history = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'bills-transaction-history',
			dataType:'json',
			cache:false,
			success:(result)=>
			{
				var tbody = "";
				$.each(result,(key,val)=>{
					var description = "";

					$.each(val,(kkey,vval)=>{
						description += `<label>${vval.description} - ₱ ${vval.amount}</label><br>`;
					});
					tbody += `<tr>
					<td>${description}</td>
					<td>₱ ${val[0]['payment_amount']}</td>
					<td>${val[0]['payment_datetime']}</td>
					</tr>`;
				});
				$('#transaction_history_table').DataTable().destroy();
				$('#transaction_history_table tbody').html(tbody);
				$('#transaction_history_table').DataTable();
				$('input[type="search"]').addClass('form-control');	
			},
			error:function()
			{
				iziToast.error({
					title: 'Error',
					message: 'There is problem while logging you in.',
					position:'topCenter'
				});
			},
			complete:() => {

			}

		});
	}
	return _this;

})()||{};