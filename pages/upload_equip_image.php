<?php
include('required/db_connection.php');
	include('required/tables.php');
	require('required/functions.php');
	
	
	
$target_dir = "../dist/img/equip_image/";
$target_file = $target_dir . basename($_FILES["equip_image"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["equip_image"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	
	// $thumb = new Imagick();
	// $thumb->readImage($target_file); 
	// $resize_val = $thumb->resizeImage(128,128,imagick::FILTER_BOX,1);
	// //if($resize_val)
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
		if (move_uploaded_file($_FILES["equip_image"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["equip_image"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	 sleep(5);
	echo '<script> $("div #loading_image").removeAttr("style");</script>';
	$primary_key = $_POST['equipment_id'];
	

	$file_name = $_FILES["equip_image"]["name"];
	$table_name = 'equipment_master';
	$set_value = 'equipment_image="'.$file_name.'"';
	$where = 'sno='.$primary_key;
	$profile_update = db_update($table_name,$set_value,$where);
	
	header("Location: ../equipment_manager.php"); /* Redirect browser */
	//exit();
?>