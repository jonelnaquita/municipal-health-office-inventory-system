<?php
include('db_connect.php');
if (isset($_GET['id'])) {
	$user = $conn->query("SELECT * FROM patient_list WHERE id =" . $_GET['id']);
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>

<style>
    .list-group-item {
        padding: 1px;
    }
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h6><b>Patient Details</b></h6>
				</div>
				<div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> <?php echo $meta['last_name'] . ', ' . $meta['first_name'] ?></li>
                        <li class="list-group-item"><strong>Contact:</strong> <?php echo $meta['contact_number'] ?></li>
                        <li class="list-group-item"><strong>Address:</strong> <?php echo $meta['address'] ?></li>
                        <li class="list-group-item"><strong>Age:</strong> <?php echo $meta['age'] ?></li>
                        <li class="list-group-item"><strong>Birthday:</strong> <?php echo $meta['birthdate'] ?></li>
                    </ul>
                </div>
			</div>
		</div>
	</div>

	<div class="row mt-2">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h6><b>Patient Transactions</b></h6>
				</div>
				<div class="card-body">
				<table class="table table-bordered" id="patientTransactionsTable">
					<thead>
						<tr>
							<th>#</th>
							<th>Item</th>
							<th>Quantity</th>
							<th>Requested Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Fetch data from the database
						include 'db_connect.php'; // Include your database connection file

						$transactions = $conn->query("SELECT ir.id, p.sub_category_id, m.sub_category_name, m.brand_name, ir.quantity, ir.availed_date
										FROM item_requested ir
										JOIN product_list p ON ir.product_id = p.id
										JOIN manage_sub_category m ON p.sub_category_id = m.id");

						$counter = 1;
						while ($row = $transactions->fetch_assoc()) {
							$productName = $row['sub_category_name'] . ' ' . $row['brand_name'];

							echo "<tr>";
							echo "<td>" . $counter++ . "</td>";
							echo "<td>" . $productName . "</td>";
							echo "<td>" . $row['quantity'] . "</td>";
							echo "<td>" . $row['availed_date'] . "</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
