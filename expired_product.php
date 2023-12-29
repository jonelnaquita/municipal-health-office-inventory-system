<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Expired Product List</b>
			
					</div>
					<div class="card-body">
						<table id="table" class="table table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Date Expired</th>
								<th class="text-center">Product</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Status</th>
							</thead>
							<tbody>
							<?php
								$i = 1;
								$cats = $conn->query("SELECT pl.*, sc.sub_category_name, sc.brand_name 
									FROM product_list pl 
									INNER JOIN manage_sub_category sc ON pl.sub_category_id = sc.id 
									WHERE pl.status = 'Archived' 
									ORDER BY pl.id ASC");

								while ($row = $cats->fetch_assoc()):
									$today = date('Y-m-d');
									$expire = date('Y-m-d', strtotime($row['date_expiry']));

									// Check if the difference in months between today and expiration date is less than 3
									if (date_diff(date_create($today), date_create($expire))->m < 3):
										?>

										<tr>
											<td class="text-center"><?php echo $i++ ?></td>
											<td class="">
												<?php echo date("Y-m-d", strtotime($row['date_expiry'])) ?>
											</td>
											<td class="" style="text-align: left;">
												<p style="margin-bottom: -5px;">Batch #: <b><?php echo $row['batch_no'] ?></b></p>
												<p style="margin-bottom: -5px;">Name: <b><?php echo $row['sub_category_name'].' '.$row['brand_name'] ?></b></p>
												<p style="margin-bottom: -5px;">Brand: <b><?php echo $row['brand'] ?></b></p>
												<p style="margin-bottom: -5px;">Item Description: <b><?php echo $row['name'] ?><?php echo $row['dosage'] ?></b></p>
											</td>
											<td class="text-center"><?php echo $row['qty'] ?></td>
											<td class="text-center">
												<?php
												if ($today >= $expire) {
													echo "Expired";
												} else {
													echo "Near to Expired";
												}
												?>
											</td>
										</tr>

									<?php endif;
								endwhile; ?>
									
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	$('#new_expired').click(function(){
		location.href = "index.php?page=manage_expired"
	})
	$('.delete_expired').click(function(){
		_conf("Are you sure to delete this data?","delete_expired",[$(this).attr('data-id')])
	})
	function delete_expired($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_expired',
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




