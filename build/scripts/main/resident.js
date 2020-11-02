$(document).ready(()=>{
	RESIDENT.load_list();
	RESIDENT.load_residence();
});


const RESIDENT = (() =>{
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
			image:"required",
			phase_no:"required",
			lot_no:"required",
			block_no:"required"
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
			image:"Please select image to upload",
			phase_no:"required",
			lot_no:"required",
			block_no:"required"
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var formData = new FormData($('#registration_form')[0]);	
			$.ajax({
				type:'POST',
				url:base_url+'resident',
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
						RESIDENT.clear();
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
					RESIDENT.load_list();
				}
			});
		}
	});

	var updateForm = $('#update_form').validate({
		debug: false,
		rules: {
			first_name:"required",
			middle_name:"required",
			last_name:"required",
			contact_number:{
				required:true,
				number:true,
				minlength:11,
				maxlength:11
			}
		},
		messages: {
			first_name:"Please specify your first name.",
			middle_name:"Please specify your middle name.",
			last_name:"Please specify your last name.",
			contact_number:{
				required:"Please input your contact number.",
				number:"Number only",
				minlength:"Maximum of 11 character. Ex:09999999999",
				maxlength:"Maximum of 11 character. Ex:09999999999",
			}
		},	
		submitHandler:(form, event) => { 
			event.preventDefault();
			var update_data = {
				'first_name':$('#_first_name').val(),
				'middle_name':$('#_middle_name').val(),
				'last_name':$('#_last_name').val(),
				'contact_number':$('#_contact_number').val(),
			}

			var data = {
				['_method']:'PATCH',
				['data']:update_data
			};

			$.ajax({
				type:'POST',
				url:base_url+'resident/'+hidden_id,
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
						RESIDENT.clear();
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
					RESIDENT.load_list();
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

	var ret = {};

	ret.load_list = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'resident-list',
			dataType:'json',
			cache:false,
			success:(result) => {
				var tbody = "";

				$.each(result,(key,val)=>{
					tbody += `<tr>
					'<td>${key+1}</td>'
					'<td>${val['first_name']}  ${val['last_name']}</td>'
					'<td>${val['contact_number']}</td>'
					'<td>${val['email']}</td>'
					'<td>${val['username']}</td>'
					'<td>PHASE: ${val['phase_no']} LOT: ${val['lot_no']} BLOCK: ${val['block_no']} </td>'
					'<td>
					<button type="button" class="btn btn-info" onclick="RESIDENT.load_info(\'${val['id']}\')"><i class="fa fa-edit"></i></button>
					</td>'
					</tr>`;
				});

				$('#resident_tbl tbody').html(tbody);
				$('#resident_tbl').DataTable();
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
			url:base_url+`resident/${id}`,
			dataType:'json',
			cache:false,
			success:(result) => {
				if(result != false)
				{
					$('#registration_form').addClass('d-none');
					$('#update_form').removeClass('d-none');
					$('#changeBTN').removeClass('d-none');
					hidden_id = id;	
					$('#image').prop('src',base_url+`uploads/resident/${result.image}`);
					$('#_first_name').val(result.first_name);
					$('#_middle_name').val(result.middle_name);
					$('#_last_name').val(result.last_name);
					$('#_email').val(result.email);
					$('#_contact_number').val(result.contact_number);
					$('#_username').val(result.username);
					$('#user_id').val(result.id);
					// $('#_phase_no').val(result.phase_no);
					// $('#_lot_no').val(result.lot_no);
					// $('#_block_no').val(result.block_no);
					RESIDENT._load_residence();
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
				// updateForm.resetForm();
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
					url:base_url+'resident/'+hidden_id,
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
						RESIDENT.load_list();
						RESIDENT.clear();
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
		// $('#update_form')[0].reset();
		$('#image').prop('src',base_url+`build/images/avatar.png`);
		$('#registration_form').removeClass('d-none');
		hidden_id = 0;
		// regForm.resetForm();
		// updateForm.resetForm();
		$('#update_form').addClass('d-none');
		$('#registration_form').removeClass('d-none');
		$('#lot_no').html('');
		$('#block_no').html('');
		$('#lot_no').prop('disabled',true);
		$('#block_no').prop('disabled',true);

		$('#_lot_no').html('');
		$('#_block_no').html('');
		$('#_lot_no').prop('disabled',true);
		$('#_block_no').prop('disabled',true);
		$('#changeBTN').addClass('d-none');
		$('#user_id').val('');
	}	

	ret.load_residence = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'load-phase',
			dataType:'json',
			cache:false,
			success:(result) => {
				

				var html = "";
				$.each(result,(key,val)=>{
					html += `<option value="${val['id']}">${val['phase']}</option>`
				});
				$('#phase_no').html(html);
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

	ret.load_lot = () =>
	{
		var phase_id = $('#phase_no').val();
		$.ajax({
			type:'GET',
			url:base_url+'load-lot/'+phase_id,
			dataType:'json',
			cache:false,
			success:(result) => {
				$('#lot_no').prop('disabled',false);

				var html = "";
				$.each(result,(key,val)=>{
					html += `<option value="${val['id']}">${val['lot']}</option>`
				});
				$('#lot_no').html(html);
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

	ret.load_block = () =>
	{
		var lot_id = $('#lot_no').val();
		$.ajax({
			type:'GET',
			url:base_url+'load-block/'+lot_id,
			dataType:'json',
			cache:false,
			success:(result) => {
				$('#block_no').prop('disabled',false);

				var html = "";
				var ctr = parseInt(result['block_count']);
				var i;

				for(i = 1;i <= ctr;i++)
				{
					html += `<option value="${i}">${i}</option>`;
				}
				$('#block_no').html(html);
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

	ret._load_residence = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'load-phase',
			dataType:'json',
			cache:false,
			success:(result) => {
				

				var html = "";
				$.each(result,(key,val)=>{
					html += `<option value="${val['id']}">${val['phase']}</option>`
				});
				$('#_phase_no').html(html);
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

	ret._load_lot = () =>
	{
		var phase_id = $('#_phase_no').val();
		$.ajax({
			type:'GET',
			url:base_url+'load-lot/'+phase_id,
			dataType:'json',
			cache:false,
			success:(result) => {
				$('#_lot_no').prop('disabled',false);

				var html = "";
				$.each(result,(key,val)=>{
					html += `<option value="${val['id']}">${val['lot']}</option>`
				});
				$('#_lot_no').html(html);
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

	ret._load_block = () =>
	{
		var lot_id = $('#_lot_no').val();
		$.ajax({
			type:'GET',
			url:base_url+'load-block/'+lot_id,
			dataType:'json',
			cache:false,
			success:(result) => {
				$('#_block_no').prop('disabled',false);

				var html = "";
				var ctr = parseInt(result['block_count']);
				var i;

				for(i = 1;i <= ctr;i++)
				{
					html += `<option value="${i}">${i}</option>`;
				}
				$('#_block_no').html(html);
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

	return ret;

})()||{};