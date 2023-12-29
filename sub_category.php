<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-category">
				<div class="card">
					<div class="card-header">
						    Sub Category Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Sub Category</label>
								<input type="text" class="form-control" name="sub_category_name">
							</div>
							

							
					
					<div class="form-group">
							<label class="control-label">Category</label>
							<select name="category_id" id="" class="custom-select browser-default select2">
								<option></option>
							<?php 

							$cat = $conn->query("SELECT * FROM category_list order by name asc");
							while($row=$cat->fetch_assoc()):
								$cat_arr[$row['id']] = $row['name'];
							?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
							<?php endwhile; ?>
							</select>
						</div>	

						
						<div class="form-group">
								<label class="control-label">Brand Name</label>
								<input type="text" class="form-control" name="brand_name">
							</div>



						</div>



					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Sub Category List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Name</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$cats = $conn->query("SELECT * FROM sub_category order by id asc");
								while($row=$cats->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
									
										<p><small>Category:<b><?php echo $cat_arr[$row['category_id']] ?></b></small></p>
										<p><small>Sub Category : <b><?php echo $row['sub_category_name'] ?></b></small></p>
										<p><small>Brand Name:<b><?php echo $row['brand_name'] ?></b></small></p>

									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_cat" type="button" data-id="<?php echo $row['id'] ?>" data-sub_category_name="<?php echo $row['sub_category_name'] ?>"data-category_id="<?php echo $row['category_id'] ?>" data-item_id="<?php echo $row['item_id'] ?>" data-brand_name="<?php echo $row['brand_name'] ?>" >Update</button>
										<!--
										<button class="btn btn-sm btn-danger delete_cat" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										-->
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script>
	
	$('#manage-category').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_sub_category',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_cat').click(function(){
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='sub_category_name']").val($(this).attr('data-sub_category_name'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id'))
		cat.find("[name='brand_name']").val($(this).attr('data-brand_name'))
		
		end_load()
	})
	$('.delete_cat').click(function(){
		_conf("Are you sure to delete this medicine type?","delete_cat",[$(this).attr('data-id')])
	})
	function delete_cat($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_category',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	new DataTable('table', {
    info: false,
    ordering: false,
    paging: false
});
</script>