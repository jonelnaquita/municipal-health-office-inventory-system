<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM patient_list where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}

?>
<div class="container">
	<form action="" id="manage-customer">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">

		<div class="form-group">
			<label for="name">First Name</label>
			<input type="text" name="first_name" id="first_name" class="form-control" placeholder="Juan" value="<?php echo isset($meta['first_name']) ? $meta['first_name']: '' ?>" required="">
		</div>

		<div class="form-group">
			<label for="middle_initial">Middle Initial</label>
			<select name="middle_initial" id="middle_initial" class="form-control">
				<option value="<?php echo isset($meta['middle_initial']) ? $meta['middle_initial']: '' ?>" selected><?php echo isset($meta['middle_initial']) ? $meta['middle_initial']: 'N/A' ?></option>
				<?php
				// Loop through the alphabet (A-Z)
				for ($i = ord('A'); $i <= ord('Z'); $i++) {
					$initial = chr($i);
					echo "<option value='$initial'>$initial</option>";
				}
				?>
			</select>
		</div>

		<div class="form-group">
			<label for="name">Last Name</label>
			<input type="text" name="last_name" id="last_name" placeholder="Dela Cruz" class="form-control" value="<?php echo isset($meta['last_name']) ? $meta['last_name']: '' ?>" required="">
		</div>

		<div class="form-group">
			<label for="contact_number">Contact Number</label>
			<input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="09xxxxxxxxx" value="<?php echo isset($meta['contact_number']) ? $meta['contact_number']: '' ?>" oninput="validateContactNumber()" required="">
		</div>
		
		<script>
			function validateContactNumber() {
				var contactNumber = document.getElementById('contact_number').value;

				// Check if the contact number has at most 11 digits
				if (/^\d{1,11}$/.test(contactNumber)) {
					return true;
				} else {
					alert('Please enter a valid contact number with at most 11 digits.');
					return false;
				}
			}
		</script>

		<div class="form-group">
				<label for="address">Address</label>
					<select name="address" id="address" class="custom-select browser-default select2" value="<?php echo isset($meta['address']) ? $meta['address']: '' ?>" required="">
					<option value="Brgy. Anastacia">Brgy. Anastacia</option>
					<option value="Brgy. Aquino">Brgy. Aquino</option>
					<option value="Brgy. Ayusan I">Brgy. Ayusan I</option>
					<option value="Brgy. Ayusan II">Brgy. Ayusan II</option>
					<option value="Brgy. Behia">Brgy. Behia</option>
					<option value="Brgy. Bukal">Brgy. Bukal</option>
					<option value="Brgy. Bula">Brgy. Bula</option>
					<option value="Brgy. Bulakin">Brgy. Bulakin</option>
					<option value="Brgy. Cabatang">Brgy. Cabatang</option>
					<option value="Brgy. Cabay">Brgy. Cabay</option>
					<option value="Brgy. Del Rosario">Brgy. Del Rosario</option>
					<option value="Brgy. Lagalag">Brgy. Lagalag</option>
					<option value="Brgy. Lalig">Brgy. Lalig</option>
					<option value="Brgy. Lumingon">Brgy. Lumingon</option>
					<option value="Brgy. Lusacan">Brgy. Lusacan</option>
					<option value="Brgy. Paiisa">Brgy. Paiisa</option>
					<option value="Brgy. Palagaran">Brgy. Palagaran</option>
					<option value="Brgy. Poblacion I">Brgy. Poblacion I</option>
					<option value="Brgy. Poblacion II">Brgy. Poblacion II</option>
					<option value="Brgy. Poblacion III">Brgy. Poblacion III</option>
					<option value="Brgy. Poblacion IV">Brgy. Poblacion IV</option>
					<option value="Brgy. Quipot">Brgy. Quipot</option>
					<option value="Brgy. San Agustin">Brgy. San Agustin</option>
					<option value="Brgy. Isidro">Brgy. Isidro</option>
					<option value="Brgy. San Jose">Brgy. San Jose</option>
					<option value="Brgy. San Juan">Brgy. San Juan</option>
					<option value="Brgy. San Pedro">Brgy. San Pedro</option>
					<option value="Brgy. Tagbakin">Brgy. Tagbakin</option>
					<option value="Brgy. Talisay">Brgy. Talisay</option>
					<option value="Brgy. Tamisian">Brgy. Tamisian</option>
					<option value="Brgy. San Francisco">Brgy. San Francisco</option>
					</select>
				</div>

				<div class="form-group">
					<label for="birthdate">Date of Birth</label>
					<input type="date" name="birthdate" id="birthdate" class="form-control" value="<?php echo isset($meta['birthdate']) ? $meta['birthdate']: '' ?>" required="">
				</div>

				<div class="form-group">
					<label for="age">Age</label>
					<input type="age" name="age" id="age" class="form-control" value="<?php echo isset($meta['age']) ? $meta['age']: '0' ?>" required="">
				</div>

				<script>
					$(document).ready(function () {
						$('#birthdate').change(function () {
							updateAge();
						});

						function updateAge() {
							var dob = $('#birthdate').val();
							if (dob) {
								var birthDate = new Date(dob);
								var currentDate = new Date();

								var age = currentDate.getFullYear() - birthDate.getFullYear();

								// Adjust age if birthday hasn't occurred yet this year
								if (currentDate.getMonth() < birthDate.getMonth() || (currentDate.getMonth() === birthDate.getMonth() && currentDate.getDate() < birthDate.getDate())) {
									age--;
								}

								$('#age').val(age);
							} else {
								$('#age').val('');
							}
						}

						// Initialize age on page load
						updateAge();
					});
				</script>


				<div class="card-footer">
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
	</form>

<script>
    $('#manage-customer').submit(function (e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_customer',
            method: 'POST',
            data: $(this).serialize(),
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Error saving data. Please try again.", 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert_toast("Error: " + xhr.responseText, 'error');
            }
        });
    });
</script>





