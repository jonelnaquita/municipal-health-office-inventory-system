<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4><b>Inventory</b></h4>
					</div>
					<div class="card-body">
						<table class="tableinventory table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Date Encode</th>
								<th class="text-center">Item Description</th>
								<th class="text-center">Unit of Measure</th>
								<th class="text-center">Brand</th>
								<th class="text-center">Batch No</th>
								<th class="text-center">Received</th>
								
								<th class="text-center">Stock Out</th>
								<th class="text-center">Balance</th>
								<th class="text-center">Action</th>

							</thead>
							<tbody>
							<?php 
								$i = 1;
								$product = $conn->query("SELECT p.*,i.name FROM product_list p  inner join item_description i on p.item_id = i.id");
								while($row=$product->fetch_assoc()):
									
									
								$qty = $conn->query("SELECT sum(qty) as qty FROM product_list where id = ".$row['id']);
								$qty = $qty && $qty->num_rows > 0 ? $qty->fetch_array()['qty'] : 0;



								$out = $conn->query("SELECT sum(quantity) as `out` FROM customer_list where product_id = ".$row['id']);
								$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
								


								$available =   $qty- $out; 
							?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center"><?php echo date("m-d-y ",strtotime($row['date_added']))?></td>
									<td class=""><?php echo $row['name'] ?> <sup><?php echo $row['dosage'] ?></sup></td>
									<td class="text-center"><?php echo $row['unit_measure'] ?></td>
									<td class="text-center"><?php echo $row['brand'] ?></td>
									<td class="text-center"><?php echo $row['batch_no'] ?></td>
									<td class="text-right"><?php echo $qty > 0 ? $qty : 0 ?></td>
								
									<td class="text-right"><?php echo $out > 0 ? $out : 0 ?></td>
									<td class="text-right"><?php echo $available ?></td>

									<td class="text-right"><button class="btn btn-sm btn-primary edit_product" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a></td>
								   
								</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


