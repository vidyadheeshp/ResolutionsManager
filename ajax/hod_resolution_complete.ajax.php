<?php 
	if (session_id() == '') {
    session_start();
	//$_SESSION['first_name']=$result[0];
	$login_id = $_SESSION['s_id'];
}
	include('../pages/required/db_connection.php');
	include('../pages/required/tables.php');
	require('../pages/required/functions.php');
	
	//data retrieval
	$RID = $_POST['R1'];
	
	date_default_timezone_set('Asia/Kolkata');
	$MDATE = date('Y-m-d');
	$status = 1;
	
	$update_table_name = 'res_master';
	$update_table_SET = "STATUS = 0";
	$update_table_WHERE = "SNO=".$RID;
	$update_result = db_update($update_table_name,$update_table_SET,$update_table_WHERE);

	if($update_result == 1){
	
	?>
	<div class="callout callout-success">
				<h4>Successful</h4>
				<?php //echo "The file ". htmlspecialchars( basename($res_doc)). " has been uploaded.";?>
				<p>Resolution Status Modified.</p>
	</div>
	<?php }else{?>
		<div class="callout callout-danger">
								<h4>Unable to Modify resolution</h4>

								<p>Check Out.</p>
							  </div>
	<?php }?>						  