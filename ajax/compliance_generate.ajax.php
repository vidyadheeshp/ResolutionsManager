<?php 
ini_set('display_errors', 1);
?>
<?php 


	include('../pages/required/db_connection.php');
	include('../pages/required/tables.php');
	require('../pages/required/functions.php');
	
	//data retrieval
	$res_date = db_date($_POST['p1']);

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



?> 
<div class="col-xs-12">
					<div class="box box-info">
						<div class="box-header">
						  <h3 class="box-title">GC Compliance Report for <?php echo ui_date($res_date); ?></h3>
						  <input type="hidden" class="compliance_date" value="<?php echo ui_date($res_date); ?>">
						  <button class="btn btn-success pull-right" id="export_btn"><i class="fa fa-download"></i> Export to Excel</button>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<?php $res_on_going_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=1 AND RESDATE='".$res_date."'";
								$res_ongoing_count = db_one($res_on_going_count_query);

								$res_Completed_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=0 AND RESDATE='".$res_date."'";
								$res_completed_count = db_one($res_Completed_count_query);
							?>
							<div class="col-md-12">
									<div class="col-md-3 col-sm-6">
						            <div class="counter orange">
						                <div class="counter-icon">
						                    <i class="fa fa-light fa-file"></i>
						                </div>
						                <h3>On-Going Resolutions (<?php echo ui_date($res_date);?>)</h3>
						                <span class="counter-value"><?php echo $res_ongoing_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter green">
						                <div class="counter-icon">
						                    <i class="fa fa-duotone fa-file"></i>
						                </div>
						                <h3>Completed Resolutions (<?php echo ui_date($res_date);?>)</h3>
						                <span class="counter-value"><?php echo $res_completed_count['res_count']?></span>
						            </div>
						        </div>

							</div>
							<div class="clearfix"></div>
							<table id="example1" class="table table-bordered table-hover compliance_report_table">
								<caption>GC Compliance Report for <?php echo ui_date($res_date); ?></caption>
								<thead>
								<tr>
								  <th>SL.No</th>
								  <th>GC -Resolution No</th>
								  <th>Resolution Title</th>
									<th>Category</th>
								  	<th>Department</th>
								  	<th>Current Status</th>
								  	<th>Modified Date</th>
								</tr>
								  
								</thead>
								<tbody>
								<?php 
								
								$res_str = "";
								$i = 1;
								if(!empty($res_rows)){
								foreach($res_rows AS $row){

									$current_status_query = "SELECT 
																rsm.MDATE
																,mrs.RSTATUSNAME 
														FROM res_status_master rsm 
														INNER JOIN mr_status mrs ON mrs.SNO=rsm.SID
														WHERE 
															1=1
															AND rsm.RID=".$row['SNO']." ORDER BY rsm.SID DESC LIMIT 1";
									//echo $current_status_query;
									$current_status_answer = db_one($current_status_query);
									$res_str .="<tr class='".($row['STATUS']==0 ? 'bg-olive':'bg-gray')."'>
											  <td>".$i."</td>
											  <td>".$row['RESNO']."</td>
											  <td>".$row['RES_TITLE']."</td>
											  <td>".$row['CATEGORY']."</td>
											  <td>".$row['deptname']."</td>
											  <td>".$current_status_answer['RSTATUSNAME']."</td>
											  <td>".$current_status_answer['MDATE']."</td>
											</tr>";
											$i++;

								}
							}else{
								$res_str .="<tr>
											<td colspan='7'>No GC Resolutions available.</td>
										</tr>";
							
							
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