$(document).ready(()=>{
	LOGIN.animateSplashScreen();
});


const LOGIN = (()=>{
	let _this = {};

	_this.animateSplashScreen = ()=>
	{
		
		setTimeout(()=>{$('.splash-screen').css('display','none');},2000);
	}

	return _this;

})()||{};