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
</head>
<body>
<section class="login-block">
<div class="container" style="margin-top: 60px;">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">Forgot Password</h2>
		    <form class="login-form" id="forgot-password">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="text-uppercase">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    
                </div>

                    <div class="form-check">
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
                
            </form>
            <div class="form-group">
                <a href="login.php" data-toggle="modal" data-target="#forgotPasswordModal">Back to Login</a>
            </div>
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
$(document).ready(function () {
    $('#forgot-password').submit(function (e) {
        e.preventDefault();

        var email = $('#email').val();

        $.ajax({
            type: 'POST',
            url: 'process_forgot_password.php',
            data: { email: email },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert('Verification link sent to your email. Check your inbox.');
                } else {
                    if (response.error) {
                        alert('Error: ' + response.error);
                    } else {
                        alert('An unexpected error occurred.');
                    }
                }
            },
            error: function () {
                alert('An error occurred while processing your request.');
            }
        });
    });
});
</script>

</html>
