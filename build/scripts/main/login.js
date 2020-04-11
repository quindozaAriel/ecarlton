$(document).ready(()=>{

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
				url:base_url+'login',
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
							position:'bottomCenter'
						});
					}
					else
					{
						window.location.replace(base_url+'/admin');
					}
				},
				error:function()
				{
					iziToast.error({
						title: 'Error',
						message: 'There is problem while logging you in.',
						position:'bottomCenter'
					});
				},
				complete:() => {

				}
			});
		}
	});

})()||{}
