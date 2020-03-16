$(document).ready(()=>{
	NOTIFICATION.load_notifications();
	setInterval(()=>{
		NOTIFICATION.load_notifications()
	},5000);
});



const NOTIFICATION = (()=>{

	let _this = {};
	var last_notif_id= 0;
	_this.load_notifications = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'realtime-notification',
			dataType:'json',
			cache:false,
			success:(result) => {

				if(last_notif_id != 0)
				{
					if(result['last_notification'] != last_notif_id)
					{
						iziToast.success({
							title: 'Alert',
							message: 'New Notification Received',
							position:'topCenter'
						});
					}
				}
				last_notif_id = result['last_notification'];
				
				var data = "";
				$.each(result['notifications'],(key,val)=>
				{
					data += `<div class="col-12 mb-3">
					<hr class="mt-1">
					<label class="">${val.date}</label>
					<h6>${val.title}</h6>
					<p class="description">${val.content}</p>
					<button class="btn btn-default p-2" onclick="NOTIFICATION.view_details(\'${val.id}\')"> Read More</button>
					<hr class="mt-1">
					</div>`;
				});	
				$('#notification_container').html(data);
				
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

	_this.view_details = (id) =>
	{
		$.ajax({
			type:'GET',
			url:base_url+`notification/${id}`,
			dataType:'json',
			cache:false,
			success:(result) => {
				if(result != false)
				{
					$('#notification_modal').modal('show');


					$('#label_date').text(result.date);
					$('#label_title').text(result.title);
					$('#label_description').text(result.content);
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

	return _this;

})()||{};

