$(document).ready(() => {
	RESBILL.load_bills_list();
	RESBILL.load_residents();
	RESBILL.load_residents_id();
});

const RESBILL =
(() => {
	$("#add_bill_form").validate({
		debug: false,
		rules: {
			resident_id: "required",
			description: "required",
			amount: {
				required: true,
				number: true,
			},
			type: "required",
			due_date: "required",
			due_day: "required",
		},
		messages: {
			resident_id: "Please choose resident",
			description: "Description required",
			amount: {
				required: "Please input amount",
				number: "Please input valid number",
			},
			type: "Select Bill Type",
			due_date: "Please choose date",
			due_day: "Please choose date",
		},
		submitHandler: (form, event) => {
			event.preventDefault();
			var formData = new FormData($("#add_bill_form")[0]);
			$.ajax({
				type: "POST",
				url: base_url + "resident-bill",
				data: formData,
				dataType: "json",
				contentType: false,
				cache: false,
				processData: false,
				success: (result) => {
					if (result == true) {
						iziToast.success({
							title: "Success",
							message: "Bills added",
							position: "bottomCenter",
						});
						RESBILL.reset_form();
						RESBILL.load_bills_list();
					} else if (result == false) {
						iziToast.warning({
							title: "Invalid",
							message: "Bills not added",
							position: "bottomCenter",
						});
					}
				},
				error: () => {
					iziToast.error({
						title: "Error",
						message: "Unexpected error occured",
						position: "bottomCenter",
					});
				},
				complete: () => {},
			});
		},
		highlight: (element) => {
			$(element).removeClass("valid-input");
			$(element).addClass("invalid-input");
		},
		unhighlight: (element) => {
			$(element).removeClass("invalid-input");
			$(element).addClass("valid-input");
		},
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
				url:base_url+'monthly-payment-spec',
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
	ret.load_bills_list = () => {
		$.ajax({
			type: "GET",
			url: base_url + "resident-bill",
			dataType: "json",
			cache: false,
			success: (result) => {
				var tbody = "";
				var ctr = 1;
				$.each(result, (key, val) => {
					var dued = "";

					if (val["type"] == "MONTHLY") {
						dued = `Every <b>${val["due_date"]}</b> of the Month`;
					} else if (val["type"] == "OCCASIONAL") {
						dued = `On <b>${val["due_date"]}</b>`;
					}

					tbody += `<tr>
					<td>${ctr}</td>
					<td>${val["first_name"]} ${val["last_name"]}</td>
					<td>${val["description"]}</td>
					<td>${val["amount"]}</td>
					<td>${val["type"]}</td>
					<td>${dued}</td>
					<td>
					<center>
					<button type="button" class="btn btn-success" title="Update Bill" onclick="RESBILL.load_bill(\'${val["id"]}\')"><i class="fa fa-edit"></i></button>
					<button type="button" class="btn btn-danger" title="Delete Bill" onclick="RESBILL.delete(\'${val["id"]}\')"><i class="fa fa-trash"></i></button>
					</center>
					</td>
					</tr>`;
					ctr++;
				});

				$("#bills_table tbody").html(tbody);
				$("#bills_table").DataTable();
				$('input[type="search"]').addClass("form-control");
			},
			error: () => {},
			complete: () => {},
		});
	};

	ret.load_residents = () => {
		$.ajax({
			type: "GET",
			url: base_url + "resident-list",
			dataType: "json",
			cache: false,
			success: (result) => {
				var option = "";

				$.each(result, (key, val) => {
					option += `<option value="${val.id}">${val.first_name} ${val.last_name}</option>`;
				});

				$("#resident_id").html(option);
				$("#resident_id").select2();
			},
			error: () => {},
			complete: () => {},
		});
	};

	ret.load_bill = (id) => {
		$.ajax({
			type: "GET",
			url: base_url + "resident-bill-spec/" + id,
			dataType: "json",
			cache: false,
			success: (result) => {
				$("#resident_id").val(`${result.resident_id}`).change();
				$("#resident_id").prop("disabled", true);
				$("#description").val(`${result.description}`);
				$("#amount").val(`${result.amount}`);
				$("#type").val(`${result.type}`);
				$("#hidden_id").val(`${result.id}`);
				if (result.type == "monthly") {
					$("#due_day").removeClass("d-none");
					$("#due_day").prop("disabled", false);

					$("#due_date").prop("disabled", true);
					$("#due_date").addClass("d-none");

					$("#due_day").val(`${result.due_date}`);
				} else if (result.type == "occasional") {
					$("#due_date").removeClass("d-none");
					$("#due_date").prop("disabled", false);

					$("#due_day").prop("disabled", true);
					$("#due_day").addClass("d-none");

					$("#due_date").val(`${result.due_date}`);
				}

				$("#edit_btn").removeClass("d-none");
				$("#save_btn").addClass("d-none");
			},
			error: () => {},
			complete: () => {},
		});
	};

	ret.delete = (id) => {
		iziToast.show({
			theme: "dark",
			icon: "fa fa-question",
			message: "Are you sure to delete this data?",
			position: "center",
			progressBarColor: "rgb(0, 255, 184)",
			buttons: [
			[
			"<button>Yes</button>",
			function (instance, toast) {
				$.ajax({
					type: "POST",
					url: base_url + "resident-bill/" + id,
					dataType: "json",
					data: { _method: "DELETE" },
					cache: false,
					success: (result) => {
						if (result == true) {
							iziToast.success({
								title: "Success",
								message: "Bills deleted.",
								position: "bottomCenter",
							});
						} else if (result == false) {
							iziToast.warning({
								title: "Failed",
								message: "Bills not deleted.",
								position: "bottomCenter",
							});
						}
					},
					error: () => {
						iziToast.error({
							title: "Error",
							message: "Error occured while deleting data.",
							position: "bottomCenter",
						});
					},
					complete: () => {
						RESBILL.load_bills_list();
					},
				});
				instance.hide(
				{
					transitionOut: "fadeOutUp",
				},
				toast,
				"buttonName"
				);
			},
			true,
			],
			[
			"<button>No</button>",
			function (instance, toast) {
				instance.hide(
				{
					transitionOut: "fadeOutUp",
				},
				toast,
				"buttonName"
				);
			},
			],
			],
		});
	};

	ret.update = () => {
		iziToast.show({
			theme: "dark",
			icon: "fa fa-question",
			message: "Are you sure to update this data?",
			position: "center",
			progressBarColor: "rgb(0, 255, 184)",
			buttons: [
			[
			"<button>Yes</button>",
			function (instance, toast) {
				var id = $("#hidden_id").val();
				var due_date = "";
				if ($("#type").val() == "monthly") {
					due_date = $("#due_day").val();
				} else if ($("#type").val() == "occasional") {
					due_date = $("#due_date").val();
				}

				datas = {
					description: $("#description").val(),
					amount: $("#amount").val(),
					type: $("#type").val(),
					due_date: due_date
				};
				$.ajax({
					type: "POST",
					url: base_url + "resident-bill/" + id,
					dataType: "json",
					data: { _method: "PATCH", datas: datas },
					cache: false,
					success: (result) => {
						if (result == true) {
							iziToast.success({
								title: "Success",
								message: "Information updated.",
								position: "bottomCenter",
							});
						} else if (result == false) {
							iziToast.warning({
								title: "Failed",
								message: "Information not updated.",
								position: "bottomCenter",
							});
						}
					},
					error: () => {
						iziToast.error({
							title: "Error",
							message: "Error occured while updating data.",
							position: "bottomCenter",
						});
					},
					complete: () => {
						RESBILL.load_bills_list();
					},
				});
				instance.hide(
				{
					transitionOut: "fadeOutUp",
				},
				toast,
				"buttonName"
				);
			},
			true,
			],
			[
			"<button>No</button>",
			function (instance, toast) {
				instance.hide(
				{
					transitionOut: "fadeOutUp",
				},
				toast,
				"buttonName"
				);
			},
			],
			],
		});
	};

	ret.display_duesec = (bill_type) => {
		if (bill_type == "MONTHLY") {
			$("#due_day").removeClass("d-none");
			$("#due_day").prop("disabled", false);

			$("#due_date").prop("disabled", true);
			$("#due_date").addClass("d-none");
		} else if (bill_type == "OCCASIONAL") {
			$("#due_date").removeClass("d-none");
			$("#due_date").prop("disabled", false);

			$("#due_day").prop("disabled", true);
			$("#due_day").addClass("d-none");
		}
	};

	ret.reset_form = () => {
		$("#add_bill_form")[0].reset();
		$("#due_day").prop("disabled", true);
		$("#due_day").addClass("d-none");
		$("#due_date").prop("disabled", true);
		$("#due_date").addClass("d-none");
		$("#resident_id").prop("disabled", false);

		$("#save_btn").removeClass("d-none");
		$("#edit_btn").addClass("d-none");
		$("#hidden_id").val("");
	};
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
				RESBILL.load_bills_id();
			}
		})
	}

	ret.load_bills_id = ()=>
	{
		var resident_id = $('#resident_id').val();

		$.ajax({
			type:"GET",
			url:`get-bill/${resident_id}`,
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

		var exist_check = RESBILL.check_arr(current_bills,bill_id);

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
				'resident_bill_id':bill_id,
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
				url:`resident_manual_payment`,
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

	ret.reset_manual_payment = () =>
	{
		$('#manual_payment_form')[0].reset();
		$('#bills_details tbody').html('');
		$('#span_total').html('₱ 0');
		current_bills = [];
	}


	return ret;
})() || {};
