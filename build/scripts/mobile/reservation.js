$(document).ready(()=>{
	RESERVATION.load_amenities();

});

var array = ["2020-03-14","2020-03-15","2020-03-16"]

$('.datepicker').datepicker({
	beforeShowDay: function(date){
		var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		return [ array.indexOf(string) == -1 ]
	}
});


const RESERVATION = (()=>{

	let _this = {};

	_this.load_amenities = ()=>
	{
		$.ajax({
			type:'GET',
			url:base_url+'amenities-list',
			dataType:'json',
			cache:false,
			success:(result) => {
				var option = "<option value='' selected></option>";

				$.each(result,(key,val)=>{
					option += `<option value="${val['id']}">${val['description']}</option>`;

				});

				$('#amenities').html(option);
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

	_this.load_amenities_information = () =>
	{
		var id = $('#amenities').val();
		$.ajax({
			type:'GET',
			url:base_url+`amenities/${id}`,
			dataType:'json',
			cache:false,
			success:(result) => {
				if(result != false)
				{
					$('#available_qty').val(result.available_qty);
					$('#amount').val(`₱ ${result.amount}`);
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

