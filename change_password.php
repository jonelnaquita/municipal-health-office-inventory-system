<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipal Health Office Inventory System</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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
<body>
<section class="login-block">
<div class="container" style="margin-top: 60px;">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">Login</h2>
		    <form class="login-form" id="reset-form">
                <div class="form-group">
                    <label for="new-password" class="text-uppercase">New Password</label>
                    <input type="password" class="form-control" id="new-password" name="new-password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="confirm-password" class="text-uppercase">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
                </div>
                <div class="form-check">
                    <button type="button" class="btn btn-primary float-right" onclick="resetPassword()">Submit</button>
                </div>
            </form>


		</div>
		<div class="col-md-8 banner-sec">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                <img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="banner-text">
                        <h2>Municipal Health Office Inventory System</h2>
                    </div>	
                    </div>
                </div>
            </div>	   
		    
		</div>
	</div>
</div>
</section>
</body>

<script>
    function resetPassword() {
        var newPassword = $('#new-password').val();
        var confirmPassword = $('#confirm-password').val();
        var resetCode = '<?php echo isset($_GET['reset']) ? urldecode($_GET['reset']) : ''; ?>'; // URL-decode the reset code

        if (newPassword === confirmPassword) {
            $.ajax({
                type: 'POST',
                url: 'process_change_password.php',
                data: {
                    newPassword: newPassword,
                    confirmPassword: confirmPassword,
                    resetCode: resetCode
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Password successfully reset. You can now login with your new password.');
                        window.location.href = 'index.php'; // Redirect to the login page or any other page
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function () {
                    alert('An error occurred while processing your request.');
                }
            });
        } else {
            alert('New Password and Confirm Password do not match.');
        }
    }
</script>



</html>
