<?php
include 'db_connect.php';


function displayExpiredProducts($conn)
{
    // Get current date
    $currentDate = date('Y-m-d');

    // Get products that will expire within the next 3 months
    $expiredProducts = $conn->query("
        SELECT p.*, sc.sub_category_name, sc.brand_name 
        FROM product_list p 
        INNER JOIN manage_sub_category sc ON p.sub_category_id = sc.id 
        WHERE date(p.date_expiry) <= '$currentDate' OR date(p.date_expiry) BETWEEN '$currentDate' AND DATE_ADD('$currentDate', INTERVAL 3 MONTH)
    ");

    ?>
    <div class="card">
        <div class="card-header">
            Expired Product
        </div>
        <div class="card-body">
            <?php while ($row = $expiredProducts->fetch_array()) : ?>
                <p>
                    <b>Item Name:</b> <?php echo $row['sub_category_name'].' '.$row['brand_name'] ?><br>
                    <b>Date of Expiry:</b> <?php echo $row['date_expiry'] ?><br>
                    <b>Stocks:</b> <?php echo $row['qty'] ?><br>
                    <a href="index.php?page=expired_product&iid=<?php echo $row['id'] ?>" class="ml-2 btn badge badge-primary float-right">Confirm</a>
                </p>
                <hr>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
}


function displayLowStockProducts($conn)
{
    $products = $conn->query("SELECT p.*, sc.sub_category_name, sc.brand_name FROM product_list p INNER JOIN manage_sub_category sc ON p.sub_category_id = sc.id WHERE p.qty <= 10 AND status=''");
    ?>
		<div class="card">
			<div class="card-header">
				Stock Available
			</div>
			<div class="card-body">
				<?php while ($row = $products->fetch_assoc()) : ?>
					<p class="text-left">
						<b><?php echo $row['sub_category_name'] . ' - ' . $row['brand_name']; ?></b><br>
						Remaining Stock: <?php echo $row['qty']; ?>
						<a href="index.php?page=list&iid=<?php echo $row['id'] ?>" class="ml-2 btn badge badge-primary float-right">Confirm</a>
					</p>
					<hr>
				<?php endwhile; ?>
			</div>
		</div>
    <?php
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container-fluid">

        <div class="row mt-3 ml-3 mr-3">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
						<div class="card">
							<div class="card-header">
								<h6>Medicine Requested by Patients</h6>
							</div>
							<div class="card-body">
								<canvas id="medicinesRequested"></canvas>
							</div>
						</div>
					</div>

                    <div class="col-lg-4">
						<div class="expired-products" style="width:100%;">
							<?php displayExpiredProducts($conn); ?>
						</div>
						<div class="mt-2 stock-available" style="width:100%;">
							<?php displayLowStockProducts($conn); ?>
						</div>
                    </div>
                </div>
				<div class="row mt-2">
                    <div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h6>Heat Map</h6>
							</div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="form-group col-md-3 position-relative">
                                            <input type="date" class="form-control" placeholder="Select date">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <select class="form-control" id="exampleSelect" name="product">
                                                <option value='' disabled selected>Select Item</option>
                                                <?php
                                                // Include your database connection file
                                                include('../db_connect.php');

                                                // Fetch products from product_list based on sub_category_id
                                                $query = "SELECT pl.id, pl.sub_category_id, m.sub_category_name, m.brand_name
                                                        FROM product_list pl
                                                        INNER JOIN manage_sub_category m ON pl.sub_category_id = m.id
                                                        WHERE status!='Archived'";
                                                $result = $conn->query($query);

                                                // Check if query was successful
                                                if ($result) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        // Concatenate sub_category_name and brand_name
                                                        $productName = $row['sub_category_name'] . ' ' . $row['brand_name'];

                                                        // Output option tag
                                                        echo "<option value='{$row['id']}'>{$productName}</option>";
                                                    }
                                                } else {
                                                    // Handle database error
                                                    echo "<option value=''>Error fetching products</option>";
                                                }

                                                ?>
                                            </select>

                                        </div>

                                        <!-- Submit Button -->
                                        <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <div id="map" style="height: 500px;"></div>

                                <?php
                                // Fetch Data from MySQL with join
                                $query = $conn->query("SELECT h.latitude, h.longitude, h.brgy_name, COUNT(ir.id) as request_count
                                                        FROM heat_map h
                                                        LEFT JOIN patient_list p ON h.brgy_name = p.address
                                                        LEFT JOIN item_requested ir ON p.id = ir.patient_id
                                                        GROUP BY h.latitude, h.longitude, h.brgy_name");

                                if (!$query) {
                                    die("Error: " . $conn->error);
                                }

                                $heatData = $query->fetch_all(MYSQLI_ASSOC);

                                // Convert the data format to [lat, lng, intensity]
                                $formattedData = [];
                                foreach ($heatData as $dataPoint) {
                                    $formattedData[] = [
                                        $dataPoint['latitude'],
                                        $dataPoint['longitude'],
                                        $dataPoint['request_count'], // Use request count as intensity
                                        $dataPoint['brgy_name'],     // Add brgy_name for the popup
                                    ];
                                }
                                ?>

                                <!-- Initialize Leaflet Map -->
                                <script>
                                    var map = L.map('map').setView([13.9654, 121.3291], 13);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '© OpenStreetMap'
                                    }).addTo(map);

                                    var heat = L.heatLayer(<?php echo json_encode(array_map(function($item) { return array_slice($item, 0, 3); }, $formattedData)); ?>, { radius: 25 }).addTo(map);

                                    <?php foreach ($formattedData as $dataPoint): ?>
                                        var marker = L.marker([<?php echo $dataPoint[0]; ?>, <?php echo $dataPoint[1]; ?>]).addTo(map);
                                        marker.bindPopup('<?php echo $dataPoint[3]; ?>');
                                    <?php endforeach; ?>
                                </script>
                            </div>
						</div>
					</div>
				</div>
            </div>
        </div>

    </div>
    <script>
    const ctx = document.getElementById('medicinesRequested').getContext('2d');

    // Use AJAX to fetch data from the server
    fetch('utils/get_chart_data.php')
        .then(response => response.json())
        .then(data => {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.label),
                    datasets: [{
                        label: '# of Requests',
                        data: data.map(item => item.data),
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>
</body>

</html>
