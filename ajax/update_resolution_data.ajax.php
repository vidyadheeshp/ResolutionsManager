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
	// the primary key for updating the respective resolution entry
	$res_id = $_POST['res_id']; //primary Key
	
	$res_title = $_POST['res_title'];
	$cat_id = $_POST['cat_id'];
	$res_status_id = 1;//$_POST['res_status_id'];
	
	$res_date = db_date($_POST['res_date']);
	$dept = $_POST['dept'];
	$res_no = $_POST['res_no'];
	$sanctioning_auth = $_POST['sanctioning_auth'];
	$res_doc = $_POST['res_doc'];
	$res_image = $_FILES['res_image'];

	//echo $res_id.'-'.$res_title.'-'.$cat_id.'-'.$res_status_id.'-'.$res_date.'-'.$dept.'-'.$res_no.'-'.$sanctioning_auth.'-'.$_POST['res_doc'].'-'.$_FILES['res_image'];
	if(isset($_POST['extra-emails']))
		$Extra_emails = explode(",",$_POST['extra-emails']);
// for checking when no input is chosen while updating
	//checking for empty inputs
	if(empty($res_title) || $cat_id == 0 || $res_status_id == 0 || empty($res_date) || $dept == 0 || empty($res_no) || $sanctioning_auth == 0 ){
	?>
		<div class="callout callout-warning">
						<h4>Fill the details completely</h4>

						<p>Check Out.</p>
					  </div>
	<?php }else{
			
			//for checking whether the image input is set or no.
				$uploadDir = '../uploads/'; 
				$uploadStatus = 0; 
				$uploadedFile = ''; 
				if($res_image != ""){
					if($_FILES['res_image']['error'] == 0){
					//DB insertion 
						//for setting up the resolution code (Auto Generation)
						$sanc_auth_list = array('P', 'GCC', 'GC', 'BOM');
						date_default_timezone_set('Asia/Kolkata');
						$rescode = date('Ymd').$sanc_auth_list[$sanctioning_auth-1];
						$rescode= $rescode.date('hs');

						// Upload file 
						// File path config 
						$fileName = $rescode;//basename($_FILES["res_image"]["name"]); 
						$targetFilePath = $uploadDir . $fileName .".jpg"; 
						$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
						
						if(move_uploaded_file($_FILES["res_image"]["tmp_name"], $targetFilePath)){ 
								$uploadedFile = $fileName .".jpg";
								$uploadStatus = 1;
								$res_doc = ""; // required for checking the alternate field (Res Text - typed)is empty or not.							
												
								//data for inserting into DB.			
								$status = 1;
								$sno = 'NULL';
								//table 1 data
								$res_table_no = 1;
								$res_table_name = "res_master";
								//table 3 data.
								$res_status_table_no = 2;
								$res_status_table_name = "res_status_master";
										
								
						
				
								$res_set_values = 'RES_TITLE="'.$res_title.'",CID='.$cat_id.',DEPT='.$dept.',RESDATE="'.$res_date.'",RESCODE="'.$rescode.'",RESNO="'.$res_no.'",RES_IMAGE_URL="'.$uploadedFile.'",RES_TEXT="'.$res_doc.'",AID='.$sanctioning_auth.',CRDATE="'.date('Y-m-d').'"';
								//echo $res_insert_values;
								$res_where_val = "SNO=".$res_id;
								$res_update_result = db_update($res_table_name,$res_set_values,$res_where_val);
							//That itself is added to the res_status master as RID.
							//echo $Insert_result;
							$res_status_update_values = "CID=".$cat_id.",MDATE='".$res_date."'";
							$res_status_where_val= "RID=".$res_id." AND SID=1";
							$res_status_update_result = db_update($res_status_table_name,$res_status_update_values,$res_status_where_val);
							//echo $total_insert_result;
						}else{ 
							$uploadStatus = 0;
							$res_status_update_result=0; 							
						}	
					}
					//echo $res_update_result .'-'.$res_status_update_result;
				}
				//THE SECOND option - Typing the entire resolution text.
				//Checking if any one of resolution data is available or no.
				//If one of the type is available, the other value will be added as "NULL" in db.
				if($res_doc != '' && $_FILES['res_image']['error'] != 0){
					//echo 'Inside Else';
						$res_image = "";
						//echo 'Inside Elseif ';
						
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
						
							//first table update.
							$res_set_values = 'RES_TITLE="'.$res_title.'",CID='.$cat_id.',DEPT='.$dept.',RESDATE="'.$res_date.'",RESCODE="'.$rescode.'",RESNO="'.$res_no.'",RES_IMAGE_URL="NULL",RES_TEXT="'.$res_doc.'",AID='.$sanctioning_auth.',CRDATE="'.date('Y-m-d').'"';
							$res_where_val = "SNO=".$res_id;
							$res_update_result = db_update($res_table_name,$res_set_values,$res_where_val);
						//$res_where_val;
						//echo $res_set_values;
						
							//That itself is added to the res_status master as RID.
							//second table update
							$res_status_update_values = "CID=".$cat_id.",MDATE='".$res_date."'";
							$res_status_where_val= "RID=".$res_id." AND SID=1";
							$res_status_update_result = db_update($res_status_table_name,$res_status_update_values,$res_status_where_val);
							
				//echo $res_status_update_result;
				}

				//Mailing details
				$mailing_user_query = "SELECT * FROM user_master WHERE 1=1 AND DEPT_ID=".$dept;
				$mailing_usaer_result =  db_one($mailing_user_query);
				$mail_body = "Dear ".$mailing_usaer_result['NAME']." Head,</br>  <p>A Reolution titled <strong><h4>".$res_title."</h4></strong> has been added/updated on <strong>".$res_date."</strong> in the Resolution Manager Software. <br/>Kindly check in your login and keep updating the status.</p>";
				//$mail_result = mail_to($mailing_usaer_result['EMAIL'],$mailing_usaer_result['NAME'],$mail_body);

				require "../phpmailer/PHPMailerAutoload.php";

				$mail = new PHPMailer();

				//$mail->SMTPDebug = 2;                               // Enable verbose debug output

				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username =        // SMTP username
				$mail->Password =         // SMTP password
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

				$mail->Subject = 'Reg : Resolution updated/modified in Resolution Manager';
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
			// mailing Ends


				if($res_update_result==1 && $res_status_update_result == 1){
		
				?>
				<div class="callout callout-warning">
							<h4>Successful</h4>
							<?php //echo "The file ". htmlspecialchars( basename($res_doc)). " has been uploaded.";?>
							<p>Resolution Updated.</p>
				</div>
				<?php }else{?>
					<div class="callout callout-danger">
						<h4>Unable to update resolution</h4>

						<p>Check Out.</p>
					  </div>
				<?php }
	}		
				//file uploading Ends.	
			//echo $res_title.'-'.$cat_id.'-'.$res_status_id.'-'.$res_date.'-'.$dept.'-'.$res_no.'-'.$sanctioning_auth.'-'.$res_doc;
?>						  
