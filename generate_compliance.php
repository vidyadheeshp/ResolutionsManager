<?php 

	include('pages/required/db_connection.php');
	include('pages/required/tables.php');
	require('pages/required/functions.php');

	$res_date = db_date($_POST['date_val']);//12;
	$res_query = "SELECT rm.*
													,mrc.CATEGORY
													,mrd.deptname
													,mrs.AUTHORITY
													,DATE_FORMAT(rm.RESDATE,'%D-%b-%Y') AS res_date
											  FROM 
													res_master rm 
													INNER JOIN mr_category mrc ON mrc.CID=rm.CID
													INNER JOIN mr_department mrd ON mrd.id=rm.DEPT
													INNER JOIN mr_sancauthority mrs ON mrs.AID=rm.AID
											   WHERE 
													1=1 
													AND rm.RESDATE='".$res_date."'";
								$res_rows = db_all($res_query);
								
	if(isset($_POST['ExportType'])){
		switch($_POST['ExportType']){
			case 'export_btn':
			 $filename = "compliance_report_".date('Ymd').".xls";
			 header("Content-Type: application/vnd.ms-excel");
			 header("Content-Dispostion: attachment; filename=\"$filename\"");
			 ExportFile($res_rows);
			 exit();
			default :
				die('Unknown Action');
				break;
		}
	}
	
	function ExportFile($records){
		$heading = false;
		if(!empty($records)){
			foreach($records AS $row){
			if(!$heading)
				echo implode("\t",array_keys($row))."\n";
				$heading = true;
			}
			echo implode("\t",array_keys($row))."\n";
		}
		exit;
	}
?>