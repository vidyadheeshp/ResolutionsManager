<?php 
ini_set('display_errors', 1);
?>
<?php 

/*	if (session_id() == '') {
    session_start();
	//$_SESSION['first_name']=$result[0];
	$login_id = $_SESSION['s_id'];
}*/
	include('../pages/required/db_connection.php');
	include('../pages/required/tables.php');
	require('../pages/required/functions.php');
	
	//data retrieval
	$res_title = $_POST['res_title'];
	$cat_id = $_POST['cat_id'];
	$res_status_id = 1;//$_POST['res_status_id'];
	
	$res_date = db_date($_POST['res_date']);
	$dept = $_POST['dept'];
	$res_no = $_POST['res_no'];
	$sanctioning_auth = $_POST['sanctioning_auth'];
	$res_doc = $_POST['res_doc'];
	$res_image = $_FILES['res_image'];
	
	//print_r ($_POST['extra-emails']).'<br/>';
	//echo $res_title.'-'.$cat_id.'-'.$res_status_id.'-'.$res_date.'-'.$dept.'-'.$res_no.'-'.$sanctioning_auth.'-'.$res_doc;
	if(isset($_POST['extra-emails']))
		$Extra_emails = explode(",",$_POST['extra-emails']);
	//print_r($Extra_emails);
	//checking for empty inputs
	if(empty($res_title) || $cat_id == 0 || $res_status_id == 0 || empty($res_date) || $dept == 0 || empty($res_no) || $sanctioning_auth == 0){
	?>
		<div class="callout callout-warning">
						<h4>Fill the details completely</h4>

						<p>Check Out.</p>
					  </div>
	<?php }else{	
			//echo 'Fields are filled properly';
			//for checking whether the image input is set or no.
				$uploadDir = '../uploads/'; 
				$uploadStatus = 0; 
				$uploadedFile = ''; 
				if($_FILES['res_image']['error'] == 0){		

					//DB insertion 
					//for setting up the resolution code (Auto Generation)
					$sanc_auth_list = array('P', 'GCC', 'GC', 'BOM');
					date_default_timezone_set('Asia/Kolkata');
					$rescode = date('Ymd').$sanc_auth_list[$sanctioning_auth-1];
					$rescode= $rescode.date('hs');	


					// Upload file 
					// File path config 
					$fileName = $rescode;//basename($_FILES["res_image"]["name"]); // to change the name of the file to be the rescode. 
					$targetFilePath = $uploadDir . $fileName .".jpg"; 
					$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
					
					if(move_uploaded_file($_FILES["res_image"]["tmp_name"], $targetFilePath)){
							$uploadedFile = $fileName.".jpg";
							$uploadStatus = 1;
							$res_doc = "NULL"; // required for checking the alternate field (Res Text - typed)is empty or not.							
											
							//data for inserting into DB.			
							$status = 1;
							$sno = 'NULL';
							//The category specific remark (which needs to be saved in resolution_status_master)
							if($cat_id == 5){
								$remark = 'Resolution Initated';
							}else{
								$remark = 'NULL';
							}
							
							//table 1 data
							$res_table_no = 1;
							$res_table_name = "res_master";
							//table 3 data.
							$res_status_table_no = 2;
							$res_status_table_name = "res_status_master";
									
							
					
			
							$res_insert_values = $sno.",'".$res_title."',".$cat_id.",".$dept.",'".$res_date."','".$rescode."','".$res_no."',".$res_status_id.",'".$uploadedFile."','".$res_doc."',".$sanctioning_auth.",'".date('Y-m-d')."',".$status;
							//echo $res_insert_values;
							
							$Insert_result = db_insert($res_table_no,$res_table_name,$res_insert_values);
						    //echo $Insert_result;
						//Here the $Insert_result is returning the primary key of the last inserted value from res_master tables
						//That itself is added to the res_status master as RID.
						//echo $Insert_result;
						$res_status_insert_values = $sno.','.$Insert_result.','.$cat_id.','.$res_status_id.',"'.$res_date.'","'.$remark.'",'.$status;
						
						$total_insert_result = db_insert($res_status_table_no,$res_status_table_name,$res_status_insert_values);
						//echo $total_insert_result;
					}else{ 
						$uploadStatus = 0;
						$total_insert_result=0; 							
					}	
				}
				//THE SECOND option - Typing the entire resolution text.
				//Checking if any one of resolution data is available or no.
				//If one of the type is available, the other value will be added as "NULL" in db.
				
				if($res_doc != '' && $_FILES['res_image']['error'] != 0){
					$res_image = "NULL";
					//echo 'Inside Elseif ';
					//data for inserting into DB.			
							$status = 1;
							$sno = 'NULL';
							//The category specific remark (which needs to be saved in resolution_status_master)
							if($cat_id == 5){
								$remark = 'Resolution Initated';
							}else{
								$remark = 'NULL';
							}
							//table 1 data
							$res_table_no = 1;
							$res_table_name = "res_master";
							//table 3 data.
							$res_status_table_no = 2;
							$res_status_table_name = "res_status_master";
									
							//DB insertion 
							//for setting up the resolution code (Auto Generation)
							$sanc_auth_list = array('P', 'GCC', 'GC', 'BOM');
							date_default_timezone_set('Asia/Kolkata');
							$rescode = date('Ymd').$sanc_auth_list[$sanctioning_auth-1];
							$rescode= $rescode.date('hs');
					
			
					$res_insert_values = $sno.",'".$res_title."',".$cat_id.",".$dept.",'".$res_date."','".$rescode."','".$res_no."',".$res_status_id.",'".$res_image."','".$res_doc."',".$sanctioning_auth.",'".date('Y-m-d')."',".$status;
					
					//echo $res_insert_values;				
					$Insert_result = db_insert($res_table_no,$res_table_name,$res_insert_values);
								
					//Here the $Insert_result is returning the primary key of the last inserted value from res_master tables
					//That itself is added to the res_status master as RID.
					//echo $Insert_result;
					$res_status_insert_values = $sno.','.$Insert_result.','.$cat_id.','.$res_status_id.',"'.$res_date.'","'.$remark.'",'.$status;
					
					$total_insert_result = db_insert($res_status_table_no,$res_status_table_name,$res_status_insert_values);
				
				}

				//Mailing details
				$mailing_user_query = "SELECT * FROM user_master WHERE 1=1 AND DEPT_ID=".$dept;
				$mailing_usaer_result =  db_one($mailing_user_query);
				$mail_body = "Dear ".$mailing_usaer_result['NAME']." Head,</br>  <p>A Reolution titled <strong>".$res_title."</strong> has been added on <strong>".$res_date."</strong> in the Resolution Manager Software. <br/>Kindly check in your login and keep updating the status.</p>";
				//$mail_result = mail_to($mailing_usaer_result['EMAIL'],$mailing_usaer_result['NAME'],$mail_body);

				require "../phpmailer/PHPMailerAutoload.php";

				$mail = new PHPMailer();

				//$mail->SMTPDebug = 2;                               // Enable verbose debug output

				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username =          // SMTP username
				$mail->Password =          // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to

				$mail->setFrom('principalsoffice@git.edu', 'Resolution Manager');
				//changed here
				$mail->AddAddress($mailing_usaer_result['EMAIL'] , $mailing_usaer_result['NAME']);     // Add a recipient
				//For setting More 
				if(isset($_POST['extra-emails'])){
					foreach ($Extra_emails AS $email_row){
						$mail->AddAddress($email_row);
						//echo $email_row;
					
					}
				}
				//print($mail->addAddress);
				//$mail->addAddress('principalsoffice@git.edu');               // Name is optional
				$mail->addReplyTo('principalsoffice@git.edu', 'Principal Office');
				//$mail->addCC('principal@git.edu');
				//$mail->addBCC('bcc@example.com');

				//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Reg : New Resolution added in Resolution Manager';
				$mail->Body    = $mail_body;
				//'This is the HTML message body <b>in bold!</b> testing email';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				//foreach ($Extra_emails AS $send_row){
					if(!$mail->send()) {
						$error_message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;;
						echo $error_message;
						$mail_result = 0;
					} else {
						$mail_result = 1;
					}
				//}


				/*$mailing_user_query = "SELECT * FROM user_master WHERE 1=1 AND DEPT_ID=".$dept;
				$mailing_usaer_result =  db_one($mailing_user_query);
				//print_r($mailing_usaer_result);
						$name 	 = $mailing_usaer_result['NAME']; //user fullname
						$to 	 = $mailing_usaer_result['EMAIL']; //email id
						$subject = 'Resolution added on '.$res_date ;
						$message = 'Dear Section Head,</br>  <p>A Reolution titled <strong>'.$res_title.'</strong> has been added on <strong>'.$res_date.'</strong> in the Resolution Manager Software. <br/>Kindly check in your login and keep updating the status.</p>';
						$headers = "From: principalsoffice@git.edu" . "\r\n" .
				"CC: principal@git.edu
				From: Principal Office <principalsoffice@git.edu>\r\n"
								."Reply-To: Principal Office <principalsoffice@git.edu>\r\n"
								."Return-Path: Principal Office <principalsoffice@git.edu>\r\n"
								."MIME-Version: 1.0\r\n"	
								."Content-type: text/html; charset=UTF-8\r\n";

				$mail = mail($to,$subject,$message,$headers);
				
				if($mail){
								$mail_sent_result = 1;//Successful mail seding
								echo 'mail Sent';
							}else{
								$mail_sent_result = 0;//Unsuccessfull
								echo 'unable to send';
							}*/

				/*	//********************* Emailing the HOD/Section HeaD ************///
				/*$mailing_user_query = "SELECT * FROM user_master WHERE 1=1 AND DEPT_ID=".$dept;
				$mailing_usaer_result =  db_one($mailing_user_query);
				//print_r($mailing_usaer_result);
						$name 	 = $mailing_usaer_result['NAME']; //user fullname
						$email 	 = $mailing_usaer_result['EMAIL']; //email id
						$subject = 'Resolution added on '.$res_date ;
						$message = 'Dear Section Head,</br>  <p>A Reolution titled. '.$res_title.' has been added on '.$res_date.' in the Resolution Manager Software. Kindly check in your login and keep updating the status.</p>';

						$destination = $email; // email address of destination
					//echo $destination.'-'.$name.'-'.$subject.'-'.$message;
							$error = '';
						if($email && !validate_email($email))
							$error .= 'E-mail address is not valid!';
						echo $error;

						if(!$error){
							$mail = @mail($destination, $subject, $message,
								 "From: Principal Office <principaloffice@git.edu>\r\n"
								."Reply-To: Principal Office <principaloffice@git.edu>\r\n"
								."Return-Path: Principal Office <principaloffice@git.edu>\r\n"
								."MIME-Version: 1.0\r\n"	
								."Content-type: text/html; charset=UTF-8\r\n");
							
							if($mail){
								$mail_sent_result = 1;//Successful mail seding
								echo 'mail Sent';
							}else{
								$mail_sent_result = 0;//Unsuccessfull
								echo 'unable to send';
							}
						}else{
							$mail_sent_result = -1;//for the invalid email address.
							echo 'Invalid email';
						}*/


						//******************* Emailing Ends *******************//
				
				
				if($total_insert_result == 1){
		
				?>
				<div class="callout callout-success">
							<h4>Successful</h4>
							<?php //echo "The file ". htmlspecialchars( basename($res_doc)). " has been uploaded.";?>
							<p>Resolution Added. Mail Sent</p>
				</div>
				<?php }else{?>
					<div class="callout callout-danger">
						<h4>Unable to add resolution</h4>

						<p>Check Out.</p>
					  </div>
				<?php }
			
	}

	
			//file uploading Ends.	
			//echo $res_title.'-'.$cat_id.'-'.$res_status_id.'-'.$res_date.'-'.$dept.'-'.$res_no.'-'.$sanctioning_auth.'-'.$res_doc;
?>						  
