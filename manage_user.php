<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}

?>
<div class="container">
	
	<form action="" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
			
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" required="">
		</div>
			<?php if(!isset($_GET['mtype'])): ?>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select" require="">
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Staff</option>
			</select>
		</div>
		<?php endif; ?>
		

		<div class="card-footer">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>

<!--<div class="form-group">
<label for="category_id">Category</label>
<select id="parentbox" name="category_id" id="category_id" class="form-control" value="<?php echo isset($meta['category_id']) ? $meta['category_id']: '' ?>" required>
<option>Select Category</option>

<?php
$sql="select * from category_list";
$result=mysqli_query($conn,$sql);

while($data=mysqli_fetch_array($result))
{?>
<option value="<?php echo $data['id']?>"><?php echo $data['name'];?></option>
<?php } ?>

</select>
</div>
<div class="form-group">
<label for="name">Sub Category</label>
<select id="childbox">
<option>Select Item</option>
</select>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>

$("#parentbox").change(function()
{
	$category=$("#parentbox").val();
	
	$.ajax({
		
		url:'data.php?action=save_list',
		method:'POST',
		data:{'category':$category},
		success:function(response)
		{
			$("#childbox").html(response);
		}
		
	});
	
});

</script>
-->
<script>

		$('.select2').select2({
		placeholder: "Please Select here",
		width:"100%"
	})
	function frm_reset(){
		$('#manage-product input, #manage-product select, #manage-product textarea').val('')
		$('#manage-product input, #manage-product select, #manage-product textarea').trigger('change')
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				else if(resp ==2){
					alert_toast("Incorrect Password",'danger')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})

	</script>




