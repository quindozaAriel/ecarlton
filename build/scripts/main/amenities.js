$(document).ready(() => {
	AMENITY.load_amenities();
	AMENITY.load_reservation_history();
	AMENITY.load_reservation_request();
	AMENITY.load_pending_reservation();
	AMENITY.load_dashboard();
	AMENITY.load_graph_sales();
	AMENITY.load_forpayment_reservation();
	AMENITY.load_reserved_reservation();
	
});

const AMENITY =
	(() => {
		var hidden_id = 0;

		var regForm = $("#registration_form").validate({
			debug: false,
			rules: {
				amenity: "required",
				quantity: {
					required: true,
					number: true,
				},
				amount: {
					required: true,
					number: true,
				},
			},
			messages: {
				amenity: "Please specify amenity.",
				quantity: {
					required: "Please input quantity",
					number: "Number only.",
				},
				amount: {
					required: "Please input quantity",
					number: "Number only.",
				},
			},
			submitHandler: (form, event) => {
				event.preventDefault();
				var formData = new FormData($("#registration_form")[0]);
				$.ajax({
					type: "POST",
					url: base_url + "amenities",
					data: formData,
					dataType: "json",
					contentType: false,
					cache: false,
					processData: false,
					success: (result) => {
						if (result == true) {
							iziToast.success({
								title: "Success",
								message: "Amenity registered",
								position: "bottomCenter",
							});
							$("#registration_form")[0].reset();
							AMENITY.clear();
						} else if (result == false) {
							iziToast.warning({
								title: "Invalid",
								message: "Amenity not registered",
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
					complete: () => {
						AMENITY.load_amenities();
					},
				});
			},
		});

		var updateForm = $("#update_form").validate({
			debug: false,
			rules: {
				_description: "required",
				_quantity: {
					required: true,
					number: true,
				},
				_available_qty: {
					required: true,
					number: true,
				},
				_amount: {
					required: true,
					number: true,
				},
			},
			messages: {
				_description: "Please specify amenity.",
				_quantity: {
					required: "Please input quantity",
					number: "Number only.",
				},
				_available_qty: {
					required: "Please input quantity",
					number: "Number only.",
				},
				_amount: {
					required: "Please input quantity",
					number: "Number only.",
				},
			},
			submitHandler: (form, event) => {
				event.preventDefault();
				var update_data = {
					description: $("#_description").val(),
					quantity: $("#_quantity").val(),
					available_qty: $("#_available_qty").val(),
					amount: $("#_amount").val(),
				};

				var data = {
					["_method"]: "PATCH",
					["data"]: update_data,
				};

				$.ajax({
					type: "POST",
					url: base_url + "amenities/" + hidden_id,
					dataType: "json",
					data: data,
					cache: false,
					success: (result) => {
						if (result == true) {
							iziToast.success({
								title: "Success",
								message: "Amenities updated",
								position: "bottomCenter",
							});
							$("#update_form")[0].reset();
							AMENITY.clear();
						} else if (result == false) {
							iziToast.warning({
								title: "Invalid",
								message: "Amenities not updated",
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
					complete: () => {
						AMENITY.load_amenities();
					},
				});
			},
		});
		var ret = {};

		ret.function_loader = () => {
			AMENITY.load_dashboard();
			AMENITY.load_graph_sales();
			AMENITY.load_reservation_request();
			AMENITY.load_pending_reservation();
			AMENITY.load_forpayment_reservation();
			AMENITY.load_reservation_history();
			AMENITY.load_reserved_reservation();
		};

		ret.load_amenities = () => {
			$.ajax({
				type: "GET",
				url: base_url + "amenities-list",
				dataType: "json",
				cache: false,
				success: (result) => {
					var tbody = "";

					$.each(result, (key, val) => {
						tbody += `<tr>
					<td>${key + 1}</td>
					<td>${val["description"]}</td>
					<td>${val["quantity"]}</td>
					<td>${val["available_qty"]}</td>
					<td>₱ ${val["amount"]}</td>
					<td>
					<button type="button" class="btn btn-success" title="Edit Amenities" onclick="AMENITY.load_info(\'${
						val["id"]
					}\')"><i class="fa fa-edit"></i></button>
					<button type="button" class="btn btn-danger" title="Delete Amenities" onclick="AMENITY.delete(\'${
						val["id"]
					}\')"><i class="fa fa-trash"></i></button>
					</td>
					</tr>`;
					});

					$("#amenities_tbl tbody").html(tbody);
					$("#amenities_tbl").DataTable();
					$('input[type="search"]').addClass("form-control");
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
		};

		ret.load_info = (id) => {
			$.ajax({
				type: "GET",
				url: base_url + `amenities/${id}`,
				dataType: "json",
				cache: false,
				success: (result) => {
					if (result != false) {
						$("#registration_form").addClass("d-none");
						$("#update_form").removeClass("d-none");

						hidden_id = id;

						$("#_description").val(result.description);
						$("#_quantity").val(result.quantity);
						$("#_available_qty").val(result.available_qty);
						$("#_amount").val(result.amount);
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
		};

		ret.delete = (id) => {
			iziToast.show({
				theme: "dark",
				icon: "fa fa-question",
				message: "Are you sure to delete this amenities?",
				position: "center",
				progressBarColor: "rgb(0, 255, 184)",
				buttons: [
					[
						"<button>Yes</button>",
						function (instance, toast) {
							$.ajax({
								type: "POST",
								url: base_url + "amenities/" + id,
								dataType: "json",
								data: { _method: "DELETE" },
								cache: false,
								success: (result) => {
									if (result == true) {
										iziToast.success({
											title: "Success",
											message: "Amenities deleted.",
											position: "bottomCenter",
										});
									} else if (result == false) {
										iziToast.warning({
											title: "Failed",
											message: "Amenities not deleted.",
											position: "bottomCenter",
										});
									}
								},
								error: () => {
									iziToast.error({
										title: "Error",
										message: "Error occured deleting amenities.",
										position: "bottomCenter",
									});
								},
								complete: () => {
									AMENITY.load_amenities();
									AMENITY.clear();
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

		ret.clear = () => {
			$("#registration_form")[0].reset();
			$("#registration_form").removeClass("d-none");
			hidden_id = 0;
			$("#update_form").addClass("d-none");
		};

		ret.load_reservation_history = () => {
			$.ajax({
				type: "GET",
				url: base_url + "reservation-history",
				dataType: "json",
				cache: false,
				success: (result) => {
					var tbody = "";

					$.each(result, (key, val) => {
						tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>${val.payment_type}</td>
					<td>${val.status}</td>
					</tr>`;
					});

					$("#reservation_request").DataTable().destroy();
					$("#reservation_history tbody").html(tbody);
					$("#reservation_history").DataTable();
					$('input[type="search"]').addClass("form-control");
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
		};

		ret.load_reservation_request = () => {
			$.ajax({
				type: "GET",
				url: base_url + "reservation-request",
				dataType: "json",
				cache: false,
				success: (result) => {
					var tbody = "";

					$.each(result, (key, val) => {
						tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>${val.payment_type}</td>
					<td>		
					<button type="button" class="btn btn-success mb-2 p-3" onclick="AMENITY.request_action(\'${val.reservation_id}\','APPROVED',\'${val.total_amount}\')"  title="Approve Request"><i class="fa fa-check"></i> Approve</button>
					<button type="button" class="btn btn-danger mb-2" onclick="AMENITY.reject(\'${val.reservation_id}\')" title="Decline Request"><i class="fa fa-times"></i> Reject</button>
					<button type="button" class="btn btn-warning mb-2" onclick="AMENITY.reject(\'${val.reservation_id}\')" title="Decline Request"><i class="fa fa-times"></i> Reject</button>
					</td>
					</tr>`;
					});

					$("#reservation_request").DataTable().destroy();
					$("#reservation_request tbody").html(tbody);
					$("#reservation_request").DataTable();
					$('input[type="search"]').addClass("form-control");
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
		};

		ret.request_action = (reservation_id, action, amount = null) => {
			if (amount == 0) {
				action = "PAID";
			}

			$.ajax({
				type: "POST",
				url: base_url + "reservation-action/" + reservation_id + "/" + action,
				dataType: "json",
				data: { _method: "PATCH" },
				cache: false,
				success: (result) => {
					if (result == true) {
						iziToast.success({
							title: "Success",
							message: "Action Successful.",
							position: "center",
						});
					} else if (result == false) {
						iziToast.warning({
							title: "Failed",
							message: "Action not successful.",
							position: "center",
						});
					}
				},
				error: () => {
					iziToast.error({
						title: "Error",
						message: "Unexpected error occured",
						position: "center",
					});
				},
				complete: () => {
					AMENITY.function_loader();
				},
			});
		};

		ret.load_pending_reservation = () => {
			$.ajax({
				type: "GET",
				url: base_url + "reservation-pending",
				dataType: "json",
				cache: false,
				success: (result) => {
					var tbody = "";

					$.each(result, (key, val) => {
						tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>${val.payment_type}</td>
					<td>		
					<button type="button" class="btn btn-success" onclick="AMENITY.approve(\'${val.reservation_id}\')" title="Approve Request"><i class="fa fa-check"></i> Reserved</button>
					<button type="button" class="btn btn-danger mt-2"  onclick="AMENITY.request_action(\'${val.reservation_id}\','RESERVED')" title="Approve Request"> Cancel</button>
					</td>
					</tr>`;
					});

					$("#pending_reservation").DataTable().destroy();
					$("#pending_reservation tbody").html(tbody);
					$("#pending_reservation").DataTable();
					$('input[type="search"]').addClass("form-control");
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
		};

		ret.load_forpayment_reservation = () => {
			$.ajax({
				type: "GET",
				url: base_url + "reservation-for-payment",
				dataType: "json",
				cache: false,
				success: (result) => {
					var tbody = "";

					$.each(result, (key, val) => {
						tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>${val.payment_type}</td>
					<td>
					<button type="button" class="btn btn-success" onclick="AMENITY.request_action(\'${val.reservation_id}\','PAID',\'${val.total_amount}\')" title="Approve Request"><i class="fa fa-check"></i> PAID</button>		
					</td>
					</tr>`;
					});

					$("#forpayment_reservation").DataTable().destroy();
					$("#forpayment_reservation tbody").html(tbody);
					$("#forpayment_reservation").DataTable();
					$('input[type="search"]').addClass("form-control");
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
		};

		ret.load_reserved_reservation = () => {
			$.ajax({
				type: "GET",
				url: base_url + "reserved-reservation",
				dataType: "json",
				cache: false,
				success: (result) => {
					var tbody = "";

					$.each(result, (key, val) => {
						tbody += `<tr>
					<td>${val.timestamp}</td>
					<td>${val.date_from} to ${val.date_to}</td>
					<td>${val.first_name} ${val.last_name}</td>
					<td>${val.description}</td>
					<td>${val.quantity}</td>
					<td>₱ ${val.total_amount}</td>
					<td>${val.payment_type}</td>
					<td>
					<button type="button" class="btn btn-success" onclick="AMENITY.request_action(\'${val.reservation_id}\','FINISHED')" title="Finish Reservation"><i class="fa fa-check"></i></button>		
					</td>
					</tr>`;
					});

					$("#reserved_reservation").DataTable().destroy();
					$("#reserved_reservation tbody").html(tbody);
					$("#reserved_reservation").DataTable();
					$('input[type="search"]').addClass("form-control");
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
		};

		ret.load_dashboard = () => {
			$.ajax({
				type: "GET",
				url: base_url + "reservation-per-month",
				dataType: "json",
				cache: false,
				success: (result) => {
					var data = [];
					$.each(result, (key, val) => {
						data.push(val.count);
					});
					AMENITY.dashboard(data);
				},
				error: () => {
					iziToast.error({
						title: "Error",
						message: "Unexpected error occured",
						position: "topCenter",
					});
				},
				complete: () => {},
			});
		};

		ret.load_graph_sales = () => {
			$.ajax({
				type: "GET",
				url: base_url + "reservation-sales-per-month",
				dataType: "json",
				cache: false,
				success: (result) => {
					var data = [];
					$.each(result, (key, val) => {
						data.push(val.total_amount);
					});
					AMENITY.sale_chart(data);
				},
				error: () => {
					iziToast.error({
						title: "Error",
						message: "Unexpected error occured",
						position: "topCenter",
					});
				},
				complete: () => {},
			});
		};

		ret.dashboard = (dashboard_data) => {
			chartColor = "#FFFFFF";

			gradientChartOptionsConfiguration = {
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
					bodySpacing: 4,
					mode: "nearest",
					intersect: 0,
					position: "nearest",
					xPadding: 10,
					yPadding: 10,
					caretPadding: 10,
				},
				responsive: 1,
				scales: {
					yAxes: [
						{
							display: 0,
							gridLines: 0,
							ticks: {
								display: false,
							},
							gridLines: {
								zeroLineColor: "transparent",
								drawTicks: false,
								display: false,
								drawBorder: false,
							},
						},
					],
					xAxes: [
						{
							display: 0,
							gridLines: 0,
							ticks: {
								display: false,
							},
							gridLines: {
								zeroLineColor: "transparent",
								drawTicks: false,
								display: false,
								drawBorder: false,
							},
						},
					],
				},
				layout: {
					padding: {
						left: 0,
						right: 0,
						top: 15,
						bottom: 15,
					},
				},
			};

			gradientChartOptionsConfigurationWithNumbersAndGrid = {
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
					bodySpacing: 4,
					mode: "nearest",
					intersect: 0,
					position: "nearest",
					xPadding: 10,
					yPadding: 10,
					caretPadding: 10,
				},
				responsive: true,
				scales: {
					yAxes: [
						{
							gridLines: 0,
							gridLines: {
								zeroLineColor: "transparent",
								drawBorder: false,
							},
						},
					],
					xAxes: [
						{
							display: 0,
							gridLines: 0,
							ticks: {
								display: false,
							},
							gridLines: {
								zeroLineColor: "transparent",
								drawTicks: false,
								display: false,
								drawBorder: false,
							},
						},
					],
				},
				layout: {
					padding: {
						left: 0,
						right: 0,
						top: 15,
						bottom: 15,
					},
				},
			};

			var ctx = document.getElementById("bigDashboardChart").getContext("2d");

			var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
			gradientStroke.addColorStop(0, "#80b6f4");
			gradientStroke.addColorStop(1, chartColor);

			var gradientFill = ctx.createLinearGradient(0, 200, 0, 50);
			gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
			gradientFill.addColorStop(1, "rgba(255, 255, 255, 0.24)");

			var myChart = new Chart(ctx, {
				type: "line",
				data: {
					labels: [
						"JAN",
						"FEB",
						"MAR",
						"APR",
						"MAY",
						"JUN",
						"JUL",
						"AUG",
						"SEP",
						"OCT",
						"NOV",
						"DEC",
					],
					datasets: [
						{
							label: "Reservation Count",
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
							data: dashboard_data,
						},
					],
				},
				options: {
					layout: {
						padding: {
							left: 20,
							right: 20,
							top: 0,
							bottom: 0,
						},
					},
					maintainAspectRatio: false,
					tooltips: {
						backgroundColor: "#fff",
						titleFontColor: "#333",
						bodyFontColor: "#666",
						bodySpacing: 4,
						xPadding: 12,
						mode: "nearest",
						intersect: 0,
						position: "nearest",
					},
					legend: {
						position: "bottom",
						fillStyle: "#FFF",
						display: false,
					},
					scales: {
						yAxes: [
							{
								ticks: {
									fontColor: "rgba(255,255,255,0.4)",
									fontStyle: "bold",
									beginAtZero: true,
									maxTicksLimit: 5,
									padding: 10,
								},
								gridLines: {
									drawTicks: true,
									drawBorder: false,
									display: true,
									color: "rgba(255,255,255,0.1)",
									zeroLineColor: "transparent",
								},
							},
						],
						xAxes: [
							{
								gridLines: {
									zeroLineColor: "transparent",
									display: false,
								},
								ticks: {
									padding: 10,
									fontColor: "rgba(255,255,255,0.4)",
									fontStyle: "bold",
								},
							},
						],
					},
				},
			});
		};
		ret.sale_chart = (data) => {
			chartColor = "#FFFFFF";

			gradientChartOptionsConfiguration = {
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
					bodySpacing: 4,
					mode: "nearest",
					intersect: 0,
					position: "nearest",
					xPadding: 10,
					yPadding: 10,
					caretPadding: 10,
				},
				responsive: 1,
				scales: {
					yAxes: [
						{
							display: 0,
							gridLines: 0,
							ticks: {
								display: false,
							},
							gridLines: {
								zeroLineColor: "transparent",
								drawTicks: false,
								display: false,
								drawBorder: false,
							},
						},
					],
					xAxes: [
						{
							display: 0,
							gridLines: 0,
							ticks: {
								display: false,
							},
							gridLines: {
								zeroLineColor: "transparent",
								drawTicks: false,
								display: false,
								drawBorder: false,
							},
						},
					],
				},
				layout: {
					padding: {
						left: 0,
						right: 0,
						top: 15,
						bottom: 15,
					},
				},
			};

			gradientChartOptionsConfigurationWithNumbersAndGrid = {
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
					bodySpacing: 4,
					mode: "nearest",
					intersect: 0,
					position: "nearest",
					xPadding: 10,
					yPadding: 10,
					caretPadding: 10,
				},
				responsive: true,
				scales: {
					yAxes: [
						{
							gridLines: 0,
							gridLines: {
								zeroLineColor: "transparent",
								drawBorder: false,
							},
						},
					],
					xAxes: [
						{
							display: 0,
							gridLines: 0,
							ticks: {
								display: false,
							},
							gridLines: {
								zeroLineColor: "transparent",
								drawTicks: false,
								display: false,
								drawBorder: false,
							},
						},
					],
				},
				layout: {
					padding: {
						left: 0,
						right: 0,
						top: 15,
						bottom: 15,
					},
				},
			};

			var e = document
				.getElementById("barChartSimpleGradientsNumbers")
				.getContext("2d");

			gradientFill = e.createLinearGradient(0, 170, 0, 50);
			gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
			gradientFill.addColorStop(1, hexToRGB("#2CA8FF", 0.6));

			var a = {
				type: "bar",
				data: {
					labels: [
						"January",
						"February",
						"March",
						"April",
						"May",
						"June",
						"July",
						"August",
						"September",
						"October",
						"November",
						"December",
					],
					datasets: [
						{
							label: "Total Sales",
							backgroundColor: gradientFill,
							borderColor: "#2CA8FF",
							pointBorderColor: "#FFF",
							pointBackgroundColor: "#2CA8FF",
							pointBorderWidth: 2,
							pointHoverRadius: 4,
							pointHoverBorderWidth: 1,
							pointRadius: 4,
							fill: true,
							borderWidth: 1,
							data: data,
						},
					],
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
					},
					tooltips: {
						bodySpacing: 4,
						mode: "nearest",
						intersect: 0,
						position: "nearest",
						xPadding: 10,
						yPadding: 10,
						caretPadding: 10,
					},
					responsive: 1,
					scales: {
						yAxes: [
							{
								gridLines: 0,
								gridLines: {
									zeroLineColor: "transparent",
									drawBorder: false,
								},
							},
						],
						xAxes: [
							{
								display: 0,
								gridLines: 0,
								ticks: {
									display: false,
								},
								gridLines: {
									zeroLineColor: "transparent",
									drawTicks: false,
									display: false,
									drawBorder: false,
								},
							},
						],
					},
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 15,
							bottom: 15,
						},
					},
				},
			};

			var viewsChart = new Chart(e, a);
		};

		ret.reject = (reservation_id) => {
			iziToast.info({
				timeout: 60000,
				overlay: true,
				icon: " fa fa-question",
				iconColor: "white",
				displayMode: "once",
				id: "remarks",
				zindex: 999,
				title: "Remarks",
				titleColor: "White",
				titleSize: "20px",
				message: "<br>Please input your reason for rejecting reservation.",
				messageSize: "16px",
				position: "center",
				drag: false,
				maxWidth: 400,
				inputs: [
					[
						'<textarea class="d-block" style="width:300px;margin-top:15px;" id="reject_remarks">',
						"keyup",
						function (instance, toast, input, e) {
							console.info(input.value);
						},
						true,
					],
				],
				buttons: [
					[
						"<button style='color:white;font-size:14px;'>Reject</button>",
						function (instance, toast) {
							var remarks = $("#reject_remarks").val();

							$.ajax({
								type: "POST",
								url: base_url + "reject-reservation",
								dataType: "json",
								data: {
									reservation_id: reservation_id,
									remarks: remarks,
								},
								cache: false,
								success: (result) => {
									if (result == true) {
										iziToast.success({
											title: "Success",
											message: "Action Successful.",
											position: "center",
										});
									} else if (result == false) {
										iziToast.warning({
											title: "Failed",
											message: "Action not successful.",
											position: "center",
										});
									}
								},
								error: () => {
									iziToast.error({
										title: "Error",
										message: "Unexpected error occured",
										position: "center",
									});
								},
								complete: () => {
									location.reload();
								},
							});
						},
						true,
					],
				],
			});
		};

		ret.approve = (reservation_id) => {
			$.ajax({
				type: "GET",
				url: base_url + "approve-reservation/" + reservation_id,
				dataType: "json",
				cache: false,
				success: (result) => {
					if (result == true) {
						iziToast.success({
							title: "Success",
							message: "Action Successful.",
							position: "center",
						});
					} else if (result == false) {
						iziToast.warning({
							title: "Failed",
							message: "Action not successful.",
							position: "center",
						});
					}
				},
				error: () => {
					iziToast.error({
						title: "Error",
						message: "Unexpected error occured",
						position: "center",
					});
				},
				complete: () => {
					location.reload();
				},
			});
		};

		return ret;
	})() || {};
