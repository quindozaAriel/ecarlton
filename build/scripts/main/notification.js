$(document).ready(()=>{
	NOTIFICATION.load_list();
	NOTIFICATION.load_all_notification();
	NOTIFICATION.load_dashboard();

});


const NOTIFICATION = (() =>{
	var hidden_id = 0;

	var regForm = $('#registration_form').validate({
		debug: false,
		rules: {
			title:"required",
			content:"required",
			date:"required",
			
		},
		messages: {
			title:"Please specify title for your notification.",
			content:"Please input content.",
			date:"Please specify date."
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#registration_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'notification',
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
							message: 'Notification registered',
							position:'bottomCenter'
						});
						$('#registration_form')[0].reset();
						NOTIFICATION.clear();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Notification not registered',
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
					NOTIFICATION.load_list();
					NOTIFICATION.load_all_notification();
				}
			});
		}
	});

	var updateForm = $('#update_form').validate({
		debug: false,
		rules: {
			title:"required",
			content:"required",
			date:"required",
			
		},
		messages: {
			title:"Please specify title for your notification.",
			content:"Please input content.",
			date:"Please specify date."
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var update_data = {
				'title':$('#_title').val(),
				'content':$('#_content').val(),
				'date':$('#_date').val()
			}

			var data = {
				['_method']:'PATCH',
				['data']:update_data
			};

			$.ajax({
				type:'POST',
				url:base_url+'notification/'+hidden_id,
				dataType:'json',
				data:data,
				cache: false,
				success:(result) => {
					if(result == true)
					{
						iziToast.success({
							title: 'Success',
							message: 'Notification updated',
							position:'bottomCenter'
						});
						$('#update_form')[0].reset();
						NOTIFICATION.clear();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Notification not updated',
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
					NOTIFICATION.load_list();
					NOTIFICATION.load_all_notification();
				}
			});
		}
	});
	var ret = {};

	ret.load_list = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'notification-list',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					'<td>${key+1}</td>'
					'<td>${val['title']}</td>'
					'<td>${val['content']}</td>'
					'<td>${val['date']}</td>'
					'<td>
					<center>
					<button type="button" class="btn btn-success" title="Edit Notification" onclick="NOTIFICATION.load_info(\'${val['id']}\')"><i class="fa fa-edit"></i></button>
					<button type="button" class="btn btn-danger" title="Delete Notification" onclick="NOTIFICATION.delete(\'${val['id']}\')"><i class="fa fa-trash"></i></button>
					</center>
					</td>'
					</tr>`;
				});

				$('#notification_tbl tbody').html(tbody);
				$('#notification_tbl').DataTable();
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

	ret.load_all_notification = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'notification-all',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					'<td>${key+1}</td>'
					'<td>${val['title']}</td>'
					'<td>${val['content']}</td>'
					'<td>${val['date']}</td>'
					</tr>`;
				});
				$('#all_notif_tbl').DataTable().destroy();
				$('#all_notif_tbl tbody').html(tbody);
				$('#all_notif_tbl').DataTable();
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
			url:base_url+`notification/${id}`,
			dataType:'json',
			cache:false,
			success:(result) => {
				if(result != false)
				{
					$('#registration_form').addClass('d-none');
					$('#update_form').removeClass('d-none');

					hidden_id = id;	

					$('#_title').val(result.title);
					$('#_content').val(result.content);
					$('#_date').val(result.date);
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
			message: 'Are you sure to delete this notification?',
			position: 'center', 
			progressBarColor: 'rgb(0, 255, 184)',
			buttons: [
			['<button>Yes</button>', function (instance, toast) {
				$.ajax({
					type:'POST',
					url:base_url+'notification/'+id,
					dataType:'json',
					data:{'_method':'DELETE'},
					cache:false,
					success:(result)=>
					{
						if(result == true)
						{
							iziToast.success({
								title: 'Success',
								message: 'Notification deleted.',
								position:'bottomCenter'
							});
						}
						else if(result == false)
						{
							iziToast.warning({
								title: 'Failed',
								message: 'Notification not deleted.',
								position:'bottomCenter'
							});
						}
					},
					error:()=>
					{
						iziToast.error({
							title: 'Error',
							message: 'Error occured deleting Notification.',
							position:'bottomCenter'
						});
					},
					complete:()=>
					{
						NOTIFICATION.load_list();
						NOTIFICATION.clear();
						NOTIFICATION.load_all_notification();
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

	ret.load_dashboard = () =>
	{	
		$.ajax({
			type:'GET',
			url:base_url+'notification-per-month',
			dataType:'json',
			cache:false,
			success:(result) => {
				var data = [];
				$.each(result,(key,val)=>{
					data.push(val.count);
				});
				NOTIFICATION.dashboard(data);
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
					label: "Notification Count",
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
					data: dashboard_data
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

	return ret;

})()||{};