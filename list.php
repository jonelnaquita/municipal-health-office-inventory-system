<!--Check the Expired Products-->
<?php
include 'db_connect.php';

date_default_timezone_set('Asia/Manila');
$currentDate = date('Y-m-d');

// Select items that are not archived and are expired or will expire within three months
$expiredProducts = $conn->query("SELECT id, qty, date_expiry, status FROM product_list WHERE status != 'Archived' AND (date_expiry <= CURRENT_DATE OR DATE_ADD(CURRENT_DATE, INTERVAL 3 MONTH) >= date_expiry)");

while ($row = $expiredProducts->fetch_assoc()) {
    $productId = $row['id'];
    $quantity = $row['qty'];

    // Update status to "Archived"
    $conn->query("UPDATE product_list SET status = 'Archived' WHERE id = $productId");

    // Insert into stock_out_items table
    $conn->query("INSERT INTO stock_out_items (product_id, stock_out_date, quantity, status) VALUES ('$productId', '$currentDate', '$quantity', 'Expired')");
}

$conn->close();
?>



<div class="container-fluid">
  <div class="row">
    <div class="card col-lg-12">
      <div class="card-header">
        <h4><b>Inventory</b></h4>
      </div>
      <div class="card-body">
        <button class="btn btn-primary float-right btn-sm" id="new_product"><i class="fa fa-plus"></i> New Product</button>
        <h6>Labels: <span class="badge badge-danger mb-2">Low Stock</span></h6>
        <table id="tableInventory" class="nowrap table table-bordered" style="width:100%">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Date Encode</th>
					<th class="text-center">Brand Name</th>
					<th class="text-center">Category Name</th>
					<th class="text-center">Supplier Name</th>
					<th class="text-center">Type</th>
					<th class="text-center">Dosage Form</th>
					<th class="text-center">Dosage Strenght</th>
					<th class="text-center">Batch No </th>
					<th class="text-center">Brand</th>
					<th class="text-center">Unit of Measure</th>
					<th class="text-center">Shelf No</th>
					<th class="text-center">Status</th>
					<th class="text-center">Date Expiry</th>
					<th class="text-center">Stock</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
				include 'db_connect.php';
				$users = $conn->query("SELECT 
					p.*, 
					t.name AS type_name, 
					s.supplier_name, 
					sc.sub_category_name, 
					sc.brand_name,
					c.name AS category_name,
					COUNT(p.id) AS product_count
				FROM product_list p
				INNER JOIN type_list t ON p.type_id = t.id
				INNER JOIN supplier_list s ON p.supplier_id = s.id
				INNER JOIN manage_sub_category sc ON p.sub_category_id = sc.id
				INNER JOIN category_list c ON sc.category_id = c.id
				WHERE status != 'Archived'
				GROUP BY p.id
				ORDER BY p.id

				");

				$i = 1;
				while ($row = $users->fetch_assoc()):
					$stock = $row['qty'];
            		$highlightClass = ($stock <= 10) ? 'bg-danger text-white' : ''; // Add this line to determine the style
				?>
				 <tr class="<?php echo $highlightClass; ?>">
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td class="text-center">
					 <?php echo date("m-d-y ",strtotime($row['date_added'])) ?>	
				 	</td>
					 <td class="text-center">
					 <?php echo $row['sub_category_name'].' '.$row['brand_name']?>
					 </td>
					 <td class="text-center">
					 <?php echo $row['category_name']?>
					 </td>
					 <td class="text-center">
					 <?php echo $row['supplier_name'] ?>
					 </td>
				 	<td class="text-center">
					 <?php echo $row['type_name'] ?>
					 </td>
					 
					 <td class="text-center">
				 		<?php echo $row['dosage_form'] ?>
				 	</td>
					 <td class="text-center">
					 <?php echo $row['dosage'] ?>
					 </td>
					 <td class="text-center">
					<?php echo $row['batch_no'] ?></b></small>
					 </td>
					 <td class="text-center">
					 <?php echo $row['brand'] ?>
					 </td>
					 <td class="text-center">
					 <?php echo $row['unit_measure'] ?>
					 </td>
					 <td class="text-center">
					 <?php echo $row['shelf_no'] ?>
					 </td>
					 <td class="text-center">
					 <?php if($row['prescription'] == 1): ?>
						<span class="badge badge-warning">Medicine requires prescription</span>
					<?php endif; ?>
					</td>
					 
					 <td class="text-center">
					 	<?php echo date("F j, Y", strtotime($row['date_expiry'])) ?>
					 </td>
					 <td class="text-center">
					 <?php echo $row['qty'] ?>
					 </td>
					 
					
				 	<td>
						<div class="dropdown">
						<button class="btn btn-light btn-sm dropdown-toggle" type="button" id="iconDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-cogs text-dark"></i>
						</button>

						<div class="dropdown-menu" aria-labelledby="iconDropdown">
						<a class="dropdown-item patient-request-btn <?php echo ($stock <= 10) ? 'disabled' : ''; ?>" href="javascript:void(0)" data-id='<?php echo $row['id']; ?>'>
							<?php if ($stock <= 10): ?>
								<span class="badge badge-danger">Low Stock</span>
							<?php endif; ?>
							<i class="fas fa-user-md"></i> 
							Patient Request
						</a>
						<a class="dropdown-item edit-item-btn edit_product" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>
							<i class="fas fa-edit"></i>
							Update
						</a>
						<a class="dropdown-item add-stocks-btn" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>
							<i class="fas fa-plus"></i> 
							Add Stocks
						</a>
						</div>
					</div>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
			</table>
      </div>
    </div>
  </div>
</div>




<script>
$('#new_product').click(function(){
	uni_modal('New Product','manage_list.php')
})
</script>

<script>
	$(document).ready(function() {
    var table = $('#tableInventory').DataTable({
		responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] // Include the first and third columns
                },
            },
            {
                extend: 'csvHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] // Include the first and third columns
                },
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] // Include the first and third columns
                },
            },
            'colvis'
        ],
        select: true,
        columnDefs: [ {
            targets: -0,
            visible: false
        } ]
    });

    // Use event delegation to handle click on the document for the patient request button
    $(document).on('click', '.patient-request-btn', function() {
        var productId = $(this).data('id');
		$('#productID').val(productId);
        $('#patientRequestModal').modal('show');
    });

	$(document).on('click', '.add-stocks-btn', function() {
		var productId = $(this).data('id');
		$('#productID-stocks').val(productId); // Set the productID value
		$('#productID-stocks').text(productId);
		$('#addStockModal').modal('show');
	});


	$(document).on('click', '.edit_product', function(){
		uni_modal('Edit product','utils/edit_product.php?id='+$(this).attr('data-id'))
	})

	$(document).on('click', '.delete_product', function(){
		_conf("Are you sure to delete this product?","delete_product",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_product',
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
});

</script>


<!-- Patient Request Modal -->
<div class="modal fade" id="patientRequestModal" tabindex="-1" role="dialog" aria-labelledby="patientRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientRequestModalLabel">Medicine Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form id="patientRequestForm" action="utils/process_request.php" method="post">
					<input type="hidden" name="productID" id="productID"></input>
					<div class="form-group">
                        <label for="patientName">Patient Name</label>
                        <select class="form-control" id="patientName" name="patientName" style="width: 100%">
                            <?php
                            // Fetch patient names from the database
                            include 'db_connect.php'; // Include your database connection file
                            $patients = $conn->query("SELECT * FROM patient_list ORDER BY last_name ASC");
                            while ($row = $patients->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['last_name'].', '. $row['first_name'].' '. $row['middle_initial']. "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Quantity Input -->
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" name="quantity" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submitRequestBtn">Submit Request</button>
            </div>
			</form>
        </div>
    </div>
</div>



<!-- Add Stocks Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientRequestModalLabel">Add Stocks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addStockForm" action="utils/add_stocks.php" method="post">
                    <input type="hidden" name="productID" id="productID-stocks"></input>
                    <!-- Quantity Input -->
                    <div class="form-group">
                        <label for="quantity">New Stocks</label>
                        <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" name="quantity" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submitRequestBtn">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Initialize Select2 for the patient name selection
        $('#patientName').select2({
            placeholder: 'Select a patient',
            width: '100%'
        });

        // Submit form via AJAX
        $('#patientRequestForm').submit(function(e) {
            e.preventDefault();
			start_load()

            // Get form data
            var formData = $(this).serialize();

            // Perform AJAX request
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Handle the response from the server (e.g., show success message)
                    console.log(response);
                    window.location.reload(true);
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
    // Submit form via AJAX
    $('#addStockForm').submit(function(e) {
        e.preventDefault();
        start_load();

        // Get form data
        var formData = $(this).serialize();

        // Perform AJAX request
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Handle the response from the server
                console.log(response);
                if (response.status === 'success') {
                    alert_toast("Request submitted successfully", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Error processing request", 'error');
                }
            },
            error: function(error) {
                console.log('Error:', error);
                alert_toast("Error processing request", 'error');
            }
        });
    });
});
</script>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

