$(document).ready(()=>{
	BILLS.load_bills();
});

const BILLS = (()=>{

	let _this = {};

	_this.load_bills = () =>
	{
		$.ajax({
			type:'GET',
			url:base_url+'bills',
			dataType:'json',
			cache:false,
			success:(result)=>
			{
				var description = "";
				var amount = "";
				var total_amount = 0;

				$.each(result,(key,val)=>{

					description += `<label>${val.description}</label><br>`;
					amount += `<label>₱ ${val.amount}</label><br>`;
					total_amount = parseFloat(total_amount) + parseFloat(val.amount);
				});

				$('#description_container').html(description);
				$('#amount_container').html(amount);
				$('#total_amount').html(total_amount);
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

	_this.load_bills = () =>
	{
		
	}
	return _this;

})()||{};