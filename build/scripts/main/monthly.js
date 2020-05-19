$(document).ready(()=>{
	MONTHLY.load_bills_list();
	MONTHLY.load_dashboard();
	MONTHLY.load_due_bills();
	MONTHLY.load_residents_id();
	MONTHLY.load_bills_id();
});

var dateToday = new Date();
$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd',minDate: dateToday });

const MONTHLY = (()=>{
	
	var hidden_id = 0;

	$('#registration_form').validate({
		debug: false,
		rules: {
			description:"required",
			amount:{
				required:true,
				number:true
			},
			bill_type:"required",
			duedate:"required",
			dueday:"required",
		},
		messages: {
			description:"Description is required.",
			amount:{
				required:"Please specify the amount.",
				number:"Number only."
			},
			bill_type:"Please specify type.",
			duedate:"Please select type and due date.",
			dueday:"Please select type and due date.",
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#registration_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'monthly',
				data:formData,
				dataType:'json',
				contentType: false,
				cache:false,
				processData:false,
				success:(result) => {
					if(result == true)
					{
						iziToast.success({
							title: 'Success',
							message: 'Bills added',
							position:'bottomCenter'
						});
						MONTHLY.registration_clear();
						MONTHLY.load_bills_list();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Bills not added',
							position:'bottomCenter'
						});
					}
					
				},
				error:() => {
					iziToast.error({
						title: 'Error',
						message: 'Unexpected error occured',
						position:'bottomCenter'
					});
				},
				complete:() => {
					
				}
			});
		},highlight:(element) => {
			$(element).removeClass('valid-input');
			$(element).addClass('invalid-input');
		},
		unhighlight:(element) => {
			$(element).removeClass('invalid-input');
			$(element).addClass('valid-input');
		}
	});

	$('#update_form').validate({
		debug: false,
		rules: {
			_description:"required",
			_amount:{
				required:true,
				number:true
			},
			_bill_type:"required",
			_duedate:"required",
			_dueday:"required",
		},
		messages: {
			_description:"Description is required.",
			_amount:{
				required:"Please specify the amount.",
				number:"Number only."
			},
			_bill_type:"Please specify type.",
			_duedate:"Please select type and due date.",
			_dueday:"Please select type and due date.",
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();

			var due_date_val = "";

			if($('#_type').val() == 'MONTHLY')
			{
				due_date_val = $('#_due_day').val();
			}
			else if($('#_type').val() == 'OCCASIONAL')
			{
				due_date_val = $('#_due_date').val();
			}

			var update_data = {
				'description':$('#_description').val(),
				'amount':$('#_amount').val(),
				'bill_type':$('#_type').val(),
				'due_date':due_date_val
			}

			var data = {
				['_method']:'PATCH',
				['data']:update_data
			};
			$.ajax({
				type:'POST',
				url:base_url+'monthly/'+hidden_id,
				dataType:'json',
				data:data,
				cache: false,
				success:(result) => {
					if(result == true)
					{
						iziToast.success({
							title: 'Success',
							message: 'Bill information updated',
							position:'bottomCenter'
						});
						MONTHLY.update_clear();
						MONTHLY.load_bills_list();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Bills information not updated',
							position:'bottomCenter'
						});
					}
					
				},
				error:() => {
					iziToast.error({
						title: 'Error',
						message: 'Unexpected error occured',
						position:'bottomCenter'
					});
				},
				complete:() => {
					
				}
			});
		},highlight:(element) => {
			$(element).removeClass('valid-input');
			$(element).addClass('invalid-input');
		},
		unhighlight:(element) => {
			$(element).removeClass('invalid-input');
			$(element).addClass('valid-input');
		}
	});

	$('#search_history_form').validate({
		debug: false,
		rules: {
			date_from:"required",
			date_to:"required"
		},
		messages: {
			date_from:"Date from required.",
			date_to:"Date to required."
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#search_history_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'monthly-payment',
				data:formData,
				dataType:'json',
				contentType: false,
				cache:false,
				processData:false,
				success:(result) => {
					var tbody = "";

					$.each(result,(key,val)=>{
						tbody += `<tr>
						<td>${val['payment_datetime']}</td>
						<td>${val['first_name']} ${val['middle_name']} ${val['last_name']}</td>
						<td>${val['description']}</td>
						<td>${val['amount']}</td>
						</tr>`;
					});
					$('#payment_tbl').DataTable().destroy();

					$('#payment_tbl tbody').html(tbody);
					$('#payment_tbl').DataTable();
				},
				error:() => {
					iziToast.error({
						title: 'Error',
						message: 'Unexpected error occured',
						position:'bottomCenter'
					});
				},
				complete:() => {

				}
			});

		}
	});

	var ret = {};

	ret.change_type = (value) =>
	{
		if(value == "MONTHLY")
		{
			$('#due_date').addClass('d-none');
			$('#due_date').prop('disabled',true);

			$('#due_day').removeClass('d-none');
			$('#due_day').prop('disabled',false);
		}
		else if(value == "OCCASIONAL")
		{
			$('#due_day').addClass('d-none');
			$('#due_day').prop('disabled',true);

			$('#due_date').removeClass('d-none');
			$('#due_date').prop('disabled',false);
		}
	}

	ret._change_type = (value) =>
	{
		if(value == "MONTHLY")
		{
			$('#_due_date').addClass('d-none');
			$('#_due_date').prop('disabled',true);

			$('#_due_day').removeClass('d-none');
			$('#_due_day').prop('disabled',false);
		}
		else if(value == "OCCASIONAL")
		{
			$('#_due_day').addClass('d-none');
			$('#_due_day').prop('disabled',true);

			$('#_due_date').removeClass('d-none');
			$('#_due_date').prop('disabled',false);
		}
	}


	ret.load_bills_list = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'monthly',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";
				var ctr = 1;
				$.each(result,(key,val)=>{

					var dued = '';

					if(val['bill_type'] == 'MONTHLY')
					{
						dued = `Every <b>${val['due_date']}</b> of the Month`;
					}
					else
					{
						dued = `On <b>${val['due_date']}</b>`;
					}
					tbody += `<tr>
					<td>${ctr}</td>
					<td>${val['bill_type']}</td>
					<td>${val['description']}</td>
					<td>${val['amount']}</td>
					<td>${dued}</td>
					<td>
					<center>
					<button type="button" class="btn btn-success" title="Update Bill" onclick="MONTHLY.load_bill(\'${val['id']}\')"><i class="fa fa-edit"></i></button>
					<button type="button" class="btn btn-danger" title="Delete Bill" onclick="MONTHLY.delete(\'${val['id']}\')"><i class="fa fa-trash"></i></button>
					</center>
					</td>
					</tr>`;
					ctr++;
				});

				$('#bills_table tbody').html(tbody);
				$('#bills_table').DataTable();
				$('input[type="search"]').addClass('form-control');	
			},
			error:() => {
				iziToast.error({
					title: 'Error',
					message: 'Unexpected error occured',
					position:'bottomCenter'
				});
			},
			complete:() => {

			}
		});
	}

	ret.load_bill = (bill_id)=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'monthly/'+bill_id,
			dataType:'json',
			cache:false,
			success:(result) => {
				$('#registration_form').addClass('d-none');
				$('#update_form').removeClass('d-none');

				$('#_description').val(result.description);
				$('#_amount').val(result.amount);
				$('#_type').val(result.bill_type);

				hidden_id = result.id;

				if(result.bill_type == 'MONTHLY')
				{
					$('#_due_date').addClass('d-none');
					$('#_due_date').prop('disabled',true);

					$('#_due_day').removeClass('d-none');
					$('#_due_day').prop('disabled',false);

					$('#_due_day').val(result.due_date);

				}
				else if(result.bill_type == 'OCCASIONAL')
				{
					$('#_due_day').addClass('d-none');
					$('#_due_day').prop('disabled',true);

					$('#_due_date').removeClass('d-none');
					$('#_due_date').prop('disabled',false);

					$('#_due_date').val(result.due_date);
				}
				
			},
			error:() => {
				iziToast.error({
					title: 'Error',
					message: 'Unexpected error occured',
					position:'bottomCenter'
				});
			},
			complete:() => {

			}
		});
	}


	ret.delete = (id) =>
	{

		iziToast.show({
			theme: 'dark',
			icon: 'fa fa-question',
			message: 'Are you sure to delete this data?',
			position: 'center', 
			progressBarColor: 'rgb(0, 255, 184)',
			buttons: [
			['<button>Yes</button>', function (instance, toast) {
				$.ajax({
					type:'POST',
					url:base_url+'monthly/'+id,
					dataType:'json',
					data:{'_method':'DELETE'},
					cache:false,
					success:(result)=>
					{
						if(result == true)
						{
							iziToast.success({
								title: 'Success',
								message: 'Bills deleted.',
								position:'bottomCenter'
							});
						}
						else if(result == false)
						{
							iziToast.warning({
								title: 'Failed',
								message: 'Bills not deleted.',
								position:'bottomCenter'
							});
						}
					},
					error:()=>
					{
						iziToast.error({
							title: 'Error',
							message: 'Error occured while deleting data.',
							position:'bottomCenter'
						});
					},
					complete:()=>
					{
						MONTHLY.load_bills_list();
					}
				});
				instance.hide({
					transitionOut: 'fadeOutUp',
				}, toast, 'buttonName');

			}, true],
			['<button>No</button>', function (instance, toast) {
				instance.hide({
					transitionOut: 'fadeOutUp',
				}, toast, 'buttonName');
			}]
			]
		});
	}

	ret.load_due_bills = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'monthly-due-bills',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					<td>${val['due_date']}</td>
					<td>${val['first_name']} ${val['middle_name']} ${val['last_name']}</td>
					<td>${val['description']}</td>
					<td>${val['amount']}</td>
					</tr>`;
				});

				$('#duebills_tbl tbody').html(tbody);
				$('#duebills_tbl').DataTable();
			},
			error:() => {
				iziToast.error({
					title: 'Error',
					message: 'Unexpected error occured',
					position:'bottomCenter'
				});
			},
			complete:() => {

			}
		});
	}

	ret.registration_clear = ()=>
	{
		$('#registration_form')[0].reset();

		$('#due_day').addClass('d-none');
		$('#due_day').prop('disabled',true);

		$('#due_date').addClass('d-none');
		$('#due_date').prop('disabled',true);
	}

	ret.update_clear = ()=>
	{
		$('#update_form')[0].reset();

		$('#update_form').addClass('d-none');
		$('#registration_form').removeClass('d-none');

		$('#_due_day').addClass('d-none');
		$('#_due_day').prop('disabled',true);

		$('#_due_date').addClass('d-none');
		$('#_due_date').prop('disabled',true);
	}

	ret.load_dashboard = () =>
	{	
		$.ajax({
			type:'GET',
			url:base_url+'monthly-sales-per-month',
			dataType:'json',
			cache:false,
			success:(result) => {
				var graph_data = [];
				$.each(result,(key,val)=>{
					graph_data.push(val);
				});
				MONTHLY.dashboard(graph_data);
				console.log(graph_data);
			},
			error:() => {
				iziToast.error({
					title: 'Error',
					message: 'Unexpected error occured',
					position:'topCenter'
				});
			},
			complete:() => {

			}
		});
	}

	ret.dashboard = (dashboard_data)=>
	{

		chartColor = "#FFFFFF";

    // General configuration for the charts with Line gradientStroke
    gradientChartOptionsConfiguration = {
    	maintainAspectRatio: false,
    	legend: {
    		display: false
    	},
    	tooltips: {
    		bodySpacing: 4,
    		mode: "nearest",
    		intersect: 0,
    		position: "nearest",
    		xPadding: 10,
    		yPadding: 10,
    		caretPadding: 10
    	},
    	responsive: 1,
    	scales: {
    		yAxes: [{
    			display: 0,
    			gridLines: 0,
    			ticks: {
    				display: false
    			},
    			gridLines: {
    				zeroLineColor: "transparent",
    				drawTicks: false,
    				display: false,
    				drawBorder: false
    			}
    		}],
    		xAxes: [{
    			display: 0,
    			gridLines: 0,
    			ticks: {
    				display: false
    			},
    			gridLines: {
    				zeroLineColor: "transparent",
    				drawTicks: false,
    				display: false,
    				drawBorder: false
    			}
    		}]
    	},
    	layout: {
    		padding: {
    			left: 0,
    			right: 0,
    			top: 15,
    			bottom: 15
    		}
    	}
    };

    gradientChartOptionsConfigurationWithNumbersAndGrid = {
    	maintainAspectRatio: false,
    	legend: {
    		display: false
    	},
    	tooltips: {
    		bodySpacing: 4,
    		mode: "nearest",
    		intersect: 0,
    		position: "nearest",
    		xPadding: 10,
    		yPadding: 10,
    		caretPadding: 10
    	},
    	responsive: true,
    	scales: {
    		yAxes: [{
    			gridLines: 0,
    			gridLines: {
    				zeroLineColor: "transparent",
    				drawBorder: false
    			}
    		}],
    		xAxes: [{
    			display: 0,
    			gridLines: 0,
    			ticks: {
    				display: false
    			},
    			gridLines: {
    				zeroLineColor: "transparent",
    				drawTicks: false,
    				display: false,
    				drawBorder: false
    			}
    		}]
    	},
    	layout: {
    		padding: {
    			left: 0,
    			right: 0,
    			top: 15,
    			bottom: 15
    		}
    	}
    };

    var ctx = document.getElementById('bigDashboardChart').getContext("2d");

    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    var gradientFill = ctx.createLinearGradient(0, 200, 0, 50);
    gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
    gradientFill.addColorStop(1, "rgba(255, 255, 255, 0.24)");

    var myChart = new Chart(ctx, {
    	type: 'line',
    	data: {
    		labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
    		datasets: [{
    			label: "Total Collected",
    			borderColor: chartColor,
    			pointBorderColor: chartColor,
    			pointBackgroundColor: "#1e3d60",
    			pointHoverBackgroundColor: "#1e3d60",
    			pointHoverBorderColor: chartColor,
    			pointBorderWidth: 1,
    			pointHoverRadius: 7,
    			pointHoverBorderWidth: 2,
    			pointRadius: 5,
    			fill: true,
    			backgroundColor: gradientFill,
    			borderWidth: 2,
    			data:dashboard_data
    		}]
    	},
    	options: {
    		layout: {
    			padding: {
    				left: 20,
    				right: 20,
    				top: 0,
    				bottom: 0
    			}
    		},
    		maintainAspectRatio: false,
    		tooltips: {
    			backgroundColor: '#fff',
    			titleFontColor: '#333',
    			bodyFontColor: '#666',
    			bodySpacing: 4,
    			xPadding: 12,
    			mode: "nearest",
    			intersect: 0,
    			position: "nearest"
    		},
    		legend: {
    			position: "bottom",
    			fillStyle: "#FFF",
    			display: false
    		},
    		scales: {
    			yAxes: [{
    				ticks: {
    					fontColor: "rgba(255,255,255,0.4)",
    					fontStyle: "bold",
    					beginAtZero: true,
    					maxTicksLimit: 5,
    					padding: 10
    				},
    				gridLines: {
    					drawTicks: true,
    					drawBorder: false,
    					display: true,
    					color: "rgba(255,255,255,0.1)",
    					zeroLineColor: "transparent"
    				}

    			}],
    			xAxes: [{
    				gridLines: {
    					zeroLineColor: "transparent",
    					display: false,

    				},
    				ticks: {
    					padding: 10,
    					fontColor: "rgba(255,255,255,0.4)",
    					fontStyle: "bold"
    				}
    			}]
    		}
    	}
    });
}

ret.getResidentInfo = ()=>
{
	var resident_id = $('#resident_id').val();

	$.ajax({
		type:"GET",
		url:`resident/${resident_id}`,
		dataType:'json',
		cache: false,
		success:(result)=>
		{
			$('#first_name').val(result.first_name);
			$('#middle_name').val(result.middle_name);
			$('#last_name').val(result.last_name);
		},
		error:()=>
		{

		},
		complete:()=>
		{

		}
	})
}

ret.load_residents_id = ()=>
{
	$.ajax({
		type:"GET",
		url:`resident-list`,
		dataType:'json',
		cache: false,
		success:(result)=>
		{
			if(result != null)
			{
				var option = "";
				$.each(result,(key,val)=>{
					option += `<option value="${val.id}">${val.first_name} ${val.middle_name} ${val.last_name}</option>`;
				});

				$('#residents').html(option);
			}
		},
		error:()=>
		{

		},
		complete:()=>
		{

		}
	});
}
var bills_array = [];

ret.load_bills_id = ()=>
{
	var resident_id = $('#resident_id').val();

	$.ajax({
		type:"GET",
		url:`monthly`,
		dataType:'json',
		cache: false,
		success:(result)=>
		{
			if(result != null)
			{
				var option = "";
				$.each(result,(key,val)=>{
					option += `<option value="${val.id}">${val.description} - ₱ ${val.amount}</option>`;
				});

				$('#bill_id').html(option);

				bills_array = result;
			}
		},
		error:()=>
		{

		},
		complete:()=>
		{
			console.log(bills_array);
		}
	});
}

var current_bills = [];

ret.add_bills = (bill_id)=>
{
	var description = "";
	var amount = 0;

	var exist_check = MONTHLY.check_arr(current_bills,bill_id);

	if(exist_check == false)
	{
		$.each(bills_array,(key,val)=>{
			if(val.id == bill_id)
			{
				description = val.description;
				amount = val.amount;
			}
		});	

		var arr = {
			'bill_id':bill_id,
			'description':description,
			'amount':amount
		};

		current_bills.push(arr);

		var tbody="";
		var total_amount = 0;
		$.each(current_bills,(key,val)=>{
			tbody += `<tr>
			<td>${key+1}</td>
			<td>${val.description}</td>
			<td>₱ ${val.amount}</td>
			</tr>`;
			total_amount = parseFloat(total_amount) + parseFloat(val.amount);
		});
		$('#bills_details tbody').html(tbody);
		$('#span_total').html('₱ ' + total_amount);
	}
}

ret.check_arr = (arr, bills_id)=>
{
	const { length } = arr;
	const id = length + 1;
	const found = arr.some(el => el.bill_id == bills_id);
	return found;
}

ret.manual_pay = () =>
{
	var resident_id = $('#resident_id').val();
	var payment_date = $('#payment_date').val();
	var total_amount = $('#span_total').html();

	var payment_amount = total_amount.replace( /^\D+/g, ''); 

	if((resident_id != null || resident_id != "") && (payment_date != null || payment_date != "") && (payment_amount != null || payment_amount != "") && current_bills.length > 0 )
	{
		$.ajax({
			type:"POST",
			url:`manual_payment`,
			dataType:'json',
			data:{
				resident_id:resident_id,
				payment_date:payment_date,
				payment_amount:payment_amount,
				details:current_bills
			},
			cache: false,
			success:(result)=>
			{
				if(result == true)
				{
					iziToast.success({
						title: 'Success',
						message: 'Manual Payment Saved',
						position:'bottomCenter'
					});
					$('#manual_payment_form')[0].reset();$('#bills_details tbody').html('');$('#span_total').html('₱ 0');

					$('#manual_payment_modal').modal('hide');
				}
			},
			error:()=>
			{

			},
			complete:()=>
			{
				console.log(bills_array);
			}
		});
	}
	else
	{
		iziToast.error({
			title: 'Invalid',
			message: 'Please complete the details ',
			position:'bottomCenter'
		});
	}

}
return ret;

})()||{};