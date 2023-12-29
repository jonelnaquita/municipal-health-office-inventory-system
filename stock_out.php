<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .container-fluid {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <?php include 'db_connect.php' ?>
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b>Stock Out List</b>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered">
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Product</th>
									<th class="text-center">Stock Out Date</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Reason</th>
                                </thead>
                                <tbody>
									<?php
									$i = 1;
									$cats = $conn->query("SELECT pl.*, sc.*, soi.*
										FROM product_list pl 
										INNER JOIN manage_sub_category sc ON pl.sub_category_id = sc.id 
										LEFT JOIN stock_out_items soi ON pl.id = soi.product_id
										ORDER BY soi.id ASC");
									while ($row = $cats->fetch_assoc()):
									?>
										<tr>
											<td class="text-center"><?php echo $i++ ?></td>
											<td class="" style="text-align: left;">
												<p style="margin-bottom: -5px;">Batch #: <b><?php echo $row['batch_no'] ?></b></p>
												<p style="margin-bottom: -5px;">Name: <b><?php echo $row['sub_category_name'].' '.$row['brand_name'] ?></b></p>
												<p style="margin-bottom: -5px;">Brand: <b><?php echo $row['brand'] ?></b></p>
												<p style="margin-bottom: -5px;">Item Description: <b><?php echo $row['name'] ?><?php echo $row['dosage'] ?></b></p>
											</td>
											<td class="">
												<?php echo date("Y-m-d", strtotime($row['stock_out_date'])) ?>
											</td>
											<td class="text-center"><?php echo $row['quantity'] ?></td>
											<td class="text-center">
												<?php echo $row['status'] ?>
											</td>
										</tr>
									<?php
									endwhile; ?>
								</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
