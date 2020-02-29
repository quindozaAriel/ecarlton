$(document).ready(()=>{
	MONTHLY.load_bills_list();
	MONTHLY.load_due_bills();
});

const MONTHLY = (()=>{
	
	
	$('#registration_form').validate({
		debug: false,
		rules: {
			description:"required",
			amount:{
				required:true,
				number:true
			},
			type:"required",
			duedate:"required",
			dueday:"required",
		},
		messages: {
			description:"Description is required.",
			amount:{
				required:"Please specify the amount.",
				number:"Number only."
			},
			type:"Please specify type.",
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
						$('#registration_form')[0].reset();
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
			$('#due_day').removeClass('d-none');
			$('#due_day').prop('disabled',false);
			$('#due_date').prop('disabled',true);
		}
		else if(value == "ONCE")
		{
			$('#due_day').addClass('d-none');
			$('#due_date').removeClass('d-none');
			$('#due_date').prop('disabled',false);
			$('#due_day').prop('disabled',true);

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

					if(val['type'] == 'MONTHLY')
					{
						dued = `Every ${val['due_date']}`;
					}
					else
					{
						dued = `On ${val['due_date']}`;
					}
					tbody += `<tr>
					<td>${ctr}</td>
					<td>${val['description']}</td>
					<td>${val['amount']}</td>
					<td>${dued}</td>
					<td>
					<center>
					<button type="button" class="btn btn-danger" title="Delete Amenities" onclick="MONTHLY.delete(\'${val['id']}\')"><i class="fa fa-trash"></i></button>
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

	return ret;

})()||{};