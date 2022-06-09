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
	$RID = $_POST['c1'];
	$CID = $_POST['c2'];
	$SID = $_POST['c3'];
	$status_remark = $_POST['c4'];

	if($status_remark==""){
		$remark="NULL";
	}else{
		$remark=$status_remark;
	}
	date_default_timezone_set('Asia/Kolkata');
	$MDATE = date('Y-m-d');
	$status = 1;
	
	//$remark = '';
	//echo $RID.'-'.$CID.'-'.$SID;
	$res_status_table_no = 2;
	$res_status_table_name = "res_status_master";
	$res_status_insert_values = 'NULL,'.$RID.','.$CID.','.$SID.',"'.$MDATE.'","'.$remark.'",'.$status;
	
	$status_change_result = db_insert($res_status_table_no,$res_status_table_name,$res_status_insert_values);
	
	if(($CID == 2 && $SID == 9 )|| ($CID == 4 && $SID == 14)){
		$update_table_name = 'res_master';
		$update_table_SET = "STATUS = 0";
		$update_table_WHERE = "SNO=".$RID;
		$update_result = db_update($update_table_name,$update_table_SET,$update_table_WHERE);
		
	}
	
	if($status_change_result == 1){
	
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