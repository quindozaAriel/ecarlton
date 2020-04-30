$(document).ready(()=>{
	LOGIN.animateSplashScreen();
});


const LOGIN = (()=>{

	$('#login_form').validate({
		debug: false,
		rules: {
			username:"required",
			password:"required",
		},
		messages: {
			username:"Please input username.",
			password:"Please input your password.",
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#login_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'mobile-login',
				dataType:'json',
				data:formData,
				contentType: false,
				cache:false,
				processData:false,
				success:function(result)
				{
					if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Username or Password is incorrect.',
							position:'topCenter'
						});
					}
					else
					{
						window.location.replace(base_url+'/mobile-home');
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
	});

	let _this = {};

	_this.animateSplashScreen = ()=>
	{
		
		setTimeout(()=>{$('.splash-screen').css('display','none');},2000);
	}	

	return _this;

})()||{};