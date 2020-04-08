$(document).ready(()=>{
	HOME.check_notification();
	setInterval(()=>{
		HOME.check_notification();
	},5000);
});



const HOME = (()=>{

	let _this = {};

	var last_notification_id = 0;
	_this.check_notification = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'check-notification',
			dataType:'json',
			cache:false,
			success:(result) =>
			{
				if(result != null && result != "")
				{
					if(last_notification_id != 0)
					{
						if(result['last_notification'] != last_notification_id)
						{
							iziToast.success({
								title: 'Alert',
								message: 'New Notification Received',
								position:'topCenter'
							});
						}
					}

					last_notification_id = result['last_notification'];

					var notif_count = result['notifications'].length;

					$('#span_notif').html(notif_count);
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
	return _this;

})()||{};