$(document).ready(()=>{
	RESERVATION.load_amenities();
	RESERVATION.load_my_reservation();
	$('#amenity_reservation').DataTable();
	$('#my_reservation_table').DataTable();

});

var dateToday = new Date();
$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd',minDate: dateToday });

const RESERVATION = (()=>{

	$('.datepicker').on('change',()=>{
		$('#pr_btn').addClass('d-none');
		$('#ca_btn').removeClass('d-none');
		RESERVATION.compute_amount();
	});

	$('#quantity').on('change',()=>{
		$('#pr_btn').addClass('d-none');
		$('#ca_btn').removeClass('d-none');
		RESERVATION.compute_amount();
	});

	$('#reservation_form').validate({
		debug: false,
		rules: {
			amenities:"required",
			date_from:"required",
			date_to:"required",
			quantity:{
				required:true,
				min:1
			},
			total_amount:"required"
		},
		messages: {
			amenities:"Please pick amenity",
			date_from:"Please choose date",
			date_to:"Please choose date",
			quantity:{
				required:"Please input quantity",
				min:"Please select valid quantity"
			},
			total_amount:"Amount not computed. Please try again."
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#reservation_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'reservation',
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
							message: 'Reservation Requested. Please wait for confirmation',
							position:'topCenter'
						});
						$('#reservation_form')[0].reset();
						RESERVATION.load_my_reservation();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Please try again.',
							position:'topCenter'
						});
					}
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
		},highlight:(element) => {
			$(element).removeClass('valid-input');
			$(element).addClass('invalid-input');
		},
		unhighlight:(element) => {
			$(element).removeClass('invalid-input');
			$(element).addClass('valid-input');
		}
	});

	let _this = {};

	_this.load_amenities = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'amenities-list',
			dataType:'json',
			cache:false,
			success:(result) => {
				var option = "<option value='' selected></option>";

				$.each(result,(key,val)=>{
					option += `<option value="${val['id']}">${val['description']}</option>`;

				});

				$('#amenities').html(option);
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

	_this.load_amenities_information = () =>
	{
		var id = $('#amenities').val();
		if(id == "")
		{
			$('#reservation_form')[0].reset();
		}
		else
		{
			$.ajax({
				type:'GET',
				url:base_url+`amenities/${id}`,
				dataType:'json',
				cache:false,
				success:(result) => {
					if(result != false)
					{
						$('#amount').val(`${result.amount}`);
						$('#available_qty').val(`${result.available_qty}`);
						RESERVATION.load_amenity_reservation(id);
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
		
	}


	_this.check_availability = () =>
	{
		var amenity_id = $('#amenities').val();
		var date_from = $('#date_from').val();
		var date_to = $('#date_to').val();
		var request_qty = $('#quantity').val();
		var available_qty = $('#available_qty').val();

		var date1 = new Date(date_from); 
		var date2 = new Date(date_to); 

		if(amenity_id == "" || date_from == "" || date_to == "" || request_qty == "")
		{
			iziToast.error({
				title: 'Note',
				message: 'Please complete the form',
				position:'topCenter'
			});
		}
		else
		{
			if(parseInt(request_qty) > parseInt(available_qty))
			{
				iziToast.error({
					title: 'Invalid',
					message: 'Your request quantity is greater than available quantity',
					position:'topCenter'
				});
			}
			else
			{
				if(date1 <= date2)
				{
					$.ajax({
						type:'GET',
						url:base_url+`reservation-availability/${amenity_id}/${date_from}/${date_to}/${request_qty}`,
						dataType:'json',
						cache:false,
						success:(result) =>
						{
							if(result == 'AVAILABLE')
							{
								iziToast.success({
									title: 'Success',
									message: 'Schedule available',
									position:'topCenter'
								});
								$('#pr_btn').removeClass('d-none');
								$('#ca_btn').addClass('d-none');

							}
							else if(result == 'FULL')
							{
								iziToast.warning({
									title: 'Info',
									message: 'Sorry your requested amenity was fully book on your chosen date',
									position:'topCenter'
								});
							}
						},
						error:() => 
						{
							iziToast.error({
								title: 'Error',
								message: 'Unexpected error occured',
								position:'topCenter'
							});
						},
						complete:() => 
						{

						}
					});
				}
				else
				{
					iziToast.error({
						title: 'Invalid Date',
						message: 'Please check schedule date',
						position:'topCenter'
					});
				}
			}
		}

	}

	_this.load_amenity_reservation = (id) =>
	{
		$.ajax({
			type:'GET',
			url:base_url+`reservation-load-amenity/${id}`,
			dataType:'json',
			cache:false,
			success:(result) => 
			{
				var tbody ="";
				$.each(result,(key,val)=>{
					var fname = val['first_name'].substring(0,1);
					tbody += `<tr>
					<td>${val['date_from']}<br>${val['date_to']}</td>
					<td>${fname}.${val['last_name']}</td>
					<td>${val['reserved_qty']}</td>
					</tr>`;
				});

				$('#amenity_reservation').DataTable().destroy();
				$('#amenity_reservation tbody').html(tbody);
				$('#amenity_reservation').DataTable();
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

	_this.compute_amount = () =>
	{
		var total_amount = 0;

		var price = $('#amount').val();
		var qty   = $('#quantity').val();
		var date_from =  new Date($('#date_from').val());
		var date_to =  new Date($('#date_to').val());

		if(price != "" && qty != "" && date_from != "" && date_to != "" )
		{
			var Difference_In_Time = date_to.getTime() - date_from.getTime(); 
			var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 


			total_amount = (parseFloat(price) * parseFloat(qty)) * (Difference_In_Days + 1);

			$('#total_amount').val(total_amount);
		}
	}	

	_this.load_my_reservation = () =>
	{	
		$.ajax({
			type:'GET',
			url:base_url+'my_reservation',
			dataType:'json',
			cache:false,
			success:(result) => {

				var tbody ="";
				$.each(result,(key,val)=>{

					tbody += `<tr>
					<td>${val['date_from']}<br>${val['date_to']}</td>
					<td>
					${val['description']} x ${val['quantity']} = ₱${val['total_amount']}<br>
					<span class="badge badge-info">${val['status']}</span>
					</td>
					</tr>`;
				});

				$('#my_reservation_table').DataTable().destroy();
				$('#my_reservation_table tbody').html(tbody);
				$('#my_reservation_table').DataTable();
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

	return _this;

})()||{};



// // var array = ["2020-03-14","2020-03-15","2020-03-16"];

// $('.datepicker').datepicker({
// 	beforeShowDay: function(date){
// 		var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
// 		return [ array.indexOf(string) == -1 ]
// 	}
// });