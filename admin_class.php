<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
	
		// Use prepared statement to prevent SQL injection
		$stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if($result->num_rows > 0){
			$user = $result->fetch_assoc();
	
			// Verify the hashed password using md5
			if (md5($password) === $user['password']) {
				date_default_timezone_set('Asia/Manila');
	
				// Save user log
				$log_data = array(
					'user_id' => $user['id'],
					'logs' => $user['name'] . ' login',
					'date_added' => date('Y-m-d H:i:s')
				);
	
				$this->saveUserLog($log_data);
	
				$_SESSION['userSession'] = $user['id'];
	
				// Set session variables
				foreach ($user as $key => $value) {
					if ($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
	
				return 1;
			} else {
				return 3; // Password does not match
			}
		} else {
			return 3; // User not found
		}
	}
	
	

	function saveUserLog($data) {
		$columns = implode(", ", array_keys($data));
		$values = "'" . implode("', '", array_values($data)) . "'";
		
		$query = "INSERT INTO user_logs ($columns) VALUES ($values)";
		$result = $this->db->query($query);
	
		if (!$result) {
			$error = $this->db->error;
			error_log("Error in saveUserLog query: $error. Query: $query");
		}
	}
	

	function logout(){
		date_default_timezone_set('Asia/Manila');
		$log_data = array(
			'user_id' => $_SESSION['userSession'],
			'logs' => $_SESSION['login_name'] . ' logout',
			'date_added' => date('Y-m-d H:i:s')
		);

		$columns = implode(", ", array_keys($log_data));
		$values = "'" . implode("', '", array_values($log_data)) . "'";
		
		$query = "INSERT INTO user_logs ($columns) VALUES ($values)";
		$result = $this->db->query($query);

		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
	
		// Redirect to the login page
		header("location: login.php");
	}
	

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		if(isset($type))
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}

	function signup(){
		extract($_POST);
		$data = " first_name = '$first_name' ";
		$data .= ", last_name = '$last_name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", email = '$email' ";
		$data .= ", username = '$username' ";
		$data .= ", create_password = '".md5($password)."' ";

		$chk = $this->db->query("SELECT * FROM user='' ")->num_rows;
		if($chk > 0){
			return 2;
		}
			$save = $this->db->query("INSERT INTO user set ".$data);
		if($save){
			$login = $this->login2();
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data." where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO category_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE category_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM category_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_type(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO type_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE type_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_type(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM type_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_sub_category(){
		extract($_POST);
		$data = " sub_category_name = '$sub_category_name' ";
		$data .= ", category_id = '$category_id' ";
		
		$data .= ", brand_name = '$brand_name' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO manage_sub_category set ".$data);
		}else{
			$save = $this->db->query("UPDATE manage_sub_category set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_sub_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM manage_sub_category where id = ".$id);
		if($delete)
			return 1;
	}


	function save_item(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO item_description set ".$data);
		}else{
			$save = $this->db->query("UPDATE item_description set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_item(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM item_description where id = ".$id);
		if($delete)
			return 1;
	}


	function save_supplier(){
		extract($_POST);
		$data = " supplier_name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO supplier_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE supplier_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_supplier(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM supplier_list where id = ".$id);
		if($delete)
			return 1;
	}
	
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}

	function save_customer(){
		extract($_POST);
	
		date_default_timezone_set('Asia/Manila');
		$currentDate = date('Y-m-d');
	
		// Continue with the save process if no duplicate is found
		$data = " first_name = '$first_name' ";
		$data .= ", middle_initial = '$middle_initial' ";
		$data .= ", last_name = '$last_name' ";
		$data .= ", age = '$age' ";
		$data .= ", birthdate = '$birthdate' ";
		$data .= ", contact_number = '$contact_number' ";
		$data .= ", address = '$address' ";
		$data .= ", date_registered = '$currentDate' ";

	
		try {
			if (empty($id)) {
				$save = $this->db->query("INSERT INTO patient_list set " . $data);
			} else {
				$save = $this->db->query("UPDATE patient_list set " . $data . " where id = " . $id);
			}
	
			if ($save) {
				return 1;
			} else {
				throw new Exception("Database error: " . $this->db->error);
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	
	

	function save_product(){
		extract($_POST);

		// Fetch sub_category_name and brand_name based on sub_category_id
		$subcategory_info = $this->db->query("SELECT sub_category_name, brand_name FROM manage_sub_category WHERE id = '$sub_category_id'");
		$subcategory_data = $subcategory_info->fetch_assoc();
	
		$data = " dosage_form = '$dosage_form' ";
		$data .= ", brand = '$brand' ";
		$data .= ", batch_no = '$batch_no' ";
		$data .= ", dosage = '$dosage' ";
		$data .= ", unit_measure = '$unit_measure' ";
		$data .= ", date_expiry = '$date_expiry' ";
		$data .= ", type_id = '$type_id' ";
		$data .= ", qty = '$qty' ";
		$data .= ", supplier_id = '$supplier_id' ";
		$data .= ", shelf_no = '$shelf_no' ";
		$data .= ", sub_category_id = '$sub_category_id' ";
	
		if (isset($prescription)) {
			$data .= ", prescription = '$prescription' ";
		}
	
		// Check if it's a new item or an update
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO product_list SET " . $data);
	
			// Log the addition of a new item
			if ($save) {
				date_default_timezone_set('Asia/Manila');

				$log_data = array(
					'user_id' => $_SESSION['userSession'],
					'logs' => $_SESSION['login_name'] . ' added a new item (' . $subcategory_data['sub_category_name'] . ' - ' . $subcategory_data['brand_name'] . ')',
					'date_added' => date('Y-m-d H:i:s')
				);
	
				$this->saveUserLog($log_data);
			}
		} else {
			$save = $this->db->query("UPDATE product_list SET " . $data . " WHERE id = " . $id);
		}
	
		if ($save) {
			return 1;
		}
	}


	function chk_prod_availability(){
		extract($_POST);
		$price = $this->db->query("SELECT * FROM product_list where id = ".$id)->fetch_assoc()['price'];
		$inn = $this->db->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$id);
		$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
		$out = $this->db->query("SELECT sum(qty) as `out` FROM customer_list where  product_id = ".$id);
		$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
		$ex = $this->db->query("SELECT sum(qty) as ex FROM expired_product where product_id = ".$id);
		$ex = $ex && $ex->num_rows > 0 ? $ex->fetch_array()['ex'] : 0;
		$available = $inn - $out - $ex;
		return json_encode(array('available'=>$available,'price'=>$price));

	}
	
}

	

	

