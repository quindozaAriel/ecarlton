$(document).ready(()=>{

});


const PROFILE = (()=>{

	$('#password_form').validate({
		debug: false,
		rules: {
			current_password:"required",
			new_password:{
				required:true,
				minlength: 8	
			},
			confirm_password:{
				required:true,
				equalTo:"#new_password" 
			}
		},
		messages: {
			current_password:"Please input password.",
			new_password:{
				required:"Please input password",
				minlength:"Password must atleast 8 characters."
			},
			confirm_password:{
				required:"Please input password",
				equalTo: "Your password does not match."
			}
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var user_id = $('#user_id').val();
			var update_data = {
				'current_password':$('#current_password').val(),
				'new_password':$('#new_password').val(),
			}

			var data = {
				['_method']:'PATCH',
				['data']:update_data
			};

			$.ajax({
				type:'POST',
				url:base_url+'mobile-profile-change-password/'+user_id,
				dataType:'json',
				data:data,
				cache: false,
				success:(result) => {
					if(result == true)
					{
						iziToast.success({
							title: 'Success',
							message: 'Successfully updated',
							position:'topCenter'
						});
						$('#password_form')[0].reset();
						$('#password_modal').modal('hide');
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Not updated',
							position:'topCenter'
						});
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
	});

	$('#image_form').validate({
		debug: false,
		rules: {
			image:"required"
		},
		messages: {
			image:"Please select image to upload"
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#image_form')[0]);	
			var user_id = $('#user_id').val();
			formData.append('id',user_id);
			$.ajax({
				type:'POST',
				url:base_url+'mobile-profile-change-image',
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
							message: 'Image updated',
							position:'topCenter'
						});
						window.location.reload();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Image not updated',
							position:'topCenter'
						});
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
		},highlight:(element) => {
			$(element).removeClass('valid-input');
			$(element).addClass('invalid-input');
		},
		unhighlight:(element) => {
			$(element).removeClass('invalid-input');
			$(element).addClass('valid-input');
		}
	});


	let _this = {};
	return _this;

})()||{};