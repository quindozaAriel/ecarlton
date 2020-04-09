$(document).ready(()=>{
	AMENITY.load_amenities();
	AMENITY.load_reservation_history();
	AMENITY.load_reservation_request();
	AMENITY.load_pending_reservation();
});


const AMENITY = (() =>{
	var hidden_id = 0;

	var regForm = $('#registration_form').validate({
		debug: false,
		rules: {
			amenity:"required",
			quantity:{
				required:true,
				number:true
			},
			amount:{
				required:true,
				number:true
			}
		},
		messages: {
			amenity:"Please specify amenity.",
			quantity:{
				required:"Please input quantity",
				number:"Number only."
			},
			amount:{
				required:"Please input quantity",
				number:"Number only."
			}
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#registration_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'amenities',
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
							message: 'Amenity registered',
							position:'bottomCenter'
						});
						$('#registration_form')[0].reset();
						AMENITY.clear();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Amenity not registered',
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
					AMENITY.load_amenities();
				}
			});
		}
	});

	var updateForm = $('#update_form').validate({
		debug: false,
		rules: {
			_description:"required",
			_quantity:{
				required:true,
				number:true
			},
			_available_qty:{
				required:true,
				number:true
			},
			_amount:{
				required:true,
				number:true
			}
		},
		messages: {
			_description:"Please specify amenity.",
			_quantity:{
				required:"Please input quantity",
				number:"Number only."
			},
			_available_qty:{
				required:"Please input quantity",
				number:"Number only."
			},
			_amount:{
				required:"Please input quantity",
				number:"Number only."
			}
		},
		submitHandler:(form, event) => { 
			event.preventDefault();
			var update_data = {
				'description':$('#_description').val(),
				'quantity':$('#_quantity').val(),
				'available_qty':$('#_available_qty').val(),
				'amount':$('#_amount').val()
			}

			var data = {
				['_method']:'PATCH',
				['data']:update_data
			};

			$.ajax({
				type:'POST',
				url:base_url+'amenities/'+hidden_id,
				dataType:'json',
				data:data,
				cache: false,
				success:(result) => {
					if(result == true)
					{
						iziToast.success({
							title: 'Success',
							message: 'Amenities updated',
							position:'bottomCenter'
						});
						$('#update_form')[0].reset();
						AMENITY.clear();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Amenities not updated',
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
					AMENITY.load_amenities();
				}
			});
		}
	});
	var ret = {};

	ret.load_amenities = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'amenities-list',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					<td>${key+1}</td>
					<td>${val['description']}</td>
					<td>${val['quantity']}</td>
					<td>${val['available_qty']}</td>
					<td>${val['amount']}</td>
					<td>
					<button type="button" class="btn btn-success" title="Edit Amenities" onclick="AMENITY.load_info(\'${val['id']}\')"><i class="fa fa-edit"></i></button>
					<button type="button" class="btn btn-danger" title="Delete Amenities" onclick="AMENITY.delete(\'${val['id']}\')"><i class="fa fa-trash"></i></button>
					</td>
					</tr>`;
				});

				$('#amenities_tbl tbody').html(tbody);
				$('#amenities_tbl').DataTable();
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

	ret.load_info = (id)=>
	{

		$.ajax({
			type:'GET',
			url:base_url+`amenities/${id}`,
			dataType:'json',
			cache:false,
			success:(result) => {
				if(result != false)
				{
					$('#registration_form').addClass('d-none');
					$('#update_form').removeClass('d-none');

					hidden_id = id;	

					$('#_description').val(result.description);
					$('#_quantity').val(result.quantity);
					$('#_available_qty').val(result.available_qty);
					$('#_amount').val(result.amount);
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
			message: 'Are you sure to delete this amenities?',
			position: 'center', 
			progressBarColor: 'rgb(0, 255, 184)',
			buttons: [
			['<button>Yes</button>', function (instance, toast) {
				$.ajax({
					type:'POST',
					url:base_url+'amenities/'+id,
					dataType:'json',
					data:{'_method':'DELETE'},
					cache:false,
					success:(result)=>
					{
						if(result == true)
						{
							iziToast.success({
								title: 'Success',
								message: 'Amenities deleted.',
								position:'bottomCenter'
							});
						}
						else if(result == false)
						{
							iziToast.warning({
								title: 'Failed',
								message: 'Amenities not deleted.',
								position:'bottomCenter'
							});
						}
					},
					error:()=>
					{
						iziToast.error({
							title: 'Error',
							message: 'Error occured deleting amenities.',
							position:'bottomCenter'
						});
					},
					complete:()=>
					{
						AMENITY.load_amenities();
						AMENITY.clear();
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

	ret.clear = () =>
	{
		$('#registration_form')[0].reset();
		$('#registration_form').removeClass('d-none');
		hidden_id = 0;
		$('#update_form').addClass('d-none');
	}	


	ret.load_reservation_history = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'reservation-history',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>${val.status}</td>
					</tr>`;
				});

				$('#reservation_request').DataTable().destroy();
				$('#reservation_history tbody').html(tbody);
				$('#reservation_history').DataTable();
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

	ret.load_reservation_request = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'reservation-request',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>		
					<button type="button" class="btn btn-success" onclick="AMENITY.request_action(\'${val.reservation_id}\','APPROVED')" title="Approve Request"><i class="fa fa-check"></i></button>
					<button type="button" class="btn btn-danger" onclick="AMENITY.request_action(\'${val.reservation_id}\','REJECTED')" title="Decline Request"><i class="fa fa-times"></i></button>
					</td>
					</tr>`;
				});

				$('#reservation_request').DataTable().destroy();
				$('#reservation_request tbody').html(tbody);
				$('#reservation_request').DataTable();
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

	ret.request_action = (reservation_id,action) =>
	{
		$.ajax({
			type:'POST',
			url:base_url+'reservation-action/'+reservation_id+'/'+action,
			dataType:'json',
			data:{'_method':'PATCH'},
			cache:false,
			success:(result)=>
			{
				if(result == true)
				{
					iziToast.success({
						title: 'Success',
						message: 'Action Successful.',
						position:'center'
					});
				}
				else if(result == false)
				{
					iziToast.warning({
						title: 'Failed',
						message: 'Action not successful.',
						position:'center'
					});
				}
			},
			error:() => {
				iziToast.error({
					title: 'Error',
					message: 'Unexpected error occured',
					position:'center'
				});
			},
			complete:() => {
				AMENITY.load_amenities();
				AMENITY.load_reservation_history();
				AMENITY.load_reservation_request();
				AMENITY.load_pending_reservation();
			}
		});
	}


	ret.load_pending_reservation = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'reservation-pending',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>		
					<button type="button" class="btn btn-success" onclick="AMENITY.request_action(\'${val.reservation_id}\','FINISHED')" title="Finish Request"><i class="fa fa-check"></i></button>
					</td>
					</tr>`;
				});

				$('#pending_reservation').DataTable().destroy();
				$('#pending_reservation tbody').html(tbody);
				$('#pending_reservation').DataTable();
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

	return ret;

})()||{};