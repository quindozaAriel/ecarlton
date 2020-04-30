<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url('src/plugins/izitoast/dist/css/iziToast.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('build/styles/mobile/login.css')?>">
</head>
<body>
	<div class="container-fluid h-100">
		<div class="row justify-content-center  splash-screen p-0 m-0">
			<div class="my-auto">
				<center>
					<img src="<?php echo base_url('build/images/carlton.png')?>" class="splash-logo" style="position:relative;" width="250px">
					<br>
					<div class="loader">Loading...</div>
				</center>
			</div>

		</div>
		<div class="row justify-content-center  h-100 back-ground">
			<div class="login-box my-auto">
				<center>
					<div class="col-12">
						<img src="<?php echo base_url('build/images/carlton.png')?>" class="logo mt-5">
					</div>					
					<div class="col-12">
						<p class="login-title mt-5 mb-4"><b>LOGIN</b></p>
						<form method="post" id="login_form">
							<input type="text" class="text-field mb-3" placeholder="Username" name="username" autocomplete="off">
							<input type="password" class="text-field" placeholder="Password" name="password" autocomplete="off">
							<!-- <a href="#" class="forgot-password mt-2"><u>Forgot Password?</u></a> -->

							<button type="submit" class="login-btn mt-4">LOGIN</button>
						</form>
					</div>
				</center>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('src/plugins/izitoast/dist/js/iziToast.js');?>"></script>
	<script src="<?php echo base_url('src/template/login/')?>js/main.js"></script>
	<script >const base_url = "<?php echo base_url() ?>"</script>
	<script src="<?php echo base_url('build/scripts/mobile/login.js')?>"></script>
</body>
</html>