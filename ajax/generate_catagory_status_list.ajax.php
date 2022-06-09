 <?php ini_set('display_errors', 1); 
?><?php
	include('../pages/required/db_connection.php');
	include('../pages/required/tables.php');
	include('../pages/required/functions.php');
	
	$category_id = $_POST['c1'];
	
	$cat_status_query = "SELECT * FROM mr_status WHERE CID=".$category_id;
	$cat_status_result = db_all($cat_status_query);
	$status_str = "<select id='res_status_id' name='res_status_id' class='form-control'>
					<option value='0'>Choose One</option>";
	foreach($cat_status_result AS $csr){
		$status_str .="<option value='".$csr['SNO']."'>".$csr['RSTATUSNAME']."</option>";
	}
	echo $status_str;
	echo '</select>';
	?>