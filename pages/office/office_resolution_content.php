<div class="col-xs-12">
<!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#on-going" data-toggle="tab">On-Going</a></li>
      <li><a href="#completed" data-toggle="tab">Completed</a></li>
      <!--li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li-->
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="on-going">

					<div class="box box-info">
						<div class="box-header">
						  <h3 class="box-title"> Resolution List</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body" style="overflow:scroll;">
							<table id="example1" class="table table-bordered table-hover">
								<thead>
								<tr>
								  <th>SL.No</th>
								  <th>Resolution Title</th>
								  <th>Category</th>
								  <th>Res-Code /Res No</th>
								  <th>Resolution Date</th>
								  <th>Department</th>
								  <th>Sanctioning Authority</th>
								  <th>Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php 
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
													AND rm.status=1
													ORDER BY rm.SNO DESC";
								$res_rows = db_all($res_query);
								$office_str = "";
								$i = 1;
								foreach($res_rows AS $row){
									$office_str .="<tr>
											  <td>".$i."</td>
											  <td>".$row['RES_TITLE']."</td>
											  <td>".$row['CATEGORY']."</td>
											  <td>".$row['RESCODE']."/".$row['RESNO']."</td>
											  <td>".$row['res_date']."</td>
											  <td>".$row['deptname']."</td>
											  <td>".$row['AUTHORITY']."</td>
											  <td><button type='button' class='btn btn-primary' id='view_res' data-toggle='modal' data-target='#view_resolution".$row['SNO']."'> <i class='fa fa-eye'></i></button>
														<div class='modal fade' id='view_resolution".$row['SNO']."' role='dialog'>
														  <div class='modal-dialog modal-lg'>
															<div class='modal-content'>
																<div class='modal-header bg-primary'>
																	<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																	  <span aria-hidden='true'>&times;</span></button>
																	<h4 class='modal-title'>View Resolution</h4>
																</div>
																<div class='modal-body'>";
																	if($row['RES_IMAGE_URL'] == NULL || $row['RES_IMAGE_URL'] == "NULL"){
																		$office_str .="<p>
																		<pre>".$row['RES_TEXT']."</pre>
																		</p>";
																	} else {
																	$office_str .="<img src='uploads/".$row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																	}
															$office_str .="</div>
																<h3>Resolution Status</h3>
																			<!--Timeline Starts Here-->
																			<div class='padding'>";
																			//For printing the completed statues.
															//Excplicitly for displaying Category 5 resolutiuon status (Custom status)
																	if($row['CID'] == 5){
																		//For printing the completed statues.
																		$res_status_added_query = "SELECT 
																									*
																									,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																								   FROM 
																									res_status_master rsm
																								   WHERE 1=1 
																								   AND rsm.CID=5
																								   AND rsm.STATUS =1
																										AND rsm.RID=".$row['SNO'];
																		$res_status_added = db_all($res_status_added_query);
																		
																	
																		
																		//query to check the active (Current status value) to highlight.
																		$res_status_last_added_query = "SELECT 
																									*
																									,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																								   FROM 
																									res_status_master rsm
																								   WHERE 1=1 
																								   AND rsm.STATUS=1
																										AND rsm.RID=".$row['SNO']."
																									AND rsm.CID=5 
																									ORDER BY rsm.SNO desc
																									LIMIT 1;";
																		$res_status_last_added = db_all($res_status_last_added_query);
																		
														//echo $res_status_last_added[0]['SID'].'<br/>';
														$office_str .="<div class='row'>
																			<div class='col-md-12'>
																				<div class='timeline p-4 block mb-4'>";
																				//Status added query result.
																				$j=0;
																				foreach($res_status_added AS $added_row){
																					//for adding the active class just to indicate which one is the latest status updated.
																						$j++;
																							$office_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																								<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																								<div class='tl-content'>
																									<div class=''><h4>".$added_row['REMARK']."</h4></div>
																									<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																								</div>
																							</div>";
																							//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																							//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																						
																				}
																$office_str .="</div>
																			</div>
																			</div>
																		</div>";
																	// Timeline for catogories (1 to 4)
																}else{
													//For printing the completed statues.
													$res_status_added_query = "SELECT 
																				*
																				,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																			   FROM 
																				res_status_master rsm
																				INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID 
																			   WHERE 1=1 
																			   AND rsm.STATUS=1
																					AND RID=".$row['SNO'];
													$res_status_added = db_all($res_status_added_query);
													
													//$result_count = mysql_num_rows($res_status_added)		
													//for printing the remaining statuses to be updated.
													$res_status_remaining_query = "SELECT 
																			mrs.SNO,mrs.RSTATUSNAME
																		FROM 
																			mr_status mrs
																		WHERE 
																			1=1
																			AND mrs.CID=".$row['CID']."
																			AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$row['SNO'].")";
													$res_status_remaining = db_all($res_status_remaining_query);
													
													//query to check the active (Current status value) to highlight.
													$res_status_last_added_query = "SELECT 
																				*
																				,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																			   FROM 
																				res_status_master rsm
																				INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID 
																			   WHERE 1=1 
																			   AND rsm.STATUS=1
																					AND rsm.RID=".$row['SNO']."
																				ORDER BY rsm.SNO desc
																				LIMIT 1;";
													$res_status_last_added = db_all($res_status_last_added_query);
													
														//echo $res_status_last_added[0]['SID'].'<br/>';
														$office_str .="<div class='row'>
																				<div class='col-md-12'>
																					<div class='timeline p-4 block mb-4'>";
																					//Status added query result.
																					$j=0;
																					foreach($res_status_added AS $added_row){
																						//for adding the active class just to indicate which one is the latest status updated.
																							$j++;
																								$office_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																									<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																									<div class='tl-content'>
																										<div class=''><h4>".$added_row['RSTATUSNAME']."</h4></div>
																										<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																									</div>
																								</div>";
																								//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																								//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																							
																							
																					}
																					//echo $res_status_last_added[0]['SID'].'-'.$j.'<br/>';
																					//status remaining result.
																					foreach($res_status_remaining AS $rem_row){
																							$office_str .="<div class='tl-item'>
																								<div class='tl-dot b-warning'></div>
																								<div class='tl-content'>
																									<div class=''><h4>".$rem_row['RSTATUSNAME']."</h4></div>
																									<div class='tl-date text-muted mt-1'></h6>about to happen</h6></div>
																								</div>
																							</div>";
																					}
																	$office_str .="</div>
																				</div>
																			</div>
																		</div>";
																}	

														$office_str .="<div class='clearfix'></div>
																<div class='modal-footer'>
																	<button type='button' class='btn btn-default btn-flat' data-dismiss='modal'>Close</button>
																</div>
														</div>
														<!-- /.modal-content -->
													  </div>
													  <!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
													<button type='button' class='btn btn-warning' id='update_res' data-toggle='modal' data-target='#update_res".$row['SNO']."'> <i class='fa fa-edit'></i></button>
														<div class='modal fade' id='update_res".$row['SNO']."' role='dialog'>
														  <div class='modal-dialog modal-lg'>
															<div class='modal-content'>
																<div class='modal-header bg-warning'>
																	<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																	  <span aria-hidden='true'>&times;</span></button>
																	<h4 class='modal-title'> <i class='fa fa-edit'></i> Update Resolution</h4>
																</div>
																<span class='help-block'>
																	<div class='resolution_updated_notification'>
																		<div id='loading_image' style='display:none;'></div>
																	
																
															<form method='post' id='res_update' enctype='multipart/form-data' role='form'>
																<div class='modal-body'>
																	<div class='form-group col-md-12'>
																		<label class='help-block'>Resolution Title : <span class='text-danger'>*</span></label>
																		<input type='text' id='res_title' required name='res_title' class='form-control' placeholder='Enter a Title for resolution' value='".$row['RES_TITLE']."' />
																	</div>
																	<div class='clearfix'></div>
																	<div class='form-group col-md-6'>
																		<label class='help-block'>Resolution Category : <span class='text-danger'>*</span></label>
																		<select id='cat_id' required name='cat_id' class='form-control res_cat'>
																			<option value='0'>Choose One</option>";
								 
																			$Category_query = "SELECT CID,CATEGORY FROM mr_category WHERE 1=1";
																			$category_result = db_all($Category_query);
																			//$cr_str = "";
																			foreach($category_result AS $cr){
																				$office_str .="<option value=".$cr['CID']." ".($row['CID']==$cr['CID']?'selected':'')." class='help-block'>".$cr['CATEGORY']."</option>";
																			}
																			//echo $cr_str;
								
																		$office_str .="</select>
																	</div>
																	
																	<div class='form-group col-md-6'>
																		<label class='help-block'>Resolution Date: <span class='text-danger'>*</span></label>

																		<div class='input-group date'>
																		  <div class='input-group-addon'>
																			<i class='fa fa-calendar'></i>
																		  </div>
																		  <input type='text' required class='form-control pull-right res_date' name='res_date' id='datepicker' value='".ui_date($row['RESDATE'])."'>
																		</div>
																		<!-- /.input group -->
																	</div>
																	<div class='clearfix'></div>
																	<div class='form-group col-md-6'>
																		<label class='help-block'>Department : <span class='text-danger'>*</span></label>
																		<select id='dept' required name='dept' class='form-control'>
																			<option>Choose One</option>";
																		 
																			$Dept_query = "SELECT id,deptname FROM mr_department WHERE 1=1";
																			$Dept_result = db_all($Dept_query);
																			//$d_str = "";
																			foreach($Dept_result AS $d){
																				$office_str .="<option value=".$d['id']." ".($row['DEPT']==$d['id']?'selected':'')." class='help-block'>".$d['deptname']."</option>";
																			}
																			//echo $d_str;
																	
																		$office_str .="</select>
																	</div>
																	<div class='form-group col-md-6'>
																		<label class='help-block'>Resolution Number <span class=''></span></label>
																		<input type='text' class='form-control' id='res_no' name='res_no' placeholder='Enter the Resolution Number' value='".$row['RESNO']."' />
																	</div>
																	<div class='form-group col-md-6'>
																		<label class='help-block'>Sanctioning Authority : <span class='text-danger'>*</span></label>
																		<select id='sanctioning_auth' name='sanctioning_auth' required class='form-control'>
																			<option>Choose One</option>";
																		
																			$SancAuthority_query = "SELECT AID,AUTHORITY FROM mr_sancauthority WHERE 1=1";
																			$SancAuthority_result = db_all($SancAuthority_query);
																			//$sa_str = "";
																			foreach($SancAuthority_result AS $sa){
																				$office_str .="<option value='".$sa['AID']."' ".($row['AID']==$sa['AID']?'selected':'')." class='help-block'>".$sa['AUTHORITY']."</option>";
																			}
																			//echo $sa_str;
																	
																		$office_str .="</select>
																	</div>
																	<div class='clearfix'></div>
																	<!-- For re sending the Emails for updated resolution-->
																	<div class='form-group col-md-4'>
																		<label class='help-block'>Want to inform Concerned Person ? : <button class='btn btn-sm btn-primary extra_email'>Yes</button></label>
																		<!--This is where an input box appears, and if needed the resolution concerned to any person will be informed-->
																		
																	</div>
																	<div class='col-md-8'>
																		<div class='extra-info-mails input-group'></div>
																	</div>
																	<input type='hidden' name='res_id' value='".$row['SNO']."'>
																	<div class='clearfix'></div>";
																	if($row['RES_TEXT'] == NULL || $row['RES_TEXT'] == "NULL"){
																	
																		$office_str .="<div class='form-group col-md-12'>
																			<h5>The Image uploaded currently</h5>
																			<img src='uploads/".$row['RES_IMAGE_URL']."' width='250' height='250' alt='Image Not available'>
																		</div><div class='clearfix'></div>	";
																	}else{
																		$office_str .="<div class='form-group'>
																			<label class='help-block'>Resolution Text :<span class='text-danger'>*</span></label>
																			<div class='form-group' id='res_document' >".$row['RES_TEXT']."</div>
																		</div>
																		<div class='clearfix'></div>";
																	}
																	
																	$office_str .="<div class='clearfix'></div>
																	<div class='form-groupn row' style='align:center'>
																		<label class='help-block'>
																		  <input type='radio' name='optionsRadios'  class='optionsRadios3' value='1'>
																		  Upload Image
																		  &nbsp;&nbsp;&nbsp;&nbsp;
																		<!--/label>
																		<label class='help-block'-->
																		  <input type='radio' name='optionsRadios'  class='optionsRadios3' value='2'>
																		  Type the Text
																		</label>
																	</div>
																	<div class='clearfix'></div>
																			<div class='form-group upload_image hidden'>
																				<label class='help-block'>Resolution Image :<span class='text-danger'>*</span></label>
																				<input type='file'  name='res_image' class='res_image' accept='application/jpeg'/>
																				
																			</div>
																			<div class='form-group type_text hidden'>
																				<label class='help-block'>Resolution Text :<span class='text-danger'>*</span></label>
																				<textarea class='form-control' id='res_doc' name='res_doc' rows='30' cols='130'></textarea>
																				
																				
																			</div>
																			
																			<div class='clearfix'></div>
															</div>
																
															<div class='modal-footer'>
																<button type='button' class='btn btn-default pull-left btn-flat' data-dismiss='modal'>Close</button>
																<button type='reset' class='btn btn-default btn-flat'></i> Reset</button>
																<button type='submit' class='btn btn-primary btn-flat' id='add_resolution'><i class='fa fa-plus'></i> Update</button>
															</div>
														</form><!-- End of update form-->
																</div><!--End of notification -->
															</span><!-- End of span for notitfication-->

													</div>	
												</div>	
											</div>	
										</td>
									</tr>";
											$i++;
								}
									echo $office_str;
								?>	
							</tbody>
								
						</table>
						</div>
						<!-- /.box-body -->
					</div>
					  <!-- /.box -->
					  
				</div>
				
			<div class="clearfix"></div>
						 <!-- /.tab-pane -->
              <div class="tab-pane" id="completed">
              		<div class="box box-info">
						<div class="box-header">
						  <h3 class="box-title"> Resolution List</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body" style="overflow:scroll;">
							<table id="example1" class="table table-bordered table-hover">
								<thead>
								<tr>
								  <th>SL.No</th>
								  <th>Resolution Title</th>
								  <th>Category</th>
								  <th>Res-Code /Res No</th>
								  <th>Resolution Date</th>
								  <th>Department</th>
								  <th>Sanctioning Authority</th>
								  <th>Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php 
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
													AND rm.status=0
													ORDER BY rm.SNO DESC";
								$res_rows = db_all($res_query);
								$office_str = "";
								$i = 1;
								foreach($res_rows AS $row){
									$office_str .="<tr>
											  <td>".$i."</td>
											  <td>".$row['RES_TITLE']."</td>
											  <td>".$row['CATEGORY']."</td>
											  <td>".$row['RESCODE']."/".$row['RESNO']."</td>
											  <td>".$row['res_date']."</td>
											  <td>".$row['deptname']."</td>
											  <td>".$row['AUTHORITY']."</td>
											  <td><button type='button' class='btn btn-primary' id='view_res' data-toggle='modal' data-target='#view_resolution".$row['SNO']."'> <i class='fa fa-eye'></i></button>
														<div class='modal fade' id='view_resolution".$row['SNO']."' role='dialog'>
														  <div class='modal-dialog modal-lg'>
															<div class='modal-content'>
																<div class='modal-header bg-primary'>
																	<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																	  <span aria-hidden='true'>&times;</span></button>
																	<h4 class='modal-title'>View Resolution</h4>
																</div>
																<div class='modal-body'>";
																	if($row['RES_IMAGE_URL'] == NULL || $row['RES_IMAGE_URL'] == "NULL"){
																		$office_str .="<p>
																		<pre>".$row['RES_TEXT']."</pre>
																		</p>";
																	} else {
																	$office_str .="<img src='uploads/".$row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																	}
															$office_str .="</div>
																<h3>Resolution Status</h3>
																			<!--Timeline Starts Here-->
																			<div class='padding'>";
																			//For printing the completed statues.
															//Excplicitly for displaying Category 5 resolutiuon status (Custom status)
																	if($row['CID'] == 5){
																		//For printing the completed statues.
																		$res_status_added_query = "SELECT 
																									*
																									,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																								   FROM 
																									res_status_master rsm
																								   WHERE 1=1 
																								   AND rsm.STATUS=1
																								   AND rsm.CID=5
																										AND rsm.RID=".$row['SNO'];
																		$res_status_added = db_all($res_status_added_query);
																		
																	
																		
																		//query to check the active (Current status value) to highlight.
																		$res_status_last_added_query = "SELECT 
																									*
																									,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																								   FROM 
																									res_status_master rsm
																								   WHERE 1=1 
																								   AND rsm.STATUS=1
																										AND rsm.RID=".$row['SNO']."
																									AND rsm.CID=5 
																									ORDER BY rsm.SNO desc
																									LIMIT 1;";
																		$res_status_last_added = db_all($res_status_last_added_query);
																		
														//echo $res_status_last_added[0]['SID'].'<br/>';
														$office_str .="<div class='row'>
																			<div class='col-md-12'>
																				<div class='timeline p-4 block mb-4'>";
																				//Status added query result.
																				$j=0;
																				foreach($res_status_added AS $added_row){
																					//for adding the active class just to indicate which one is the latest status updated.
																						$j++;
																							$office_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																								<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																								<div class='tl-content'>
																									<div class=''><h4>".$added_row['REMARK']."</h4></div>
																									<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																								</div>
																							</div>";
																							//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																							//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																						
																				}
																$office_str .="</div>
																			</div>
																			</div>
																		</div>";
																	// Timeline for catogories (1 to 4)
																}else{
													//For printing the completed statues.
													$res_status_added_query = "SELECT 
																				*
																				,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																			   FROM 
																				res_status_master rsm
																				INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID 
																			   WHERE 1=1 
																					AND RID=".$row['SNO'];
													$res_status_added = db_all($res_status_added_query);
													
													//$result_count = mysql_num_rows($res_status_added)		
													//for printing the remaining statuses to be updated.
													$res_status_remaining_query = "SELECT 
																			mrs.SNO,mrs.RSTATUSNAME
																		FROM 
																			mr_status mrs
																		WHERE 
																			1=1
																			AND mrs.CID=".$row['CID']."
																			AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$row['SNO'].")";
													$res_status_remaining = db_all($res_status_remaining_query);
													
													//query to check the active (Current status value) to highlight.
													$res_status_last_added_query = "SELECT 
																				*
																				,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																			   FROM 
																				res_status_master rsm
																				INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID 
																			   WHERE 1=1 
																					AND rsm.RID=".$row['SNO']."
																				ORDER BY rsm.SNO desc
																				LIMIT 1;";
													$res_status_last_added = db_all($res_status_last_added_query);
													
														//echo $res_status_last_added[0]['SID'].'<br/>';
														$office_str .="<div class='row'>
																				<div class='col-md-12'>
																					<div class='timeline p-4 block mb-4'>";
																					//Status added query result.
																					$j=0;
																					foreach($res_status_added AS $added_row){
																						//for adding the active class just to indicate which one is the latest status updated.
																							$j++;
																								$office_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																									<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																									<div class='tl-content'>
																										<div class=''><h4>".$added_row['RSTATUSNAME']."</h4></div>
																										<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																									</div>
																								</div>";
																								//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																								//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																							
																							
																					}
																					//echo $res_status_last_added[0]['SID'].'-'.$j.'<br/>';
																					//status remaining result.
																					foreach($res_status_remaining AS $rem_row){
																							$office_str .="<div class='tl-item'>
																								<div class='tl-dot b-warning'></div>
																								<div class='tl-content'>
																									<div class=''><h4>".$rem_row['RSTATUSNAME']."</h4></div>
																									<div class='tl-date text-muted mt-1'></h6>about to happen</h6></div>
																								</div>
																							</div>";
																					}
																	$office_str .="</div>
																				</div>
																			</div>
																		</div>";
																}	

														$office_str .="<div class='clearfix'></div>
																<div class='modal-footer'>
																	<button type='button' class='btn btn-default btn-flat' data-dismiss='modal'>Close</button>
																</div>
														</div>
														<!-- /.modal-content -->
													  </div>
													  <!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
													
											</div>	
										</td>
									</tr>";
											$i++;
								}
									echo $office_str;
								?>	
							</tbody>
								
						</table>
						</div>
						<!-- /.box-body -->
					</div>
					  <!-- /.box -->
              </div>
			</div>
