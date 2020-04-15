$(document).ready(()=>{
	HOME.check_notification();
	HOME.check_bills();
	HOME.check_reservation();
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

					var notif_count = result['notifications'].length;

					if(notif_count != 0)
					{
						$('#span_notif').html(notif_count);

						
						if(last_notification_id == 0)
						{
							iziToast.show({
								theme: 'dark',
								title: 'Information',
								message: `You have ${notif_count} notifications`,
								position:'topCenter'
							});
						}

					}


					last_notification_id = result['last_notification'];
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

	_this.check_bills = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'check-bills',
			dataType:'json',
			cache:false,
			success:(result) =>
			{
				if(result != null && result != "")
				{

					var notif_count = result.length;

					if(notif_count != 0)
					{
						$('#span_bills').html(notif_count);
						iziToast.show({
							theme: 'dark',
							title: 'Information',
							message: `You have ${notif_count} available bill.`,
							position:'topCenter'
						});
					}
					



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

	_this.check_reservation = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'check-reservation',
			dataType:'json',
			cache:false,
			success:(result) =>
			{
				if(result != null && result != "")
				{
					
					var notif_count = parseInt(result[0]['PENDING']) + parseInt(result[1]['APPROVED'])  + parseInt(result[3]['PAID']);

					if(notif_count != 0)
					{
						$('#span_reservation').html(notif_count);

						iziToast.show({
							theme: 'dark',
							title: 'Information',
							message: `You have ${notif_count} reservation.`,
							position:'topCenter'
						});
					}
					




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