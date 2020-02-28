$(document).ready(()=>{

});

const MONTHLY = (()=>{
	
	
	$('#registration_form').validate({
		debug: false,
		rules: {
			description:"required",
			amount:"required",
			type:"required"
		},
		messages: {
			description:"Please specify your first name.",
			amount:"Please specify your middle name.",
			type:"Please specify your last name."
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#registration_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'monthly',
				data:formData,
				dataType:'json',
				contentType: false,
				cache:false,
				processData:false,
				success:(result) => {
					console.log(result);
					// if(result == true)
					// {
					// 	iziToast.success({
					// 		title: 'Success',
					// 		message: 'Bills added',
					// 		position:'bottomCenter'
					// 	});
					// 	$('#registration_form')[0].reset();
					// }
					// else if(result == false)
					// {
					// 	iziToast.warning({
					// 		title: 'Invalid',
					// 		message: 'Bills not added',
					// 		position:'bottomCenter'
					// 	});
					// }
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
		},highlight:(element) => {
			$(element).removeClass('valid-input');
			$(element).addClass('invalid-input');
		},
		unhighlight:(element) => {
			$(element).removeClass('invalid-input');
			$(element).addClass('valid-input');
		}
	});


	var ret = {};

	ret.change_type = (value) =>
	{
		if(value == "MONTHLY")
		{
			$('#due_date').addClass('d-none');
			$('#due_day').removeClass('d-none');
		}
		else if(value == "ONCE")
		{
			$('#due_day').addClass('d-none');
			$('#due_date').removeClass('d-none');
		}
	}

	return ret;

})()||{};