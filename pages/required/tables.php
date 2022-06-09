<?php 

	$tables = array(
		1 => 
			array (
				'res_master' => 'SNO, RES_TITLE, CID, DEPT, RESDATE, RESCODE, RESNO, RES_STATUS_ID, RES_IMAGE_URL, RES_TEXT, AID, CRDATE, STATUS'
				),
		2 => 
			array (
				'res_status_master' => 'SNO, RID, CID, SID, MDATE, REMARK, STATUS'
			),
		3 => 
			array (
				'booked_equipment' => 'sno, equipment_id, equipmet_name, descreiption, status'
			),
		4 => 
			array (
				'equipment_booking_log' => 'sno, booked_by, equipment_id, equip_detail_id, booked_date, from_time, to_time, description, equipment_status, status'
			),
		5 => 
			array (
				'calender_event' => 'id, title, booked_by, equip_id, start, end, url, allDay, doc_uploaded, description, is_confirmed, status'
			),
		6 => 
			array (
				'equipment_details' => 'sno, equipment_master_id, equipment_code, status'
			),
			
		7 => 
			array (
				'article_master' => 'sno, article_by, article_title, article_text, added_date, status'
			),
		8 => 
			array (
				'project_master' => 'sno, project_name, project_description, added_by, added_date, is_completed, status'
			),
		9 => 
			array (
				'project_members' => 'sno, project_id, member_id, task_id, status'
			),
		10=> 
			array (
				'task_master' => 'sno, task_name, task_description, added_by, added_date, for_the_project, is_completed, status'
			),
		11=> 
			array (
				'task_comments' => 'sno, task_id, comment_by, comment, commented_date, status'
			),
		12=> 
			array (
				'notification_master' => 'sno, notify_type, notification_desc, notify_to, added_date, added_time, is_viewed, status'
			),
		13=> 
			array (
				'leave_master' => 'sno, leave_by, leave_date, added_date, brief_note, is_approved, status'
			)
		);
		
		// foreach($tables AS $row){
			// echo $row[$key => $value]."<br/>";
			
		// }
		//print_r($tables[3]['patient_register']);
?>