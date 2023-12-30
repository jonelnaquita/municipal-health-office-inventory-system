<?php 

?>
<head>
    
    <style>
        /* Add any additional styles as needed */
        .dataTables_wrapper {
            padding: 10px;
        }
    </style>
</head>


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            
        </div>
    </div>
    <br>
    <div class="row">
		<div class="col-lg-7">
			<div class="card">
				<div class="card-header">
					<h6>Users</h6>	
				</div>
				<div class="card-body">
					<button class="btn btn-primary float-right btn-sm mb-2" id="new_user">
						<i class="fa fa-plus"></i> New user
					</button>
					<table id="table" class="table table-striped table-bordered col-md-12">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Name</th>
								<th class="text-center">Username</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							$users = $conn->query("SELECT * FROM users ORDER BY name ASC");
							$i = 1;
							while ($row = $users->fetch_assoc()):
							?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center"><?php echo $row['name'] ?></td>
									<td class="text-center"><?php echo $row['username'] ?></td>
									<td>
										<center>
											<div class="btn-group">
												<button type="button" class="btn btn-primary">Action</button>
												<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Delete</a>
												</div>
											</div>
											<button type="button" class="btn btn-info view-logs" data-id="<?php echo $row['id'] ?>"><i class="fa fa-eye"></i></button>
										</center>
									</td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-5">
			<div class="card">
				<div class="card-header">
					<h6>User Log</h6>
				</div>
				<div class="card-body" id="userLogBody" style="max-height: 500px; overflow-y: auto;">
					<!-- User logs will be displayed here -->
				</div>
			</div>
		</div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Handle button click
        $('.view-logs').click(function() {
            var userId = $(this).data('id');
            
            // Call the server to get user logs
            $.ajax({
                type: 'POST',
                url: 'utils/get_user_logs.php', // Replace with your server-side script to fetch user logs
                data: { user_id: userId },
                success: function(response) {
                    // Update the card body with the fetched logs
                    $('#userLogBody').html(response);
                },
                error: function(error) {
                    console.error('Error fetching user logs:', error);
                }
            });
        });
    });
</script>

<script>
	
$('#new_user').click(function(){
	uni_modal('New User','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
		_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
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