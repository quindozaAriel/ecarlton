$(document).ready(()=>{
	BILLS.load_bills();
	BILLS.load_transaction_history();
});

const BILLS = (()=>{


	let _cur_amount = 0;
	let _cur_src_id = 0;

	$('#pay_gcash').on('click',()=>{
		BILLS.create_source();
	});

	$('#pay_via_gcash').on('click',()=>{
		BILLS.create_payment();
	});

	$('#pay_card').on('click',()=>{
		BILLS.create_payment_intent();
	});

	$('#slc_month').on('change',()=>{
		let val = $('#slc_month').val();
		$('#spn_month').html(val);
	});

	$('#slc_year').on('change',()=>{
		let val = $('#slc_year').val();
		$('#spn_year').html(val);
	});

	$('#btn_via_card').on('click',()=>{
		BILLS.create_payment_method();
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
	

	$('#payment_form').on("submit",(e)=>{
		e.preventDefault();
		// var formData = new FormData($('#payment_form')[0]);	


		let amount = 0;
		$('input[name="bills[]"]:checked').map(function(){
			val = $(this).val().split('-');
			amount+=parseInt(val[1]);
		});
		_cur_amount = amount;

		$('#paymode_modal').modal('show');
		$('#spn_1').show();
		$('#spn_2').hide();
		$('#spn_amount').html(amount);
		// BILLS.create_source();



		// iziToast.show({
		// 	theme: 'dark',
		// 	icon: 'fa fa-question',
		// 	message: 'Are you sure to proceed to payment?',
		// 	position: 'center', 
		// 	progressBarColor: 'rgb(0, 255, 184)',
		// 	buttons: [
		// 	['<button style="width:70px;height:30px;">Yes</button>', function (instance, toast) {
		// 		var formData = new FormData($('#payment_form')[0]);	
		// 		$.ajax({
		// 			type:'POST',
		// 			url:base_url+'bills',
		// 			dataType:'json',
		// 			data:formData,
		// 			contentType: false,
		// 			cache:false,
		// 			processData:false,
		// 			success:function(result)
		// 			{	
		// 				if(result == true)
		// 				{
		// 					iziToast.success({
		// 						title: 'Success',
		// 						message: 'Payment Successful.',
		// 						position:'topCenter'
		// 					});

		// 				}
		// 				else
		// 				{
		// 					iziToast.error({
		// 						title: 'Invalid',
		// 						message: 'Payment unsuccessful.',
		// 						position:'topCenter'
		// 					});
		// 				}
		// 			},
		// 			error:function()
		// 			{
		// 				iziToast.error({
		// 					title: 'Error',
		// 					message: 'Error occured.',
		// 					position:'topCenter'
		// 				});
		// 			},
		// 			complete:() => {
		// 				BILLS.load_bills();
		// 				BILLS.load_transaction_history();
		// 				$("#total_amount").html("");
		// 				$("#hidden_total_amount").val(0);
		// 			}
		// 		});
		// 		instance.hide({
		// 			transitionOut: 'fadeOutUp',
		// 		}, toast, 'buttonName');

		// 	}, true],
		// 	['<button style="width:60px;height:30px;">No</button>', function (instance, toast) {
		// 		instance.hide({
		// 			transitionOut: 'fadeOutUp',
		// 		}, toast, 'buttonName');
		// 	}]
		// 	]
		// });

		
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

	_this.pay = () =>
	{
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
				$('#paymode_modal').modal('hide');
				$('#card_payment_modal').modal('hide');
				BILLS.load_bills();
				BILLS.load_transaction_history();
				$("#total_amount").html("");
				$("#hidden_total_amount").val(0);
			}
		});

		
	}

	_this.create_payment = () =>
	{

		iziToast.show({
			theme: 'dark',
			icon: 'fa fa-question',
			message: 'Are you sure to proceed to payment?',
			position: 'center', 
			progressBarColor: 'rgb(0, 255, 184)',
			buttons: [
			['<button style="width:70px;height:30px;">Yes</button>', function (instance, toast) {


				let src_id = _cur_src_id;
				let amount = _cur_amount+'00';
				var data = "{\"data\":{\"attributes\":{\"source\":{\"id\":\""+src_id+"\",\"type\":\"source\"},\"amount\":"+amount+",\"description\":\"dec1\",\"currency\":\"PHP\",\"statement_descriptor\":\"ecarlton\"}}}";

				var xhr = new XMLHttpRequest();

				xhr.addEventListener("readystatechange", function () {
					if (this.readyState === this.DONE) {

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
							BILLS.pay();
						}			
				// console.log(this.responseText);
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

				_cur_src_id =  boom_url.data.id;


				$.ajax({
					type:'post',
					url:base_url+'create-tracker',
					data:
					{
						amount:_cur_amount,
						src_id:boom_url.data.id
					},
					cache:false,
					success:(data)=>
					{
						// $('#paymode_modal').modal('hide');
						$('#spn_1').hide();
						$('#spn_2').show();

						// window.open(boom_url.data.attributes.redirect.checkout_url);
						$('#div_iframe').html(`<center><iframe id="frame" src="${boom_url.data.attributes.redirect.checkout_url}" ></iframe></center>`);
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

					BILLS.attach_payment_intent();
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
					BILLS.pay();
					// let id 		= _cur_id;
					// let amount 	= _cur_amount;

					// $.ajax({
					// 	type:'POST',
					// 	url:base_url+'pay-reservation',
					// 	data:{
					// 		id:id,
					// 		amount:amount
					// 	},
					// 	dataType:'json',
					// 	cache:false,
					// 	success:(result) => {
					// 		if(result == true)
					// 		{
					// 			iziToast.success({
					// 				title: 'Success',
					// 				message: 'Payment Success',
					// 				position:'topCenter'
					// 			});

					// 			RESERVATION.load_my_reservation();
					// 			$('#card_payment_modal').modal('hide');
					// 		}
					// 		else if(result == false)
					// 		{
					// 			iziToast.warning({
					// 				title: 'Invalid',
					// 				message: 'Please try again.',
					// 				position:'topCenter'
					// 			});
					// 		}
					// 	},
					// 	error:() => {
					// 		iziToast.error({
					// 			title: 'Error',
					// 			message: 'Unexpected error occured',
					// 			position:'topCenter'
					// 		});
					// 	},
					// 	complete:() => {
					// 	}
					// });
				}

			}
		});

		xhr.open("POST", "https://api.paymongo.com/v1/payment_intents/"+_cur_payment_intent_id+"/attach");
		xhr.setRequestHeader("content-type", "application/json");
		xhr.setRequestHeader("authorization", "Basic c2tfdGVzdF9jekcxWFRLTm5SOHQ3YlhrU2d5cFg3M3c6");

		xhr.send(data);
	}


















	return _this;

})()||{};