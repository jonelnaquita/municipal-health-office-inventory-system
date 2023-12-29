<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM product_list where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}

?>
<div class="container">
	
	<form action="" id="manage-product">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">

						<div class="form-group">
							<label for="type_id">Type</label>
							<select name="type_id" id="" class="custom-select browser-default select2" required="">
								<option></option>
							<?php 

							$cat = $conn->query("SELECT * FROM type_list order by name asc");
							while($row=$cat->fetch_assoc()):
								$type_arr[$row['id']] = $row['name'];
							?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
							<?php endwhile; ?>
							</select>
						</div>

						<div class="form-group">
							<label for="sub_category_id">Brand Name</label>
							<select name="sub_category_id" id="sub_category_select" class="custom-select browser-default select2" required="">
								<option></option>
								<?php 
								$cat = $conn->query("SELECT m.id, m.sub_category_name, m.brand_name, c.name as category_name FROM manage_sub_category m INNER JOIN category_list c ON m.category_id = c.id");
								while ($row = $cat->fetch_assoc()):
								?>
									<option value="<?php echo $row['id'] ?>">
										<?php echo $row['sub_category_name'] ?><br><br>
										<?php echo $row['category_name'] ?> <?php echo $row['brand_name'] ?>
									</option>
								<?php endwhile; ?>
							</select>
						</div>



		<div class="form-group">
						<form action="/action_page.php">
						<label for="dosage_form">Dosage Form</label>
								<select name="dosage_form" id="dosage_form" class="form-control" value="<?php echo isset($meta['dosage_form']) ? $meta['dosage_form']: '' ?>" required="">
								<option value="Solution">Solution</option>
								<option value="Suspension">Suspension</option>
								<option value="Syrup">Syrup</option>
								</select>
						</div>
		<div class="form-group">
			<label for="name">Dosage Strenght</label>
			<input type="text" name="dosage" id="dosage" class="form-control" value="<?php echo isset($meta['dosage']) ? $meta['dosage']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="batch_no">Batch No</label>
			<input type="text" name="batch_no" id="batch_no" class="form-control" value="<?php echo isset($meta['batch_no']) ? $meta['batch_no']: '' ?>" required="">
		</div>
		<div class="form-group">
						<form action="/action_page.php">
						<label for="brand">Brand</label>
								<select name="brand" id="brand" class="form-control" value="<?php echo isset($meta['brand']) ? $meta['brand']: '' ?>" required="">
								<option value="Generic">Generic</option>
								<option value="Non Generic">Non Generic</option>
								</select>
						</div>
		
		<div class="form-group">
			<label for="unit_measure">Unit of Measure</label>
			<input type="text" name="unit_measure" id="unit_measure" class="form-control" value="<?php echo isset($meta['unit_measure']) ? $meta['unit_measure']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="shelf_no">Shelf No.</label>
			<input type="number" name="shelf_no" id="shelf_no" class="form-control" value="<?php echo isset($meta['shelf_no']) ? $meta['shelf_no']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="date_expiry">Date Expired</label>
			<input type="date" name="date_expiry" id="date_expiry" class="form-control" value="<?php echo isset($meta['date_expiry']) ? $meta['date_expiry']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="qty">Quantity</label>
			<input type="number" name="qty" id="qty" class="form-control" value="<?php echo isset($meta['qty']) ? $meta['qty']: '' ?>" required="">
		</div>
		<div class="form-group">
							<label for="supplier_id">Supplier Name</label>
							<select name="supplier_id" id="" class="custom-select browser-default select2" required="">
								<option></option>
							<?php 

							$cat = $conn->query("SELECT * FROM supplier_list order by supplier_name asc");
							while($row=$cat->fetch_assoc()):
								$type_arr[$row['id']] = $row['name'];
							?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['supplier_name'] ?></option>
							<?php endwhile; ?>
							</select>
						</div>
		
		<div class="form-group">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="1" id="prescription" name="prescription">
							  <label class="form-check-label" for="prescription">
							    Medicine requires prescription.
							  </label>
							</div>
						</div>	
						
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
	$('#manage-product').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_product',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})

	</script>




