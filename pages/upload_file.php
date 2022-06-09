<?php
	include('required/db_connection.php');
	include('required/tables.php');
	require('required/functions.php');
	
if (isset( $_POST["submit"])) {
	if ($_FILES['upload_file']['type'] == "application/pdf") {
		$target_dir = "../doc_uploads/";
		$source_file = $_FILES['upload_file']['tmp_name'];
		$target_file = $target_dir . basename($_FILES["upload_file"]["name"]);

		if (file_exists($target_file)) {
			print "The file name already exists!!";
		}
		else {
			move_uploaded_file( $source_file, $target_file )
			or die ("Error!!");
			if($_FILES['upload_file']['error'] == 0) {
				print "Pdf file uploaded successfully!";
				print "<b><u>Details : </u></b><br/>";
				print "File Name : ".$_FILES['upload_file']['name']."<br.>"."<br/>";
				print "File Size : ".$_FILES['upload_file']['size']." bytes"."<br/>";
				print "File location : doc_uploads/".$_FILES['upload_file']['name']."<br/>";
			}
		}
	}
	else {
		if ( $_FILES['upload_file']['type'] != "application/pdf") {
			print "Error occured while uploading file : ".$_FILES['upload_file']['name']."<br/>";
			print "Invalid  file extension, should be pdf !!"."<br/>";
			print "Error Code : ".$_FILES['upload_file']['error']."<br/>";
		}
	}
}
	
 //equipment booking log table update.
		$ebl_table_name = 'equipment_booking_log';
		$sno = $_POST["primary_key"];
		$booking_log_set = 'description="'.$_POST["description"].'"';
		$booking_log_where = 'sno='.$sno;
		//echo $booking_log_set;
		$booking_update = db_update($ebl_table_name,$booking_log_set,$booking_log_where);
		
		//calender event table update.
		$calendar_table_name = 'calender_event';
		$callender_set = 'description="'.$_POST["description"].'",doc_uploaded="'.$_FILES["upload_file"]["name"].'"';
		//echo $callender_set;
		$calender_where = 'id='.$sno;
		$calender_event_update = db_update($calendar_table_name,$callender_set,$calender_where);

		echo $booking_update.'-'.$calender_event_update;
	sleep(5);
//echo $sno.'-'.$booking_update.'-'.$calender_event_update.'-'.$_FILES["upload_file"]["name"].'-'.$target_file;
	header("Location: ../my_bookings.php"); /* Redirect browser */
//exit();
		
?>