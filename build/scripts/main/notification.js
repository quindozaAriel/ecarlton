$(document).ready(()=>{
	NOTIFICATION.load_list();
	NOTIFICATION.load_all_notification();
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
	return ret;

})()||{};