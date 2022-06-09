<div id="loading_image" style="display:none;"></div>
<?php
	include('required/db_connection.php');
	include('required/tables.php');
	require('required/functions.php');
	
	
	$primary_key = $_POST['sno'];
		$table_name = 'admin_info';
	
	//to check whether a profile pic is present
	$profile_pic_check_query = "SELECT pro_image FROM admin_info WHERE 1=1 AND sno=".$primary_key;
	$profile_pic_check_result = db_one($profile_pic_check_query);
	
	//if present , then delete the older one to replace it with the new one.
	if($profile_pic_check_result[0] != NULL){
		unlink('../dist/img/'.$profile_pic_check_result[0]);
	}
		$target_dir = "../dist/img/";
		$target_file = $target_dir . basename($_FILES["prof_pic"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["prof_pic"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
		// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
		// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["prof_pic"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["prof_pic"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
	sleep(5);
	echo '<script> $("div #loading_image").removeAttr("style");</script>';
	

	$file_name = $_FILES["prof_pic"]["name"];
	$set_value = 'pro_image="'.$file_name.'"';
	$where = 'sno='.$primary_key;
	$profile_update = db_update($table_name,$set_value,$where);
	
	header("Location: ../profile.php"); /* Redirect browser */
	//exit();
?>