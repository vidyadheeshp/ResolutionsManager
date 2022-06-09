<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#on-going" data-toggle="tab">On-Going</a></li>
              <li><a href="#completed" data-toggle="tab">Completed</a></li>
              <!--li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li-->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="on-going">
				<div class="col-xs-12 col-lg-12 col-md-12 col-sm-6">
					<div class="box box-info">
						<div class="box-header">
						  <h3 class="box-title">Resolution List</h3>
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
							$princ_res_query = "SELECT 
												rm.*
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
							$princ_res_rows = db_all($princ_res_query);
							$res_str = "";
							$i = 1;
							foreach($princ_res_rows AS $princ_row){
								$res_str .="<tr>
										  <td>".$i."</td>
										  <td>".$princ_row['RES_TITLE']."</td>
										  <td>".$princ_row['CATEGORY']."</td>
										  <td>".$princ_row['RESCODE']." / ".$princ_row['RESNO']."</td>
										  <td>".$princ_row['res_date']."</td>
										  <td>".$princ_row['deptname']."</td>
										  <td>".$princ_row['AUTHORITY']."</td>
										  <td><button type='button' class='btn btn-warning' id='view_res' data-toggle='modal' data-target='#view_resolution".$princ_row['SNO']."'> <i class='fa fa-eye'></i></button>
													<div class='modal fade' id='view_resolution".$princ_row['SNO']."' role='dialog'>
													  <div class='modal-dialog modal-lg'>
														<div class='modal-content'>
															<div class='modal-header bg-primary'>
																<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																  <span aria-hidden='true'>&times;</span></button>
																<h4 class='modal-title'>View Resolution</h4>
															</div>
															<div class='modal-body'>";
																if($princ_row['RES_IMAGE_URL'] == NULL || $princ_row['RES_IMAGE_URL'] == "NULL"){
																	$res_str .="<p>
																	<pre>".$princ_row['RES_TEXT']."</pre>
																	</p>";
																	} else {
																	$res_str .="<img src='uploads/".$princ_row['RES_IMAGE_URL']."' height='300px' width='500px' alt='Image' class='zoom'/>";
																	}
															$res_str .="</div><div class='clearfix'></div>
																				<h3>Resolution Status</h3>
																						<!--Timeline Starts Here-->
																						<div class='padding'>";
																				if($princ_row['CID'] == 5){
																								//For printing the completed statues.
																								$res_status_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																														   AND rsm.CID=5
																																AND rsm.RID=".$princ_row['SNO'];
																								$res_status_added = db_all($res_status_added_query);
																								
																							
																								
																								//query to check the active (Current status value) to highlight.
																								$res_status_last_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$princ_row['SNO']."
																															AND rsm.CID=5 
																															ORDER BY rsm.SNO desc
																															LIMIT 1;";
																								$res_status_last_added = db_all($res_status_last_added_query);
																								
																									//echo $res_status_last_added[0]['SID'].'<br/>';
																									$res_str .="<div class='row'>
																															<div class='col-md-12'>
																																<div class='timeline p-4 block mb-4'>";
																																//Status added query result.
																																$j=0;
																																foreach($res_status_added AS $added_row){
																																	//for adding the active class just to indicate which one is the latest status updated.
																																		$j++;
																																			$res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																																				<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																																				<div class='tl-content'>
																																					<div class=''><h4>".$added_row['REMARK']."</h4></div>
																																					<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																																				</div>
																																			</div>";
																																			//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																																			//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																																		
																																}
																												$res_str .="</div>
																															</div>
																														</div>
																													</div>	
																												<!--Timeline (for Category 5 )Ends here-->";
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
																									   AND rsm.STATUS = 1
																											AND RID=".$princ_row['SNO'];
																			$res_status_added = db_all($res_status_added_query);
																			
																			//$result_count = mysql_num_rows($res_status_added)		
																			//for printing the remaining statuses to be updated.
																			$res_status_remaining_query = "SELECT 
																									mrs.SNO,mrs.RSTATUSNAME
																								FROM 
																									mr_status mrs
																								WHERE 
																									1=1
																									AND mrs.CID=".$princ_row['CID']."
																									AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$princ_row['SNO'].")";
																			$res_status_remaining = db_all($res_status_remaining_query);
																			
																			//query to check the active (Current status value) to highlight.
																			$res_status_last_added_query = "SELECT 
																										*
																										,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																									   FROM 
																										res_status_master rsm
																										INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID 
																									   WHERE 1=1 
																									   AND rsm.STATUS = 1
																											AND rsm.RID=".$princ_row['SNO']."
																										ORDER BY rsm.SNO desc
																										LIMIT 1;";
																			$res_status_last_added = db_all($res_status_last_added_query);
																			
																				//echo $res_status_last_added[0]['SID'].'<br/>';
																				$res_str .="<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
																											//Status added query result.
																											$j=0;
																											foreach($res_status_added AS $added_row){
																												//for adding the active class just to indicate which one is the latest status updated.
																													$j++;
																														$res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
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
																													$res_str .="<div class='tl-item'>
																														<div class='tl-dot b-warning'></div>
																														<div class='tl-content'>
																															<div class=''><h4>".$rem_row['RSTATUSNAME']."</h4></div>
																															<div class='tl-date text-muted mt-1'></h6>about to happen</h6></div>
																														</div>
																													</div>";
																											}
																							$res_str .="</div>
																										</div>
																									</div>
																								</div>
																							<!--Timeline Ends here-->";
																						}	

																		$res_str .="
																			<div class='clearfix'></div>
															<div class='modal-footer'>
																<button type='button' class='btn btn-default btn-flat' data-dismiss='modal'>Close</button>
															</div>
													</div>
													<!-- /.modal-content -->
												  </div>
												  <!-- /.modal-dialog -->
												</div>
												<!-- /.modal -->
											</td>
										</tr>";
										$i++;
							}
								echo $res_str;
							?>
							
							
							
							</tbody>
							
						  </table>
						</div>
						<!-- /.box-body -->
					</div>
					  <!-- /.box -->
				</div>
				
						<div class="clearfix"></div>
			</div>
			  
              <!-- /.tab-pane -->
      <div class="tab-pane" id="completed">
				<div class="col-xs-12 col-lg-12 col-md-12 col-sm-6">
					<div class="box box-info">
						<div class="box-header">
						  <h3 class="box-title">Resolution List</h3>
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
							$princ_res_query = "SELECT 
												rm.*
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
							$princ_res_rows = db_all($princ_res_query);
							$res_str = "";
							$i = 1;
							foreach($princ_res_rows AS $princ_row){
								$res_str .="<tr>
										  <td>".$i."</td>
										  <td>".$princ_row['RES_TITLE']."</td>
										  <td>".$princ_row['CATEGORY']."</td>
										  <td>".$princ_row['RESCODE']." / ".$princ_row['RESNO']."</td>
										  <td>".$princ_row['res_date']."</td>
										  <td>".$princ_row['deptname']."</td>
										  <td>".$princ_row['AUTHORITY']."</td>
										  <td><button type='button' class='btn btn-warning' id='view_res' data-toggle='modal' data-target='#view_resolution".$princ_row['SNO']."'> <i class='fa fa-eye'></i></button>
															<div class='modal fade' id='view_resolution".$princ_row['SNO']."' role='dialog'>
															  <div class='modal-dialog modal-lg'>
																<div class='modal-content'>
																	<div class='modal-header bg-primary'>
																		<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																		  <span aria-hidden='true'>&times;</span></button>
																		<h4 class='modal-title'>View Resolution</h4>
																	</div>
																	<div class='modal-body'>";
																		if($princ_row['RES_IMAGE_URL'] == NULL){
																			$res_str .="<p>
																			<pre>".$princ_row['RES_TEXT']."</pre>
																			</p>";
																			} else {
																			$res_str .="<img src='uploads/".$princ_row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																			}
																	$res_str .="</div><div class='clearfix'></div>
																						<h3>Resolution Status</h3>
																								<!--Timeline Starts Here-->
																								<div class='padding'>";
																				if($princ_row['CID'] == 5){
																								//For printing the completed statues.
																								$res_status_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1
																														   AND rsm.STATUS = 1 
																														   AND rsm.CID=5
																																AND rsm.RID=".$princ_row['SNO'];
																								$res_status_added = db_all($res_status_added_query);
																								
																							
																								
																								//query to check the active (Current status value) to highlight.
																								$res_status_last_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$princ_row['SNO']."
																															AND rsm.CID=5 
																															ORDER BY rsm.SNO desc
																															LIMIT 1;";
																								$res_status_last_added = db_all($res_status_last_added_query);
																								
																									//echo $res_status_last_added[0]['SID'].'<br/>';
																									$res_str .="<div class='row'>
																															<div class='col-md-12'>
																																<div class='timeline p-4 block mb-4'>";
																																//Status added query result.
																																$j=0;
																																foreach($res_status_added AS $added_row){
																																	//for adding the active class just to indicate which one is the latest status updated.
																																		$j++;
																																			$res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																																				<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																																				<div class='tl-content'>
																																					<div class=''><h4>".$added_row['REMARK']."</h4></div>
																																					<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																																				</div>
																																			</div>";
																																			//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																																			//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																																		
																																}
																												$res_str .="</div>
																															</div>
																														</div>
																												<!--Timeline (for Category 5 )Ends here-->";
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
																									   AND rsm.STATUS = 1
																											AND RID=".$princ_row['SNO'];
																			$res_status_added = db_all($res_status_added_query);
																			
																			//$result_count = mysql_num_rows($res_status_added)		
																			//for printing the remaining statuses to be updated.
																			$res_status_remaining_query = "SELECT 
																									mrs.SNO,mrs.RSTATUSNAME
																								FROM 
																									mr_status mrs
																								WHERE 
																									1=1
																									AND mrs.CID=".$princ_row['CID']."
																									AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$princ_row['SNO'].")";
																			$res_status_remaining = db_all($res_status_remaining_query);
																			
																			//query to check the active (Current status value) to highlight.
																			$res_status_last_added_query = "SELECT 
																										*
																										,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																									   FROM 
																										res_status_master rsm
																										INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID 
																									   WHERE 1=1 
																									   AND rsm.STATUS = 1
																											AND rsm.RID=".$princ_row['SNO']."
																										ORDER BY rsm.SNO desc
																										LIMIT 1;";
																			$res_status_last_added = db_all($res_status_last_added_query);
																			
																				//echo $res_status_last_added[0]['SID'].'<br/>';
																				$res_str .="<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
																											//Status added query result.
																											$j=0;
																											foreach($res_status_added AS $added_row){
																												//for adding the active class just to indicate which one is the latest status updated.
																													$j++;
																														$res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
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
																													$gcc_res_str .="<div class='tl-item'>
																														<div class='tl-dot b-warning'></div>
																														<div class='tl-content'>
																															<div class=''><h4>".$rem_row['RSTATUSNAME']."</h4></div>
																															<div class='tl-date text-muted mt-1'></h6>about to happen</h6></div>
																														</div>
																													</div>";
																											}
																							$res_str .="</div>
																										</div>
																									</div>
																								</div>
																							<!--Timeline Ends here-->";
																						}	
																					$res_str .="<div class='clearfix'></div>
																	<div class='modal-footer'>
																		<button type='button' class='btn btn-default btn-flat' data-dismiss='modal'>Close</button>
																	</div>
															</div>
															<!-- /.modal-content -->
														  </div>
														  <!-- /.modal-dialog -->
														</div>
														<!-- /.modal -->
												</td>
										</tr>";
										$i++;
							}
								echo $res_str;
							?>
							
							
							
							</tbody>
							
						  </table>
						</div>
						<!-- /.box-body -->
					</div>
					  <!-- /.box -->
				</div>
						<div class="clearfix"></div>
			  </div>
              <!-- /.tab-pane -->
              
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
		
		
		