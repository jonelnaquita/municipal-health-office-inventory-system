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

	/* Header Styles */
    .page-header {
        background-color: #3498db; /* Set your desired background color */
        color: #ffffff; /* Set your desired text color */
        padding: 20px; /* Adjust padding as needed */
        text-align: center;
        margin-bottom: 20px;
    }

    .page-header h1 {
        font-size: 24px; /* Set your desired font size */
        margin: 0;
    }

    .page-header p {
        font-size: 16px; /* Set your desired font size */
        margin: 10px 0;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #3498db; /* Set your desired background color for table headers */
        color: #ffffff;
    }
	
</style>

<div class="container print-js">
	<div class="row">
		<a href="index.php?page=customer" class="btn btn-primary" style="float:right; margin: 7px;">Back</a>
		<button id="printButton" class="btn btn-info" style="float:right; margin: 7px;"><i class="fas fa-print"></i> Print</button>
	</div>
	<div id="printableArea">
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
										JOIN manage_sub_category m ON p.sub_category_id = m.id
										WHERE ir.id =" . $_GET['id']);

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
</div>

<script>
    // Function to handle printing
    function printDetails() {
        printJS({
            printable: 'printableArea', // ID, class, or HTML element to print
            type: 'html',
            header: 'Patient Details and Transactions', // Optional header
        });
    }

    // Attach the print function to the button click event
    document.getElementById('printButton').addEventListener('click', printDetails);
</script>

<script>
    console.log('print-js library loaded:', typeof printJS !== 'undefined');
</script>



