$(document).ready(()=>{
	ADMIN.load_admin_list();
});


const ADMIN = (() =>{
	var hidden_id = 0;

	var regForm = $('#registration_form').validate({
		debug: false,
		rules: {
			first_name:"required",
			middle_name:"required",
			last_name:"required",
			email:{
				required:true,
				email:true
			},
			contact_number:{
				required:true,
				number:true,
				minlength:11,
				maxlength:11
			},
			username:"required",
			password: {
				required: true,
				minlength: 8	
			},
			confirm_password:{
				required:true,
				equalTo:"#password"
			},
			image:"required"
		},
		messages: {
			first_name:"Please specify your first name.",
			middle_name:"Please specify your middle name.",
			last_name:"Please specify your last name.",
			email: {
				required: "Email required.",
				email: "Your email address must be in the format of name@domain.com."
			},
			contact_number:{
				required:"Please input your contact number.",
				number:"Number only",
				minlength:"Maximum of 11 character. Ex:09999999999",
				maxlength:"Maximum of 11 character. Ex:09999999999",
			},
			username:"Username required.",
			password:{
				required:"Please input your password.",
				minlength:"Your password must atleast 8 character long.",
				nowhitespace:"Password can't contain whitespaces."
			},
			confirm_password:{
				required:"Please input password confirmation",
				equalTo: "Your password does not match."
			},
			image:"Please select image to upload"
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#registration_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'admin',
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
							message: 'Account registered',
							position:'bottomCenter'
						});
						$('#registration_form')[0].reset();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Account not registered',
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
					ADMIN.load_admin_list();
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



	var updateForm = $('#update_form').validate({
		debug: false,
		rules: {
			_first_name:"required",
			_middle_name:"required",
			_last_name:"required",
			_email:{
				required:true,
				email:true
			},
			_contact_number:{
				required:true,
				number:true,
				minlength:11,
				maxlength:11,
			},
			_password: {
				minlength: 8	
			},
			_confirm_password:{
				equalTo:"#_password"
			},
		},
		messages: {
			_first_name:"Please specify your first name.",
			_middle_name:"Please specify your middle name.",
			_last_name:"Please specify your last name.",
			_email: {
				required: "Email required.",
				email: "Your email address must be in the format of name@domain.com."
			},
			_contact_number:{
				required:"Please input your contact number.",
				number:"Number only",
				minlength:"Minimum of 11 character. Ex:09999999999",
				maxlength:"Maximum of 11 character. Ex:09999999999",
			},
			_password:{
				minlength:"Your password must atleast 8 character long.",
			},
			_confirm_password:{
				
				equalTo: "Your password does not match."
			},
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			
			var update_data = {
				'first_name':$('#_first_name').val(),
				'middle_name':$('#_middle_name').val(),
				'last_name':$('#_last_name').val(),
				'email':$('#_email').val(),
				'contact_number':$('#_contact_number').val(),
				'password':$('#_password').val(),
			}

			var data = {
				['_method']:'PATCH',
				['data']:update_data
			};

			$.ajax({
				type:'POST',
				url:base_url+'admin/'+hidden_id,
				dataType:'json',
				data:data,
				cache: false,
				success:(result) => {
					if(result == true)
					{
						iziToast.success({
							title: 'Success',
							message: 'Account updated',
							position:'bottomCenter'
						});
						$('#update_form')[0].reset();
						// ADMIN.load_admin_list();
					}
					else if(result == false)
					{
						iziToast.warning({
							title: 'Invalid',
							message: 'Account not updated',
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
					ADMIN.load_admin_list();
					ADMIN.clear();
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
	let ret = {};


	ret.load_admin_list = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'admin-list',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					'<td>${key+1}</td>'
					'<td>${val['username']}</td>'
					'<td>${val['first_name']}  ${val['last_name']}</td>'
					'<td>${val['email']}</td>'
					'<td>${val['contact_number']}</td>'
					'<td><button type="button" class="btn btn-info" onclick="ADMIN.load_info(\'${val['id']}\')"><i class="fa fa-edit"></i> Edit</button></td>'
					</tr>`;
				});

				$('#admin_tbl tbody').html(tbody);
				$('#admin_tbl').DataTable();
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
			url:base_url+`admin/${id}`,
			dataType:'json',
			cache:false,
			success:(result) => {
				if(result != false)
				{
					$('#registration_form').addClass('d-none');
					$('#update_form').removeClass('d-none');

					hidden_id = id;	
					$('#image').prop('src',base_url+`uploads/admin/${result.image}`);
					$('#_first_name').val(result.first_name);
					$('#_middle_name').val(result.middle_name);
					$('#_last_name').val(result.last_name);
					$('#_email').val(result.email);
					$('#_contact_number').val(result.contact_number);
					$('#_username').val(result.username);
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
				regForm.resetForm();
				updateForm.resetForm();
			}
		});
	}

	ret.delete = () =>
	{

		iziToast.show({
			theme: 'dark',
			icon: 'fa fa-question',
			message: 'Are you sure to delete this account?',
			position: 'center', 
			progressBarColor: 'rgb(0, 255, 184)',
			buttons: [
			['<button>Yes</button>', function (instance, toast) {
				$.ajax({
					type:'POST',
					url:base_url+'admin/'+hidden_id,
					dataType:'json',
					data:{'_method':'DELETE'},
					cache:false,
					success:(result)=>
					{
						if(result == true)
						{
							iziToast.success({
								title: 'Success',
								message: 'Account deleted.',
								position:'bottomCenter'
							});
							// ADMIN.load_admin_list();
						}
						else if(result == false)
						{
							iziToast.warning({
								title: 'Failed',
								message: 'Account not deleted.',
								position:'bottomCenter'
							});
						}
					},
					error:()=>
					{
						iziToast.error({
							title: 'Error',
							message: 'Error occured deleting account.',
							position:'bottomCenter'
						});
					},
					complete:()=>
					{
						ADMIN.load_admin_list();
						ADMIN.clear();
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
		$('#update_form')[0].reset();
		$('#image').prop('src',base_url+`build/images/avatar.png`);
		$('#registration_form').removeClass('d-none');
		hidden_id = 0;
		regForm.resetForm();
		updateForm.resetForm();
		$('#update_form').addClass('d-none');
		$('#registration_form').removeClass('d-none');

	}	

	return ret;
})()||{};