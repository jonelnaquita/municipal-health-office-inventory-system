<style>
  
  
	.logo {
    margin: auto;
    font-size: 20px;
    background: url(assets/img/mho.png);
    padding: 25px 25px;
    border-radius: 50% 50%;
    color: #ff0707fc;
    background-repeat: no-repeat;
    background-size: 50px;
    background-blend-mode: darken;
}
.bg-primary {
  background: linear-gradient(45deg, #5b93d5, #5b93d5);
    border-bottom-style: double;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark  fixed-top bg-primary" style="padding:0;">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12">
  		<div class="col-md-1 float-left" style="display: flex;">
  			<div class="logo">
  			
  			</div>
  		</div>
      <div class="col-md-4 float-left text-white">
        <large><b>Municipal Health Office Inventory System</b></large>
      </div>
      <div class="float-right">
  	  	<div class=" dropdown mr-4">
            <a href="#" class="text-white dropdown-toggle"  id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?> </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -5.5em;">
              <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
              <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
            </div>
      </div>
    </div>
  </div>
  </div>
  
</nav>
<script>
  $('#manage_my_account').click(function(){
    uni_modal("Manage Account","manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
</script>