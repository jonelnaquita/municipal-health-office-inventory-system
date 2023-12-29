<div class="form-group">
					<label for="product_id">Brand Name</label>
					<select name="product_id" id="" class="custom-select browser-default select2" required="">
						<option></option>
					<?php 

					$cat = $conn->query("SELECT * FROM product_list p inner join manage_sub_category m on p.sub_category_id=m.id");
					while($row=$cat->fetch_assoc()):
						$type_arr[$row['id']] = $row['sub_category_name'];
					?>
						<option value="<?php echo $row['id'] ?>"><?php echo $row['sub_category_name'] ?><br> <br><?php echo $row['name'] ?> <?php echo $row['brand_name'] ?></option>
					<?php endwhile; ?>
					</select>
				</div>