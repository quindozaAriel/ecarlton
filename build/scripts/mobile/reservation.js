$(document).ready(()=>{
	RESERVATION.load_amenities();
	RESERVATION.load_my_reservation();
	$('#amenity_reservation').DataTable();
	$('#my_reservation_table').DataTable();

});

var dateToday = new Date();
$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd',minDate: dateToday });

const RESERVATION = (()=>{

	let _cur_amount = 0;
	let _cur_id 	= 0;
	let _cur_payment_intent_id = 0;
	let _cur_payment_method_id = 0;

	$('#btn_via_card').on('click',()=>{
		RESERVATION.create_payment_method();
	});

	$('#pay_gcash').on('click',()=>{
		RESERVATION.create_source();
	});

	$('#pay_card').on('click',()=>{
		RESERVATION.create_payment_intent();
	});

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

	$('#amenities').on('change',()=>{
		$('#pr_btn').addClass('d-none');
		$('#ca_btn').removeClass('d-none');
		RESERVATION.compute_amount();
	});

	$('#slc_month').on('change',()=>{
		let val = $('#slc_month').val();
		$('#spn_month').html(val);
	});

	$('#slc_year').on('change',()=>{
		let val = $('#slc_year').val();
		$('#spn_year').html(val);
	});


	$('#txt_card_number').on('keyup',()=>{

		let val = $('#txt_card_number').val();

		if(val.length != 16)
		{
			for(var i=val.length;i<16;i++)
			{
				val+='•';
			}
		}

		let arr_val = val.split('');
		let str_val = '';
		let counter = 0;

		arr_val.forEach((item)=>{

			if(counter == 4)
			{
				counter = 0;
				str_val+=' ';
			}
			str_val+=item;
			counter++;
		});
		$('#cont_number').html(str_val);
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

					let pay_btn = `<button class="btn btn-info p-1" type="button" onclick="RESERVATION.pay(\'${val.id}\',\'${val['total_amount']}\','${val.src_id}')"><i class="fas fa-money-bill"></i> CLICK TO PAY</button>`; 
					if(val.src_id == '' || val.src_id == null)
					{
						pay_btn = `<button class="btn btn-info p-1 disabled" type="button" onclick="RESERVATION.pay(\'${val.id}\',\'${val['total_amount']}\')"><i class="fas fa-money-bill"></i> CLICK TO PAY</button>`;
					}

					var stat  = "";
					if(val['status'] == 'APPROVED')
					{
						stat = `
						<button class="btn btn-warning p-1" type="button" onclick="RESERVATION.authorize(\'${val.id}\',\'${val['total_amount']}\')"><i class="fas fa-money-bill"></i> CLICK TO AUTHORIZE</button>
						${pay_btn}
						`;
					}
					else if(val['status'] == 'REJECTED')
					{
						stat = `<span class="badge badge-danger">${val['status']}</span>`;
					}
					else if(val['status'] == 'PENDING')
					{
						stat = `<span class="badge badge-secondary">${val['status']}</span>`;
					}
					else if(val['status'] == 'FINISHED')
					{
						stat = `<span class="badge badge-dark">${val['status']}</span>`;
					}
					else if(val['status'] == 'PAID')
					{
						stat = `<span class="badge badge-success">${val['status']}</span>`;
					}

					tbody += `<tr>
					<td>${val['date_from']}<br>${val['date_to']}</td>
					<td>
					${val['description']} x ${val['quantity']} = ₱${val['total_amount']}<br>
					${stat}
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

	_this.create_payment = (id) =>
	{
		let src_id = id;
		var data = "{\"data\":{\"attributes\":{\"source\":{\"id\":\"src_SbweMneGVm8A69Bhukf1CAZm\",\"type\":\"source\"},\"amount\":50000,\"description\":\"dec1\",\"currency\":\"PHP\",\"statement_descriptor\":\"ecarlton\"}}}";

		var xhr = new XMLHttpRequest();

		xhr.addEventListener("readystatechange", function () {
			if (this.readyState === this.DONE) {
				console.log(this.responseText);
			}
		});

		xhr.open("POST", "https://api.paymongo.com/v1/payments");
		xhr.setRequestHeader("content-type", "application/json");
		xhr.setRequestHeader("authorization", "Basic c2tfdGVzdF9jekcxWFRLTm5SOHQ3YlhrU2d5cFg3M3c6");

		xhr.send(data);
	}

	_this.create_source = () =>
	{
		// alert(_cur_amount);
		let amount = _cur_amount+'00';
		var data = "{\"data\":{\"attributes\":{\"redirect\":{\"success\":\"http://localhost/ecarlton/mobile-gcash-success\",\"failed\":\"http://localhost/ecarlton/mobile-gcash-error\"},\"type\":\"gcash\",\"amount\":"+amount+",\"currency\":\"PHP\"}}}";

		var xhr 		= new XMLHttpRequest();
		var boom_url 	= '';

		xhr.addEventListener("readystatechange", function () {
			if (this.readyState === this.DONE) {
				// console.log(this.responseText);
				boom_url = JSON.parse(this.responseText);

				console.log(boom_url.data.id);
				console.log(boom_url);

				$.ajax({
					type:'post',
					url:base_url+'check-reservation',
					data:
					{
						id:_cur_id,
						src_id:boom_url.data.id
					},
					cache:false,
					success:(data)=>
					{
						$('#paymode_modal').modal('hide');
						RESERVATION.load_my_reservation();
						window.open(boom_url.data.attributes.redirect.checkout_url);
					}
				});
				
			}
		});

		xhr.open("POST", "https://api.paymongo.com/v1/sources");
		xhr.setRequestHeader("content-type", "application/json");
		xhr.setRequestHeader("authorization", "Basic cGtfdGVzdF9hMloyUThqWDIzUXZjUDdqbVJVZlZhd1U6");

		xhr.send(data);

	}


	_this.create_payment_intent = () =>
	{
		let amount = _cur_amount+'00';
		var data = "{\"data\":{\"attributes\":{\"payment_method_allowed\":[\"card\"],\"payment_method_options\":{\"card\":{\"request_three_d_secure\":\"automatic\"}},\"currency\":\"PHP\",\"amount\":"+amount+",\"description\":\"description\",\"statement_descriptor\":\"descriptor\"}}}";

		var xhr = new XMLHttpRequest();

		xhr.addEventListener("readystatechange", function () {
			if (this.readyState === this.DONE) {
				// console.log(this.responseText);
				let boom = JSON.parse(this.responseText);
				console.log(boom.data.id);

				_cur_payment_intent_id = boom.data.id;

				$('#paymode_modal').modal('hide');
				$('#card_payment_modal').modal('show');

				let opt_month = '';
				let opt_year = '';
				for(let i =1; i<=12;i++)
				{
					opt_month += '<option value="'+i+'">'+i+'</option>';
				}
				$('#slc_month').html(opt_month);

				for(let a =20; a<=99;a++)
				{
					opt_year += '<option value="'+a+'">'+a+'</option>';
				}
				$('#slc_year').html(opt_year);
			}
		});

		xhr.open("POST", "https://api.paymongo.com/v1/payment_intents");
		xhr.setRequestHeader("content-type", "application/json");
		xhr.setRequestHeader("authorization", "Basic c2tfdGVzdF9jekcxWFRLTm5SOHQ3YlhrU2d5cFg3M3c6");

		xhr.send(data);
	}

	_this.create_payment_method = () =>
	{
		let card_number = $('#txt_card_number').val();
		let exp_month 	= $('#slc_month').val();
		let exp_year 	= $('#slc_year').val();
		let cvc  		= '123';
		let name 		= 'resident';
		let email 		= 'resident@yahoo.com';
		var data = "{\"data\":{\"attributes\":{\"details\":{\"exp_month\":"+exp_month+",\"exp_year\":"+exp_year+",\"cvc\":\""+cvc+"\",\"card_number\":\""+card_number+"\"},\"billing\":{\"name\":\""+name+"\",\"email\":\""+email+"\"},\"type\":\"card\"}}}";

		var xhr = new XMLHttpRequest();

		xhr.addEventListener("readystatechange", function () {
			if (this.readyState === this.DONE) {
				console.log(this.responseText);
				let result = JSON.parse(this.responseText);
				console.log(result);
				let err_msg = '';
				if(result.errors)
				{
					result.errors.forEach((err)=>{
						err_msg+=`<li>${err.detail}</li>`;
					});
					$('#spn_card_errors').html(err_msg);
				}
				else
				{
					_cur_payment_method_id =  result.data.id;

					RESERVATION.attach_payment_intent();
				}


			}
		});

		xhr.open("POST", "https://api.paymongo.com/v1/payment_methods");
		xhr.setRequestHeader("content-type", "application/json");
		xhr.setRequestHeader("authorization", "Basic c2tfdGVzdF9jekcxWFRLTm5SOHQ3YlhrU2d5cFg3M3c6");

		xhr.send(data);
	}

	_this.attach_payment_intent = () =>
	{
		var data = "{\"data\":{\"attributes\":{\"payment_method\":\""+_cur_payment_method_id+"\"}}}";

		var xhr = new XMLHttpRequest();

		xhr.addEventListener("readystatechange", function () {
			if (this.readyState === this.DONE) {
				console.log(this.responseText);
				let result = JSON.parse(this.responseText);
				let err_msg = '';
				if(result.errors)
				{
					result.errors.forEach((err)=>{
						err_msg+=`<li>${err.detail}</li>`;
					});
					$('#spn_card_errors').html(err_msg);
				}
				else
				{
					let id 		= _cur_id;
					let amount 	= _cur_amount;

					$.ajax({
						type:'POST',
						url:base_url+'pay-reservation',
						data:{
							id:id,
							amount:amount
						},
						dataType:'json',
						cache:false,
						success:(result) => {
							if(result == true)
							{
								iziToast.success({
									title: 'Success',
									message: 'Payment Success',
									position:'topCenter'
								});

								RESERVATION.load_my_reservation();
								$('#card_payment_modal').modal('hide');
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
				}

			}
		});

		xhr.open("POST", "https://api.paymongo.com/v1/payment_intents/"+_cur_payment_intent_id+"/attach");
		xhr.setRequestHeader("content-type", "application/json");
		xhr.setRequestHeader("authorization", "Basic c2tfdGVzdF9jekcxWFRLTm5SOHQ3YlhrU2d5cFg3M3c6");

		xhr.send(data);
	}

	_this.authorize = (id, amount) =>
	{
		_cur_amount = amount;
		_cur_id 	= id;
		$('#paymode_modal').modal('show');
		$('#spn_amount').html(amount);
	}	

	_this.pay = (id,amount,src_id) =>
	{	



		// _cur_amount = amount;
		// _cur_id 	= id;
		// $('#paymode_modal').modal('show');
		// $('#spn_amount').html(amount);


		
		// let src = RESERVATION.create_source();

		iziToast.show({
			theme: 'dark',
			icon: 'fa fa-question',
			message: 'Are you sure to proceed to payment?',
			position: 'center', 
			progressBarColor: 'rgb(0, 255, 184)',
			buttons: [
			['<button style="width:70px;height:30px;">Yes</button>', function (instance, toast) {



				let new_amount = amount+'00';

				var data = "{\"data\":{\"attributes\":{\"source\":{\"id\":\""+src_id+"\",\"type\":\"source\"},\"amount\":"+new_amount+",\"description\":\"dec1\",\"currency\":\"PHP\",\"statement_descriptor\":\"ecarlton\"}}}";

				var xhr = new XMLHttpRequest();

				xhr.addEventListener("readystatechange", function () {
					if (this.readyState === this.DONE) {
						console.log(JSON.parse(this.responseText));
						let result = JSON.parse(this.responseText);
						if(result.errors)
						{
							iziToast.warning({
								title: 'Unauthorized',
								message: 'Please AUTHORIZE the payment first. THANK YOU.',
								position:'topCenter'
							});
						}
						else
						{
							$.ajax({
								type:'POST',
								url:base_url+'pay-reservation',
								data:{
									id:id,
									amount:amount
								},
								dataType:'json',
								cache:false,
								success:(result) => {
									if(result == true)
									{
										iziToast.success({
											title: 'Success',
											message: 'Payment Success',
											position:'topCenter'
										});

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
						}

						

					}
				});

				xhr.open("POST", "https://api.paymongo.com/v1/payments");
				xhr.setRequestHeader("content-type", "application/json");
				xhr.setRequestHeader("authorization", "Basic c2tfdGVzdF9jekcxWFRLTm5SOHQ3YlhrU2d5cFg3M3c6");

				xhr.send(data);


				
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