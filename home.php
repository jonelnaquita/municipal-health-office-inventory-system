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
                            <form id="filterForm">
                                    <div class="row">
                                        <div class="form-group col-md-3 position-relative">
                                            <input type="date" class="form-control" placeholder="Select date" id="selectedDate" name="selectedDate">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <select class="form-control" id="selectedBarangay" name="selectedBarangay">
                                                <option value='' disabled selected>Select Barangay</option>
                                                <?php
                                                // Include your database connection file
                                                include('../db_connect.php');

                                                // Fetch distinct brgy_name values from heat_map table
                                                $query = "SELECT DISTINCT brgy_name FROM heat_map";
                                                $result = $conn->query($query);

                                                // Check if query was successful
                                                if ($result) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        // Output option tag
                                                        echo "<option value='{$row['brgy_name']}'>{$row['brgy_name']}</option>";
                                                    }
                                                } else {
                                                    // Handle database error
                                                    echo "<option value=''>Error fetching brgy_names</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- Submit Button -->
                                        <div class="form-group col-md-4">
                                            <button type="button" class="btn btn-primary" onclick="filterGraph()">Submit</button>
                                        </div>
                                        <div class="form-group col-md-2">
                                            
                                        </div>
                                    </div>
                                </form>
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
                                

                            <div id="map" style="height: 500px;"></div>

                            <?php
                            // Fetch Data from MySQL with join
                            $query = $conn->query("SELECT h.latitude, h.longitude, h.brgy_name, SUM(ir.quantity) as request_count, ms.sub_category_name, ms.brand_name
                                                    FROM heat_map h
                                                    LEFT JOIN patient_list p ON h.brgy_name = p.address
                                                    LEFT JOIN item_requested ir ON p.id = ir.patient_id
                                                    LEFT JOIN product_list pl ON ir.product_id = pl.id
                                                    LEFT JOIN manage_sub_category ms ON pl.sub_category_id = ms.id
                                                    GROUP BY h.latitude, h.longitude, h.brgy_name");

                            if (!$query) {
                                die("Error: " . $conn->error);
                            }

                            $heatData = $query->fetch_all(MYSQLI_ASSOC);

                            // Convert the data format to [lat, lng, intensity, brgy_name, sub_category_name, brand_name, quantity]
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

                            <script>
                                var map = L.map('map').setView([13.9654, 121.3291], 13);
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '© OpenStreetMap'
                                }).addTo(map);

                                var heat = L.heatLayer(<?php echo json_encode(array_map(function($item) { return array_slice($item, 0, 3); }, $formattedData)); ?>, { radius: 25 }).addTo(map);

                                <?php foreach ($formattedData as $dataPoint): ?>
                                    var brgyName = <?php echo json_encode($dataPoint[3]); ?>; // Save the brgyName in a JavaScript variable
                                    console.log('Brgy Name:', brgyName); // Log the brgyName to the console for debugging
                                    var marker = L.marker([<?php echo $dataPoint[0]; ?>, <?php echo $dataPoint[1]; ?>]).addTo(map);
                                    marker.bindPopup(
                                        '<b>Brgy Name:</b> ' + brgyName + '<br>'
                                    // '<b>Item Requested:</b><br>' +
                                    //  generateRequestedItemsPopup(brgyName) // Pass brgyName to the function
                                    );
                                <?php endforeach; ?>

                                function generateRequestedItemsPopup(brgyName) {
                                    console.log('Inside generateRequestedItemsPopup, Brgy Name:', brgyName); // Log brgyName within the function
                                    <?php
                                    // Fetch Data from MySQL with join for requested items
                                    $query = $conn->query("SELECT ir.quantity, ms.sub_category_name, ms.brand_name
                                                            FROM item_requested ir
                                                            LEFT JOIN patient_list p ON ir.patient_id = p.id
                                                            LEFT JOIN product_list pl ON ir.product_id = pl.id
                                                            LEFT JOIN manage_sub_category ms ON pl.sub_category_id = ms.id
                                                            WHERE p.address = 'Brgy. Anastacia'
                                                            GROUP BY ms.sub_category_name, ms.brand_name");

                                    if (!$query) {
                                        die("Error: " . $conn->error);
                                    }

                                    $requestedItems = $query->fetch_all(MYSQLI_ASSOC);
                                    ?>

                                    var content = '';
                                    <?php foreach ($requestedItems as $item): ?>
                                        content += '- <?php echo $item['sub_category_name'] . ' ' . $item['brand_name']; ?>: <?php echo $item['quantity']; ?><br>';
                                    <?php endforeach; ?>

                                    return content;
                                }
                            </script>

                            </div>
						</div>
					</div>
				</div>
            </div>
        </div>

    </div>
<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Your existing HTML code -->

<script>
    // script.js

$(document).ready(function () {
    let myChart; // Declare a variable to store the chart instance

    // Add an event listener to the submit button
    $('#filterForm button[type="button"]').on('click', function () {
        // Get selected date and barangay
        const selectedDate = $('#selectedDate').val();
        const selectedBarangay = $('#selectedBarangay').val();

        // Use AJAX to fetch filtered data from the server
        $.ajax({
            url: 'utils/update_chart_data.php',
            type: 'POST',
            data: { selectedDate: selectedDate, selectedBarangay: selectedBarangay },
            dataType: 'json',
            success: function (data) {
                // Destroy the existing chart instance
                if (myChart) {
                    myChart.destroy();
                }

                // Update the chart with the filtered data
                myChart = initializeChart(data);
            },
            error: function (error) {
                console.error('Error fetching data:', error.responseText);
                // Display a user-friendly error message
                alert('An error occurred while fetching data. Please try again.');
            }
        });
    });

    // Function to initialize the chart
    function initializeChart(data) {
        const ctx = document.getElementById('medicinesRequested').getContext('2d');
        return new Chart(ctx, {
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
    }

    // Initial chart setup
    $.ajax({
        url: 'utils/get_chart_data.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Initialize the chart with the initial data
            myChart = initializeChart(data);
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
});

</script>

</body>

</html>
