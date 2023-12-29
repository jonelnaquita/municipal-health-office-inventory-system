<?php 

?>

<div class="container-fluid">
	
	<div class="row">
	<div class="col-lg-12">
			
	</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
					<button class="btn btn-primary float-right btn-sm mb-2" id="new_customer"><i class="fa fa-plus"></i> New Patient</button>
				<table id="table" class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Name</th>
					<th class="text-center">Contact</th>
					<th class="text-center">Address</th>
					<th class="text-center">Age</th>
					<th class="text-center">Birthday</th>
					

					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM patient_list ");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td class="text-center">
				 		<?php echo $row['last_name'].', '.$row['first_name'].' '.$row['middle_initial'] ?>
				 	</td>
				 	<td class="text-center">
				 		<?php echo $row['contact_number'] ?>
				 	</td>
					 <td class="text-center">
				 		<?php echo $row['address'] ?>
				 	</td>
					 <td class="text-center">
					 <?php echo $row['age'] ?>
				 	</td>
					 <td class="text-center">
				 		<?php echo $row['birthdate'] ?>
				 	</td>
					 
				 	<td>
				 		<center>
							<button class="btn btn-sm btn-primary edit_customer" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</button>
							<button class="btn btn-sm btn-info view_customer" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>View Details</button>
						</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
			<div id="divToPrint" style="display:none; positon:">
  <div style="width:200px;height:300px;background-color:teal;">
           <?php echo $html; ?>      
  </div>
</div>
		</div>
		
	</div>
	

</div>
<script>
$('#new_customer').click(function(){
	uni_modal('New Customer','manage_customer.php')
})
$('.edit_customer').click(function(){
	uni_modal('Edit Customer','manage_customer.php?id='+$(this).attr('data-id'))
})
$('.view_customer').click(function(){
	uni_modal('View Customer','view.php?id='+$(this).attr('data-id'))
})
$('.delete_customer').click(function(){
		_conf("Are you sure to delete this user?","delete_customer",[$(this).attr('data-id')])
	})
	function delete_customer($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_customer',
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
</script>