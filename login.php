<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Municipal Health Office Inventory System</title>
 	

<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 

if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
?>

</head>
<style>
.alert {
  position: relative;
  padding: .25rem .25rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: 0.25rem;
}
	#sign-in a. {
		
		font-size: .97em;
		right: 16px;
	}
	body{
		
		margin:0;
		background: url(assets/img/mho-2.jpg);
		background-repeat: no-repeat;
		background-size: cover;
		padding: 4%;
		
	    /*background: #007bff;*/
	}
	label {
  display: inline-block;
  margin-bottom: 0.5rem;
  font-weight: 700;
}
</style>

<body>		
	<form id="login-form" style="display: block;
							margin-top: 1em;
							padding-right: 150px;
							padding-left: 800px;
							padding-top: 260px;" >
		<div class="form-group">
			<label for="username" class="control-label">Username</label>
			<input type="text" id="username" name="username" class="form-control">
		</div>
		<div class="form-group">
			<label for="password" class="control-label">Password</label>
			<input type="password" id="password" name="password" class="form-control">
		</div>
		
		<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary" type="submit">Login</button></center>
	</form>
  </main>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else if(resp == 2){
					location.href ='voting.php';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>