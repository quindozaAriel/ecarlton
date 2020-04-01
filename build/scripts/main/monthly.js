$(document).ready(()=>{
	MONTHLY.load_bills_list();
	// MONTHLY.load_due_bills();
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
			notifdate:"required",
			dueday:"required",
			notifday:"required",
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
			notifdate:"Please select type and due date.",
			notifday:"Please select type and due date.",
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
			_notifdate:"required",
			_dueday:"required",
			_notifday:"required",
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
			_notifdate:"Please select type and due date.",
			_notifday:"Please select type and due date.",
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();

			var due_date_val = "";
			var notif_date_val = "";

			if($('#_type').val() == 'MONTHLY')
			{
				due_date_val = $('#_due_day').val();
				notif_date_val = $('#_notif_day').val();
			}
			else if($('#_type').val() == 'OCCASIONAL')
			{
				due_date_val = $('#_due_date').val();
				notif_date_val = $('#_notif_date').val();
			}

			var update_data = {
				'description':$('#_description').val(),
				'amount':$('#_amount').val(),
				'bill_type':$('#_type').val(),
				'due_date':due_date_val,
				'notif_date':notif_date_val,
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
						<td>${val['payment_date']}</td>
						<td>${val['first_name']} ${val['middle_name']} ${val['last_name']}</td>
						<td>${val['description']}</td>
						<td>${val['amount']}</td>
						</tr>`;
					});

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
			$('#notif_date').addClass('d-none');
			$('#notif_date').prop('disabled',true);

			$('#due_day').removeClass('d-none');
			$('#due_day').prop('disabled',false);
			$('#notif_day').removeClass('d-none');
			$('#notif_day').prop('disabled',false);
		}
		else if(value == "OCCASIONAL")
		{
			$('#due_day').addClass('d-none');
			$('#due_day').prop('disabled',true);
			$('#notif_day').addClass('d-none');
			$('#notif_day').prop('disabled',true);

			$('#due_date').removeClass('d-none');
			$('#due_date').prop('disabled',false);
			$('#notif_date').removeClass('d-none');
			$('#notif_date').prop('disabled',false);
		}
	}

	ret._change_type = (value) =>
	{
		if(value == "MONTHLY")
		{
			$('#_due_date').addClass('d-none');
			$('#_due_date').prop('disabled',true);
			$('#_notif_date').addClass('d-none');
			$('#_notif_date').prop('disabled',true);

			$('#_due_day').removeClass('d-none');
			$('#_due_day').prop('disabled',false);
			$('#_notif_day').removeClass('d-none');
			$('#_notif_day').prop('disabled',false);
		}
		else if(value == "OCCASIONAL")
		{
			$('#_due_day').addClass('d-none');
			$('#_due_day').prop('disabled',true);
			$('#_notif_day').addClass('d-none');
			$('#_notif_day').prop('disabled',true);

			$('#_due_date').removeClass('d-none');
			$('#_due_date').prop('disabled',false);
			$('#_notif_date').removeClass('d-none');
			$('#_notif_date').prop('disabled',false);
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
					$('#_notif_date').addClass('d-none');
					$('#_notif_date').prop('disabled',true);

					$('#_due_day').removeClass('d-none');
					$('#_due_day').prop('disabled',false);
					$('#_notif_day').removeClass('d-none');
					$('#_notif_day').prop('disabled',false);

					$('#_notif_day').val(result.notif_date);
					$('#_due_day').val(result.due_date);

				}
				else if(result.bill_type == 'OCCASIONAL')
				{
					$('#_due_day').addClass('d-none');
					$('#_due_day').prop('disabled',true);
					$('#_notif_day').addClass('d-none');
					$('#_notif_day').prop('disabled',true);

					$('#_due_date').removeClass('d-none');
					$('#_due_date').prop('disabled',false);
					$('#_notif_date').removeClass('d-none');
					$('#_notif_date').prop('disabled',false);	

					$('#_notif_date').val(result.notif_date);
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
					<td>${val['payment_date']}</td>
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
		$('#notif_day').addClass('d-none');
		$('#notif_day').prop('disabled',true);

		$('#due_date').addClass('d-none');
		$('#due_date').prop('disabled',true);
		$('#notif_date').addClass('d-none');
		$('#notif_date').prop('disabled',true);
	}

	ret.update_clear = ()=>
	{
		$('#update_form')[0].reset();

		$('#update_form').addClass('d-none');
		$('#registration_form').removeClass('d-none');

		$('#_due_day').addClass('d-none');
		$('#_due_day').prop('disabled',true);
		$('#_notif_day').addClass('d-none');
		$('#_notif_day').prop('disabled',true);

		$('#_due_date').addClass('d-none');
		$('#_due_date').prop('disabled',true);
		$('#_notif_date').addClass('d-none');
		$('#_notif_date').prop('disabled',true);
	}


	return ret;

})()||{};