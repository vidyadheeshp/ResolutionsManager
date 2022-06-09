<?php ini_set('display_errors', 1);
 ini_set('MAX_EXECUTION_TIME', '-1');
	if (session_id() == '') {
    session_start();
	$login_id = $_SESSION['s_id'];
	$dept_id = $_SESSION['dept'];
}

 if(!isset($_SESSION['logged_in'])) {
      header("Location: login.php"); 
 }  
include('pages/required/db_connection.php');
include('pages/required/functions.php');
include('pages/required/tables.php');
	$loggen_in_query = "SELECT 
									um.*
									,DATE_FORMAT(um.CDATE, '%b %Y') AS member_since
								FROM 
									user_master um
								WHERE
									1=1
									AND um.SNO=".$login_id;
			$login_query_result = db_one($loggen_in_query);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ResManager | Resolution List</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!--Custom CSS file for bootstrap timeline-->
  <link rel="stylesheet" href="bootstrap/css/timeline.css">
  <link rel="stylesheet" href="bootstrap/css/timeline-css.css">
 
<!------ Include the above in your HEAD tag ---------->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
 <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css" media="print">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

   <link rel="stylesheet" href="bootstrap/css/image-zoom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <style>
	#datepicker{z-index:1151 !important;}
	.notification_bg_color{background:#C9C5C5}
	#loading_image {
		  position:fixed;
		  top:0px;
		  right:0px;
		  width:100%;
		  height:100%;
		  background-color:#c1bdbb;
		  background-image:url('images/loading_processmaker.gif');
		  background-repeat:no-repeat;
		  background-position:center;
		  z-index:10000000;
		  opacity: 0.4;
	}
	
	.hiddenRow{
		padding : 0 !important;
	}
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"> <b>RM</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>RM</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
			 <!-- Notifications: style can be found in dropdown.less -->
			<li class="dropdown notifications-menu">
				<?php 
					/*$logged_in_member = $login_id;
					$notification_count_query ="SELECT UDF_NOTIFICATION_COUNT(".$logged_in_member.") AS n_count";
					$notification_count = db_one($notification_count_query);*/
						?>
				<a href="#" class="dropdown-toggle notify_drdw" data-toggle="dropdown">
				  <i class="fa fa-bell-o"></i>
				  <span class="label label-warning"><?php //(print_r($notification_count['n_count']));?></span>
				</a>
				<ul class="dropdown-menu">
				  <li class="header">You have <?php //print_r($notification_count['n_count'] == 0 ? 0 : $notification_count['n_count']);?> notifications</li>
				  <li>
					<!-- inner menu: contains the actual data -->
					<ul class="menu">
					<?php 
						/*$i=1;
						$nr_str = '';
						$notification_query ="SELECT 
												nm.*  
												,mnt.notification_code
											FROM 
												notification_master nm
												INNER JOIN meta_notification_type mnt ON mnt.sno=nm.notify_type
											WHERE 
												1=1 AND nm.added_date = CURDATE() 
												AND nm.notify_to = ".$_SESSION['s_id']." OR nm.notify_to = 0
											ORDER BY 
												nm.added_date DESC";
					$notification_result = db_all($notification_query);
					if(!(empty($notification_result))){
						foreach($notification_result AS $nr){
							if($nr[3] == $_SESSION['s_id']){
								$nr_str .='<li>
									<input type="hidden" class="notification_id" value="'.$nr[0].'">
									<a  title="'.$nr[2].'" class="'.($nr[6]== 0 ? 'notification_bg_color' : '').' equipment_adding_notification">'
									  .$nr[8].$nr[2].'
									</a>
									
								  </li>';
								}else{
									$nr_str .='<li>
									<input type="hidden" class="notification_id" value="'.$nr[0].'">
									<a  title="'.$nr[2].'" class="'.($nr[6]== 0 ? 'notification_bg_color' : '').' equipment_adding_notification">'
									  .$nr[8].$nr[2].'
									</a>
									
								  </li>';
								}
							
						  $i++;
						}
					}else{
						$nr_str .='<li align="center">No Notifications</li>';
					}
						echo $nr_str;*/
					?>
					</ul>
				  </li>
				  <li class="footer"><a href="view_all_notifications.php">View all</a></li>
				</ul>
			</li>
						
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="images/GIT-logo.jpg<?php //echo ($login_query_result['pro_image'] == NULL ? 'boxed-bg.jpg' : $login_query_result['pro_image']);?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php if(isset($_SESSION['name'])) {
					  echo  $_SESSION['name'];
					}?>
			   </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="images/GIT-logo.jpg<?php //echo ($login_query_result['pro_image'] == NULL ? 'boxed-bg.jpg' : $login_query_result['pro_image']);?>" class="img-circle" alt="User Image">

                <p>
                  <?php if(isset($_SESSION['name'])) {
						   echo  $_SESSION['name'];
						}?>
                  <small>Member since <?php echo $login_query_result ['member_since'];?></small>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
			 
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		  <!-- Sidebar user panel -->
		  <div class="user-panel">
			<div class="pull-left image">
			  <img src="images/GIT-logo.jpg<?php //echo ($login_query_result['pro_image'] == NULL ? 'boxed-bg.jpg' : $login_query_result['pro_image']);?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
			  <p><?php if(isset($_SESSION['name'])) {echo  $_SESSION['name'];}?></p>
			 <?php if($login_query_result ['USERTYPE'] == 1 || $login_query_result ['USERTYPE'] == 2 || $login_query_result ['USERTYPE'] == 6){?>
				  <a href="#"><i class="fa fa-circle text-success"></i> Admin</a>
				<?php }else{?>
				  <a href="#"><i class="fa fa-circle text-aqua"></i> User</a>
				<?php }?>
			</div>
		  </div>
		  <span style="height:50px;" id="clock" class="form-control" value=""></span>
		  <!-- search form >
		  <form action="#" method="get" class="sidebar-form">
			<div class="input-group">
			  <input type="text" name="q" class="form-control" placeholder="Search...">
				  <span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
					</button>
				  </span>
			</div>
		  </form>
		<.sidebar -->
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<?php //principal Section
				if($login_query_result['USERTYPE'] == 1){
			?>
			<li >
			  <a href="index.php">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li class="active treeview">
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li class="treeview">
			  <a href="view_equipment.php">
				<i class="fa fa-pencil"></i>
				<span>Follow Ups</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
				</a>
			</li>
			<?php //GC-Chairman Section
			}else if($login_query_result['USERTYPE'] == 2){?>
				<li >
			  <a href="index.php">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li class="active treeview">
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li class="treeview">
			  <a href="view_equipment.php">
				<i class="fa fa-pencil"></i>
				<span>Follow Ups</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
				</a>
			</li>
			<?php //HOD / Section Head
			}else if($login_query_result['USERTYPE'] == 3){?>
					<!--h2>HOD /Section Head area</h2-->
			<li >
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li class="active">
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<?php //Office Section
			}else if($login_query_result['USERTYPE'] == 4){?>
				<li >
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li class="active">
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<?php //Payment Section
			}else if($login_query_result['USERTYPE'] == 5){?>
				<li >
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
				<li class="active">
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			
			<?php //ADMiN /Super ADMiN section.
			} else {?>
					<li >
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
				<li class="active">
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<?php }?>
		</ul>
	</section>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<!--use the below section for adding content header-->
    <section class="content-header">
      <h1>
        Resolution List
        <!--small>Control panel</small-->
      </h1>
      <ol class="breadcrumb">
        <li class=""> Home</li>
        <li class="active"> List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
      </div>
      <!-- /.row -->
      <!-- Main row -->
        <div class="row">
			<!-- Left col -->
			<section class="col-lg-12 connectedSortable">
				<?php //principal Section
				if($login_query_result['USERTYPE'] == 1){
				
				//This is the file with index content of Principal. 
				include('pages/principal/principal_resolution_content.php');
				
				//GC- Chairman Section
				}else if($login_query_result['USERTYPE'] == 2){
			?>
				<div class="col-md-12">
				  <!-- Custom Tabs -->
				  <div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					  <li class="active"><a href="#on_going" data-toggle="tab">On-Going</a></li>
					  <li><a href="#completed" data-toggle="tab">Completed</a></li>
					 
					  <!--li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li-->
					</ul>
					<div class="tab-content">
					  <div class="tab-pane active" id="on_going">
						<div class="col-xs-12 col-md-12 col-sm-6">
							<div class="box box-info">
								<div class="box-header">
								  <h3 class="box-title"> On Going List</h3>
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
									$gcc_res_query = "SELECT rm.*
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
									$gcc_res_rows = db_all($gcc_res_query);
									$gcc_res_str = "";
									$i = 1;
									foreach($gcc_res_rows AS $gcc_row){
										$gcc_res_str .="<tr>
												  <td>".$i."</td>
												  <td>".$gcc_row['RES_TITLE']."</td>
												  <td>".$gcc_row['CATEGORY']."</td>
												  <td>".$gcc_row['RESCODE']."/".$gcc_row['RESNO']."</td>
												  <td>".$gcc_row['res_date']."</td>
												  <td>".$gcc_row['deptname']."</td>
												  <td>".$gcc_row['AUTHORITY']."</td>
												  <td><button type='button' class='btn btn-warning' id='view_res' data-toggle='modal' data-target='#view_resolution".$gcc_row['SNO']."'> <i class='fa fa-eye'></i></button>
															<div class='modal fade' id='view_resolution".$gcc_row['SNO']."' role='dialog'>
															  <div class='modal-dialog modal-lg'>
																<div class='modal-content'>
																	<div class='modal-header bg-primary'>
																		<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																		  <span aria-hidden='true'>&times;</span></button>
																		<h4 class='modal-title'>View Resolution</h4>
																	</div>
																	<div class='modal-body'>";
																	if($gcc_row['RES_IMAGE_URL'] == NULL){
																		$gcc_res_str .="<p>
																		<pre>".$gcc_row['RES_TEXT']."</pre>
																		</p>";
																		} else {
																		$gcc_res_str .="<img src='uploads/".$gcc_row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																		}
																$gcc_res_str .="</div>
																<div class='clearfix'></div>
																			<h3>Resolution Status</h3>
																					<!--Timeline Starts Here-->
																					<div class='padding'>";
																					if($gcc_row['CID'] == 5){
																								//For printing the completed statues.
																								$res_status_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																														   AND rsm.CID=5
																																AND rsm.RID=".$gcc_row['SNO'];
																								$res_status_added = db_all($res_status_added_query);
																								
																							
																								
																								//query to check the active (Current status value) to highlight.
																								$res_status_last_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$gcc_row['SNO']."
																															AND rsm.CID=5 
																															ORDER BY rsm.SNO desc
																															LIMIT 1;";
																								$res_status_last_added = db_all($res_status_last_added_query);
																								
																									//echo $res_status_last_added[0]['SID'].'<br/>';
																									$gcc_res_str .="<div class='row'>
																															<div class='col-md-12'>
																																<div class='timeline p-4 block mb-4'>";
																																//Status added query result.
																																$j=0;
																																foreach($res_status_added AS $added_row){
																																	//for adding the active class just to indicate which one is the latest status updated.
																																		$j++;
																																			$gcc_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																																				<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																																				<div class='tl-content'>
																																					<div class=''><h4>".$added_row['REMARK']."</h4></div>
																																					<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																																				</div>
																																			</div>";
																																			//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																																			//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																																		
																																}
																												$gcc_res_str .="</div>
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
																											AND RID=".$gcc_row['SNO'];
																			$res_status_added = db_all($res_status_added_query);
																			
																			//$result_count = mysql_num_rows($res_status_added)		
																			//for printing the remaining statuses to be updated.
																			$res_status_remaining_query = "SELECT 
																									mrs.SNO,mrs.RSTATUSNAME
																								FROM 
																									mr_status mrs
																								WHERE 
																									1=1

																									AND mrs.CID=".$gcc_row['CID']."
																									AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$gcc_row['SNO'].")";
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
																											AND rsm.RID=".$gcc_row['SNO']."
																										ORDER BY rsm.SNO desc
																										LIMIT 1;";
																			$res_status_last_added = db_all($res_status_last_added_query);
																			
																				//echo $res_status_last_added[0]['SID'].'<br/>';
																				$gcc_res_str .="<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
																											//Status added query result.
																											$j=0;
																											foreach($res_status_added AS $added_row){
																												//for adding the active class just to indicate which one is the latest status updated.
																													$j++;
																														$gcc_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
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
																							$gcc_res_str .="</div>
																										</div>
																									</div>
																								</div>
																							<!--Timeline Ends here-->";
																						}	

																		$gcc_res_str .="
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
										echo $gcc_res_str;
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
					  <!-- /.Completed Tab -->
					  <div class="tab-pane" id="completed">
						<div class="col-xs-12 col-md-12 col-sm-12">
							<div class="box box-info">
								<div class="box-header">
								  <h3 class="box-title"> Completed List</h3>
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
									$gcc_res_query = "SELECT rm.*
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
									$gcc_res_rows = db_all($gcc_res_query);
									$gcc_res_str = "";
									$i = 1;
									foreach($gcc_res_rows AS $gcc_row){
										$gcc_res_str .="<tr>
												  <td>".$i."</td>
												  <td>".$gcc_row['RES_TITLE']."</td>
												  <td>".$gcc_row['CATEGORY']."</td>
												  <td>".$gcc_row['RESCODE']."/".$gcc_row['RESNO']."</td>
												  <td>".$gcc_row['res_date']."</td>
												  <td>".$gcc_row['deptname']."</td>
												  <td>".$gcc_row['AUTHORITY']."</td>
												  <td><button type='button' class='btn btn-warning' id='view_res' data-toggle='modal' data-target='#view_resolution".$gcc_row['SNO']."'> <i class='fa fa-eye'></i></button>
															<div class='modal fade' id='view_resolution".$gcc_row['SNO']."' role='dialog'>
															  <div class='modal-dialog modal-lg'>
																<div class='modal-content'>
																	<div class='modal-header bg-primary'>
																		<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																		  <span aria-hidden='true'>&times;</span></button>
																		<h4 class='modal-title'>View Resolution</h4>
																	</div>
																	<div class='modal-body'>";
																	if($gcc_row['RES_IMAGE_URL'] == NULL || $gcc_row['RES_IMAGE_URL'] == "NULL"){
																		$gcc_res_str .="<p>
																		<pre>".$gcc_row['RES_TEXT']."</pre>
																		</p>";
																		} else {
																		$gcc_res_str .="<img src='uploads/".$gcc_row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																		}
																$gcc_res_str .="</div>
																<div class='clearfix'></div>
																			<h3>Resolution Status</h3>
																					<!--Timeline Starts Here-->
																					<div class='padding'>";
																					if($gcc_row['CID'] == 5){
																								//For printing the completed statues.
																								$res_status_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																														   AND rsm.CID=5
																																AND rsm.RID=".$gcc_row['SNO'];
																								$res_status_added = db_all($res_status_added_query);
																								
																							
																								
																								//query to check the active (Current status value) to highlight.
																								$res_status_last_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$gcc_row['SNO']."
																															AND rsm.CID=5 
																															ORDER BY rsm.SNO desc
																															LIMIT 1;";
																								$res_status_last_added = db_all($res_status_last_added_query);
																								
																									//echo $res_status_last_added[0]['SID'].'<br/>';
																									$gcc_res_str .="<div class='row'>
																															<div class='col-md-12'>
																																<div class='timeline p-4 block mb-4'>";
																																//Status added query result.
																																$j=0;
																																foreach($res_status_added AS $added_row){
																																	//for adding the active class just to indicate which one is the latest status updated.
																																		$j++;
																																			$gcc_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																																				<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																																				<div class='tl-content'>
																																					<div class=''><h4>".$added_row['REMARK']."</h4></div>
																																					<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																																				</div>
																																			</div>";
																																			//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																																			//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																																		
																																}
																												$gcc_res_str .="</div>
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
																											AND RID=".$gcc_row['SNO'];
																			$res_status_added = db_all($res_status_added_query);
																			
																			//$result_count = mysql_num_rows($res_status_added)		
																			//for printing the remaining statuses to be updated.
																			$res_status_remaining_query = "SELECT 
																									mrs.SNO,mrs.RSTATUSNAME
																								FROM 
																									mr_status mrs
																								WHERE 
																									1=1
																									AND mrs.CID=".$gcc_row['CID']."
																									AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$gcc_row['SNO'].")";
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
																											AND rsm.RID=".$gcc_row['SNO']."
																										ORDER BY rsm.SNO desc
																										LIMIT 1;";
																			$res_status_last_added = db_all($res_status_last_added_query);
																			
																				//echo $res_status_last_added[0]['SID'].'<br/>';
																				$gcc_res_str .="<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
																											//Status added query result.
																											$j=0;
																											foreach($res_status_added AS $added_row){
																												//for adding the active class just to indicate which one is the latest status updated.
																													$j++;
																														$gcc_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
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
																							$gcc_res_str .="</div>
																										</div>
																									</div>
																								</div>
																							<!--Timeline Ends here-->";
																						}	

																		$gcc_res_str .="<div class='clearfix'></div>
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
										echo $gcc_res_str;
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
		
				
			<?php //***********HOD/ Section Head Section**************//
				}elseif($login_query_result['USERTYPE'] == 3){
			?>
				<div class="col-md-12 col-lg-12 col-sm-4">
					  <!-- Custom Tabs -->
					  <div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#on-going" data-toggle="tab"> On-going</a></li>
						  <li><a href="#completed" data-toggle="tab">Completed</a></li>
						<!--li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li-->
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="on-going">
								<div class="col-xs-12 col-lg-12 col-md-12 ">
									<div class="box box-info">
										<div class="box-header">
										  <h3 class="box-title">On-going Resolution List for <?php if(isset($_SESSION['name'])) {echo  $_SESSION['name'];}?> </h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body" style="overflow:scroll;">
										  <table id="example1" class="table table-bordered table-hover">
											<thead>
											<tr >
											  <th>SL.No</th>
											  <th>Resolution Title</th>
											  <th>Category</th>
											  <th>Res-Code /Res No</th>
											  <th>Resolution Date</th>
											  <th>Sanctioning Authority</th>
											  <th>Actions</th>
											</tr>
											
											</thead>
											<tbody>
											<?php 
											$hod_res_query = "SELECT rm.*
																,mrc.CATEGORY
																,ms.RSTATUSNAME AS status_name
																,mrd.deptname
																,mrs.AUTHORITY
																,DATE_FORMAT(rm.RESDATE,'%D-%b-%Y') AS res_date
														  FROM 
																res_master rm 
																INNER JOIN mr_category mrc ON mrc.CID=rm.CID
																INNER JOIN mr_department mrd ON mrd.id=rm.DEPT
																INNER JOIN mr_sancauthority mrs ON mrs.AID=rm.AID
																INNER JOIN mr_status ms ON ms.SNO = rm.RES_STATUS_ID
														   WHERE 
																1=1 
																AND rm.STATUS=1
																AND rm.DEPT=".$dept_id."
																ORDER BY rm.SNO DESC";
											$hod_res_rows = db_all($hod_res_query);
											
											
											
											//echo $hod_res_rows[0]['CID'].'<br/>';
											//print_r($res_status_added_query);
											$hod_res_str = "";
											$i = 1;
											//$j = 0; //required for inner foreach loops.
											$dot_color_array = array('b-primary','b-warning','b-danger','b-success');
											foreach($hod_res_rows AS $hod_row){
												$hod_res_str .="
														<tr>
														  <td>".$i."</td>
														  <td>".$hod_row['RES_TITLE']."</td>
														  <td>".$hod_row['CATEGORY']."</td>
														  <td>".$hod_row['RESCODE']."/".$hod_row['RESNO']."</td>
														  <td>".$hod_row['res_date']."</td>
														  <td>".$hod_row['AUTHORITY']."
															
														  
														  </td>
														  <td>
														  <button type='button' class='btn btn-primary hod_view_res' data-toggle='modal' data-target='#view_resolution".$hod_row['SNO']."'> <i class='fa fa-eye'></i></button>
																	<div class='modal fade' id='view_resolution".$hod_row['SNO']."' role='dialog'>
																	  <div class='modal-dialog modal-lg'>
																		<div class='modal-content'>
																			<div class='modal-header bg-primary'>
																				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																				  <span aria-hidden='true'>&times;</span></button>
																				<h4 class='modal-title'>View Resolution</h4>
																			</div>
																			
																			<div class='modal-body'>
																																						<div class='modal-body'>";
																			if($hod_row['RES_IMAGE_URL'] == NULL || $hod_row['RES_IMAGE_URL'] == "NULL"){
																				$hod_res_str .="<p>
																				<pre>".$hod_row['RES_TEXT']."</pre>
																				</p>";
																				} else {
																				$hod_res_str .="<img src='uploads/".$hod_row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																				}
																		$hod_res_str .="</div>
																					<div class='clearfix'></div>
																					<h3>Resolution Status</h3>
																							<!--Timeline Starts Here-->
																							<div class='padding'>";
																							if($hod_row['CID'] == 5){
																								//For printing the completed statues.
																								$res_status_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																														   AND rsm.CID=5
																																AND rsm.RID=".$hod_row['SNO'];
																								$res_status_added = db_all($res_status_added_query);
																								
																							
																								
																								//query to check the active (Current status value) to highlight.
																								$res_status_last_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$hod_row['SNO']."
																															AND rsm.CID=5 
																															ORDER BY rsm.SNO desc
																															LIMIT 1;";
																								$res_status_last_added = db_all($res_status_last_added_query);
																								
																									//echo $res_status_last_added[0]['SID'].'<br/>';
																									$hod_res_str .="<div class='row'>
																															<div class='col-md-12'>
																																<div class='timeline p-4 block mb-4'>";
																																//Status added query result.
																																$j=0;
																																foreach($res_status_added AS $added_row){
																																	//for adding the active class just to indicate which one is the latest status updated.
																																		$j++;
																																			$hod_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																																				<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																																				<div class='tl-content'>
																																					<div class=''><h4>".$added_row['REMARK']."</h4></div>
																																					<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																																				</div>
																																			</div>";
																																			//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																																			//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																																		
																																}
																												$hod_res_str .="</div>
																															</div>
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
																											AND RID=".$hod_row['SNO'];
																			$res_status_added = db_all($res_status_added_query);
																			
																			//$result_count = mysql_num_rows($res_status_added)		
																			//for printing the remaining statuses to be updated.
																			$res_status_remaining_query = "SELECT 
																									mrs.SNO,mrs.RSTATUSNAME
																								FROM 
																									mr_status mrs
																								WHERE 
																									1=1
																									AND mrs.CID=".$hod_row['CID']."
																									AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$hod_row['SNO'].")";
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
																											AND rsm.RID=".$hod_row['SNO']."
																										ORDER BY rsm.SNO desc
																										LIMIT 1;";
																			$res_status_last_added = db_all($res_status_last_added_query);
																			
																				//echo $res_status_last_added[0]['SID'].'<br/>';
																				$hod_res_str .="<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
																											//Status added query result.
																											$j=0;
																											foreach($res_status_added AS $added_row){
																												//for adding the active class just to indicate which one is the latest status updated.
																													$j++;
																														$hod_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
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
																													$hod_res_str .="<div class='tl-item'>
																														<div class='tl-dot b-warning'></div>
																														<div class='tl-content'>
																															<div class=''><h4>".$rem_row['RSTATUSNAME']."</h4></div>
																															<div class='tl-date text-muted mt-1'></h6>about to happen</h6></div>
																														</div>
																													</div>";
																											}
																							$hod_res_str .="</div>
																										</div>
																									</div>
																									<div class='clearfix'></div>
																								</div>
																							<!--Timeline Ends here-->";
																						}	


																				$hod_res_str .="<div class='clearfix'></div>
																			</div>
																			<div class='modal-footer'>
																				<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>
																				
																			</div>
																	</div>
																	<!-- /.modal-content -->
																  </div>
																  <!-- /.modal-dialog -->
																</div>
																<!-- /.modal -->
																<!-- Edit modal -->
																<button type='button' class='btn btn-warning' id='ch_status' data-toggle='modal' data-target='#ch_status".$hod_row['SNO']."'> <i class='fa fa-edit'></i></button>
																	<div class='modal fade' id='ch_status".$hod_row['SNO']."' role='dialog'>
																	  <div class='modal-dialog modal-lg'>
																		<div class='modal-content'>
																			<div class='modal-header bg-primary'>
																				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																				  <span aria-hidden='true'>&times;</span></button>
																				<h4 class='modal-title'> <i class='fa fa-exchange'></i> Change Status</h4>
																			</div>
																			<span class='help-block'>
																				<div class='status_change_notification'>
																					<div id='loading_image' style='display:none;'></div>
																				</div>
																			</span>
																			<div class='modal-body'>
																				<div class='form-group col-md-12'>";
																					if($hod_row['RES_IMAGE_URL'] == NULL || $hod_row['RES_IMAGE_URL'] == "NULL"){
																				$hod_res_str .="<p>
																				<pre>".$hod_row['RES_TEXT']."</pre>
																				</p>";
																				} else {
																				$hod_res_str .="<img src='uploads/".$hod_row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/ >";
																				}
																				$hod_res_str .="</div>
																				<div class='form-group col-md-6'>
																					<label class='help-block'>Resolution Code</label>
																						<h4>".$hod_row['RESCODE']."</h4>
																				</div>
																				<div class='form-group col-md-6'>
																					<label class='help-block'> Resolution Number </label>
																						<h4>".$hod_row['RESNO']."</h4>
																				</div>
																				<div class='form-group col-md-6'>
																					<label class='help-block'> Resolution Category </label>
																						<h4>".$hod_row['CATEGORY']."</h4>
																				</div>";
																			if($hod_row['CID'] == 5){
																				// query to display the current status
																					$cs_query_general_sanctions = "SELECT *, REMARK FROM res_status_master WHERE 1=1 AND RID=".$hod_row['SNO']." ORDER BY SNO DESC LIMIT 1";
																					$cs_result_general_sanctions =db_one($cs_query_general_sanctions);
																					//query to check the number of status added.
																					$general_sanctions_status_count_query = "SELECT count(*) AS status_count FROM res_status_master WHERE 1=1 AND RID=".$hod_row['SNO'];
																					$general_sanctions_status_count_result =db_one($general_sanctions_status_count_query);

																					$hod_res_str .="
																					<div class='form-group col-md-6'>
																								<label class='help-block'> Current Status </label>
																									<h4>".(($cs_result_general_sanctions['REMARK'] != "NULL") ? $cs_result_general_sanctions['REMARK'] : 'Not Added')."</h4>
																							</div>
																						<div class='clearfix'></div>
																						<div class='form-group col-md-4'>
																							<label class='help-block'>Click to add new status</label>
																							<button class='btn btn-primary inpu_box_button'><i class='fa fa-plus'></i> Add</button>
																						</div>";
																						if($general_sanctions_status_count_result['status_count'] > 1){
																							$hod_res_str .="<div class='form-group col-md-6 pull-right'>
																							<!--This button and modal are for confirming whether to complete the resolution or not (making it status 0)-->
																							<label></label>
																							<button class='btn btn-success res_complete' data-toggle='modal' data-target='#res_complete".$hod_row['SNO']."'><i class='fa fa-check'></i> Mark as Completed Resolution Cycle</button>
																									<div class='modal fade' id='res_complete".$hod_row['SNO']."' role='dialog'>
																									  <div class='modal-dialog'>
																											<div class='modal-content'>
																												<div class='modal-header bg-warning'>
																													<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																													  <span aria-hidden='true'>&times;</span></button>
																													<h4 class='modal-title'> <i class='fa fa-check'></i> Mark as Completed Resolution Cycle</h4>
																												</div>
																												<span class='help-block'>
																													<div class='res_complete_notification'>
																														<div id='loading_image' style='display:none;'></div>
																													</div>
																												</span>
																												<div class='modal-body'>
																													<h3>Are you sure ? you want to close this resolution .?</h3>
																														<div class='clearfix'></div>
																												</div>
																												<div class='modal-footer'>
																												<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>
																													<input type='hidden' class='res_row_pkey' value='".$hod_row['SNO']."'/>
																													<button type='button' class='btn btn-warning btn-flat pull-right res_complete_btn'><i class='fa fa-exchange'></i> Confirm</button>
																												</div>
																											</div>
																										<!-- /.modal-content -->
																									  </div>
																									  <!-- /.modal-dialog -->
																									</div>
																									<!-- /.modal -->

																						</div>";
																						}
																						
																						$hod_res_str .="<div class='clearfix'></div>
																						<!-- This div contains an input box for adding more status(s) for that perticular resolution.-->
																						<div class='form-group col-md-6 custom_status_container'>
																							
																						";
																			}else{
																							$current_status_query = "SELECT * FROM res_status_master rsm INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID WHERE rsm.CID=".$hod_row['CID']." AND rsm.RID=".$hod_row['SNO']." ORDER BY rsm.sno DESC LIMIT 1";
																						 
																						$current_status_result = db_one($current_status_query);

																							$hod_res_str .="<div class='form-group col-md-6'>
																								<label class='help-block'> Current Status </label>
																									<h4>".$current_status_result['RSTATUSNAME']."</h4>
																							</div>";
																						$availabl_list_query = "SELECT * FROM res_status_master rsm INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID WHERE rsm.CID=".$hod_row['CID']." AND rsm.RID=".$hod_row['SNO'];
																						$availabl_list_result = db_all($availabl_list_query);
																						
																						$remaining_status_query = "SELECT * FROM `mr_status` WHERE 1=1 AND CID=".$hod_row['CID']." AND SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND CID=".$hod_row['CID']." AND RID=".$hod_row['SNO'].")";
																						$remaining_status_result = db_all($remaining_status_query);
																						$hod_res_str .="<div class='form-group col-md-6'>
																								<label class='help-block'>Change Resolution Status : <span class='text-danger'>*</span></label>";
																					//When every status has been updated. (reached.)
																					if(empty($remaining_status_result)){
																						//$cat_status_query = "SELECT * FROM mr_status mrs  WHERE mrs.CID=".$hod_row['CID'];
																						$hod_res_str .="<h3 class='text-success'>The Resolution Cycle is completed.</h3>";
																					}else{
																						$status_str = "<select class='form-control resolution_status_id'>
																										<option value='0'>Choose One</option>";
																						foreach($availabl_list_result AS $alr){
																							$status_str .="<option value='".$alr['SNO']."' style='color:red;' disabled>".$alr['RSTATUSNAME']."</option>";
																						}
																						foreach($remaining_status_result AS $rsr){
																							//to check whether the status has reached (1 less than the last status).
																							if($rsr['SNO'] == 7 || $rsr['SNO'] == 13){ // this is with respect to category 1 and 3(procurement / event organisation.)
																								$status_str .="<option value='".$rsr['SNO']."' ".($rsr['SNO'] == $hod_row['RES_STATUS_ID']? 'selected':'')." disabled>".$rsr['RSTATUSNAME']."</option>";
																							}else{
																								$status_str .="<option value='".$rsr['SNO']."' ".($rsr['SNO'] == $hod_row['RES_STATUS_ID']? 'selected':'').">".$rsr['RSTATUSNAME']."</option>";
																							}
																							
																						}
																						$hod_res_str .= $status_str;
																						$hod_res_str .="</select>";
																					}
																					$hod_res_str .="<div class='clearfix'></div>
																						
																						<div class='form-group col-md-6'>
																					<label class='help-block'> Your Remark </label>
																						<input type='text' class='form-control status_remark'/>

																				</div>
																				
																				";
																		}
																		$hod_res_str .="
																				</div>
																		<!-- end of div-->
																		<div class='clearfix'></div>
																			</div>
																			<div class='modal-footer'>
																				<input type='hidden' class='cat_id' value='".$hod_row['CID']."'>
																				<input type='hidden' class='Res_id' value='".$hod_row['SNO']."'>
																				<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>";
																				if($hod_row['CID'] == 5){
																				$hod_res_str .="<button type='button' id='hod_status_additiopn' class='btn btn-primary btn-flat pull-right'><i class='fa fa-exchange'></i> Add / Modify</button>";
																				}else{
																							$hod_res_str .="<button type='button' id='hod_status_change_btn' ".((empty($remaining_status_result))?'disabled':'')." class='btn btn-primary btn-flat pull-right '><i class='fa fa-exchange'></i> Change</button>";
																				}
																					$hod_res_str .="<div class='clearfix'></div>
																				</div>
																			<div class='clearfix'></div>
																	</div>
																	<!-- /.modal-content -->
																  </div>
																  <!-- /.modal-dialog -->
																</div>
																<!-- /.modal -->
																<!--button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#collapse".$hod_row['SNO']."' aria-expanded='false' aria-controls='collapseExample'>
																<i class='fa fa-search'></i>
															  </button-->
														  </td>
														 </tr>";
												
														$i++;
											}
												
												echo $hod_res_str;
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
						  <!-- End of Completed Resolution List -->
							<div class="tab-pane" id="completed">
								<div class="col-xs-12 col-lg-12 col-md-12">
									<div class="box box-info">
										<div class="box-header">
										  <h3 class="box-title">Completed Resolution List for <?php if(isset($_SESSION['name'])) {echo  $_SESSION['name'];}?> </h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body" style="overflow:scroll;">
										  <table id="example1" class="table table-bordered table-hover">
											<thead>
											<tr >
											  <th>SL.No</th>
											  <th>Resolution Title</th>
											  <th>Category</th>
											  <th>Res-Code /Res No</th>
											  <th>Resolution Date</th>
											  <th>Sanctioning Authority</th>
											  <th>Actions</th>
											</tr>
											
											</thead>
											<tbody>
											<?php 
											$hod_res_query = "SELECT rm.*
																,mrc.CATEGORY
																,ms.RSTATUSNAME AS status_name
																,mrd.deptname
																,mrs.AUTHORITY
																,DATE_FORMAT(rm.RESDATE,'%D-%b-%Y') AS res_date
														  FROM 
																res_master rm 
																INNER JOIN mr_category mrc ON mrc.CID=rm.CID
																INNER JOIN mr_department mrd ON mrd.id=rm.DEPT
																INNER JOIN mr_sancauthority mrs ON mrs.AID=rm.AID
																INNER JOIN mr_status ms ON ms.SNO = rm.RES_STATUS_ID
														   WHERE 
																1=1 
																AND rm.STATUS=0
																AND rm.DEPT=".$dept_id."
																ORDER BY rm.SNO DESC";
											$hod_res_rows = db_all($hod_res_query);
											
											
											
											//echo $hod_res_rows[0]['CID'].'<br/>';
											//print_r($res_status_added_query);
											$hod_res_str = "";
											$i = 1;
											//$j = 0; //required for inner foreach loops.
											$dot_color_array = array('b-primary','b-warning','b-danger','b-success');
											foreach($hod_res_rows AS $hod_row){
												$hod_res_str .="
														<tr>
														  <td>".$i."</td>
														  <td>".$hod_row['RES_TITLE']."</td>
														  <td>".$hod_row['CATEGORY']."</td>
														  <td>".$hod_row['RESCODE']."/".$hod_row['RESNO']."</td>
														  <td>".$hod_row['res_date']."</td>
														  <td>".$hod_row['AUTHORITY']."
															
														  
														  </td>
														  <td>
														  <button type='button' class='btn btn-primary hod_view_res' data-toggle='modal' data-target='#view_completed_resolution".$hod_row['SNO']."'> <i class='fa fa-eye'></i></button>
																	<div class='modal fade' id='view_completed_resolution".$hod_row['SNO']."' role='dialog'>
																	  <div class='modal-dialog modal-lg'>
																		<div class='modal-content'>
																			<div class='modal-header bg-primary'>
																				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																				  <span aria-hidden='true'>&times;</span></button>
																				<h4 class='modal-title'>View Resolution</h4>
																			</div>
																			
																			<div class='modal-body'>
																																						<div class='modal-body'>";
																			if($hod_row['RES_IMAGE_URL'] == NULL || $hod_row['RES_IMAGE_URL'] == "NULL"){
																				$hod_res_str .="<p>
																				<pre>".$hod_row['RES_TEXT']."</pre>
																				</p>";
																				} else {
																				$hod_res_str .="<img src='uploads/".$hod_row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																				}
																		$hod_res_str .="</div>
																					<div class='clearfix'></div>
																					<h3>Resolution Status</h3>
																							<!--Timeline Starts Here-->
																							<div class='padding'>";
																							//Excplicitly for displaying Category 5 resolutiuon status (Custom status)
																							if($hod_row['CID'] == 5){
																								//For printing the completed statues.
																								$res_status_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.CID=5
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$hod_row['SNO'];
																								$res_status_added = db_all($res_status_added_query);
																								
																							
																								
																								//query to check the active (Current status value) to highlight.
																								$res_status_last_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$hod_row['SNO']."
																															AND rsm.CID=5 
																															ORDER BY rsm.SNO desc
																															LIMIT 1;";
																								$res_status_last_added = db_all($res_status_last_added_query);
																								
																									//echo $res_status_last_added[0]['SID'].'<br/>';
																									$hod_res_str .="<div class='row'>
																															<div class='col-md-12'>
																																<div class='timeline p-4 block mb-4'>";
																																//Status added query result.
																																$j=0;
																																foreach($res_status_added AS $added_row){
																																	//for adding the active class just to indicate which one is the latest status updated.
																																		$j++;
																																			$hod_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																																				<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																																				<div class='tl-content'>
																																					<div class=''><h4>".$added_row['REMARK']."</h4></div>
																																					<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																																				</div>
																																			</div>";
																																			//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																																			//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																																		
																																}
																												$hod_res_str .="</div>
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
																											AND RID=".$hod_row['SNO'];
																			$res_status_added = db_all($res_status_added_query);
																			
																			//$result_count = mysql_num_rows($res_status_added)		
																			//for printing the remaining statuses to be updated.
																			$res_status_remaining_query = "SELECT 
																									mrs.SNO,mrs.RSTATUSNAME
																								FROM 
																									mr_status mrs
																								WHERE 
																									1=1
																									AND mrs.CID=".$hod_row['CID']."
																									AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$hod_row['SNO'].")";
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
																											AND rsm.RID=".$hod_row['SNO']."
																										ORDER BY rsm.SNO desc
																										LIMIT 1;";
																			$res_status_last_added = db_all($res_status_last_added_query);
																			
																				//echo $res_status_last_added[0]['SID'].'<br/>';
																				$hod_res_str .="<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
																											//Status added query result.
																											$j=0;
																											foreach($res_status_added AS $added_row){
																												//for adding the active class just to indicate which one is the latest status updated.
																													$j++;
																														$hod_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
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
																													$hod_res_str .="<div class='tl-item'>
																														<div class='tl-dot b-warning'></div>
																														<div class='tl-content'>
																															<div class=''><h4>".$rem_row['RSTATUSNAME']."</h4></div>
																															<div class='tl-date text-muted mt-1'></h6>about to happen</h6></div>
																														</div>
																													</div>";
																											}
																							$hod_res_str .="</div>
																										</div>
																									</div>
																									<div class='clearfix'></div>
																								</div>
																							<!--Timeline Ends here-->";
																						}	

																				$hod_res_str .="
																				<div class='clearfix'></div>
																			</div>
																			<div class='modal-footer'>
																				<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>
																				
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
												
												echo $hod_res_str;
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
							<!--End of Completed Resolutions tab-->
						</div>
						<!-- /.tab-content -->
					  </div>
					  <!-- nav-tabs-custom -->
				</div>
					<!-- /.col -->
		
		
			<?php //****************************Office Section starts**********************************//
				}elseif($login_query_result['USERTYPE'] == 4){
					
					include('pages/office/office_resolution_content.php');
					//****************************** Office Section Ends Here**********************//
			//User type = 5 
					//****************************** Payment Section Starts ***********************//
				}else if($login_query_result['USERTYPE'] == 5){	
			?>
				<div class="col-xs-12">
					<div class="box box-info">
						<div class="box-header">
						  <h3 class="box-title">Resolution List for <?php if(isset($_SESSION['name'])) {echo  $_SESSION['name'];}?> </h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body" style="overflow:scroll;">
						  <table id="example1" class="table table-bordered table-hover">
							<thead>
							<tr >
							  <th>SL.No</th>
							  <th>Resolution Title</th>
							  <th>Category</th>
							  <th>Res-Code /Res No</th>
							  <th>Resolution Date</th>
							  <th>Sanctioning Authority</th>
							  <th>Actions</th>
							</tr>
							
							</thead>
							<tbody>
							<?php 
							$pyment_res_query = "SELECT rm.*
												,mrc.CATEGORY
												,ms.RSTATUSNAME AS status_name
												,mrd.deptname
												,mrs.AUTHORITY
												,DATE_FORMAT(rm.RESDATE,'%D-%b-%Y') AS res_date
										  FROM 
												res_master rm 
												INNER JOIN mr_category mrc ON mrc.CID=rm.CID
												INNER JOIN mr_department mrd ON mrd.id=rm.DEPT
												INNER JOIN mr_sancauthority mrs ON mrs.AID=rm.AID
												INNER JOIN mr_status ms ON ms.SNO = rm.RES_STATUS_ID
												INNER JOIN res_status_master rsm ON rsm.RID = rm.SNO
										   WHERE 
												1=1 
												AND rm.STATUS=1
												AND rsm.CID IN (1,3)
												AND rsm.SID IN (6,12)
												ORDER BY rm.SNO DESC";
							$payment_res_rows = db_all($pyment_res_query);
							
							
							
							//echo $hod_res_rows[0]['CID'].'<br/>';
							//print_r($res_status_added_query);
							$payment_res_str = "";
							$i = 1;
							//$j = 1; //required for inner foreach loops.
							$dot_color_array = array('b-primary','b-warning','b-danger','b-success');
							foreach($payment_res_rows AS $payment_row){
								$payment_res_str .="
										<tr>
										  <td>".$i."</td>
										  <td>".$payment_row['RES_TITLE']."</td>
										  <td>".$payment_row['CATEGORY']."</td>
										  <td>".$payment_row['RESCODE']."/".$payment_row['RESNO']."</td>
										  <td>".$payment_row['res_date']."</td>
										  <td>".$payment_row['AUTHORITY']."
											
										  
										  </td>
										  <td>
										  <button type='button' class='btn btn-primary hod_view_res' data-toggle='modal' data-target='#view_resolution".$payment_row['SNO']."'> <i class='fa fa-eye'></i></button>
													<div class='modal fade' id='view_resolution".$payment_row['SNO']."' role='dialog'>
													  <div class='modal-dialog modal-lg'>
														<div class='modal-content'>
															<div class='modal-header bg-primary'>
																<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																  <span aria-hidden='true'>&times;</span></button>
																<h4 class='modal-title'>View Resolution</h4>
															</div>
															<div class='modal-body'>
																																		<div class='modal-body'>";
															if($payment_row['RES_IMAGE_URL'] == NULL){
																$payment_res_str .="<p>
																<pre>".$payment_row['RES_TEXT']."</pre>
																</p>";
																} else {
																$payment_res_str .="<img src='uploads/".$payment_row['RES_IMAGE_URL']."' height='650px' width='800px' alt='Image' class='zoom'/>";
																}
														$payment_res_str .="</div>
																	<div class='clearfix'></div>
																	<h3>Resolution Status</h3>
																			<!--Timeline Starts Here-->
																			<div class='padding'>";
																			if($payment_row['CID'] == 5){
																								//For printing the completed statues.
																								$res_status_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.CID=5
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$payment_row['SNO'];
																								$res_status_added = db_all($res_status_added_query);
																								
																							
																								
																								//query to check the active (Current status value) to highlight.
																								$res_status_last_added_query = "SELECT 
																															*
																															,DATE_FORMAT(rsm.MDATE,'%d-%M-%Y') AS res_mod_date
																														   FROM 
																															res_status_master rsm
																														   WHERE 1=1 
																														   AND rsm.STATUS = 1
																																AND rsm.RID=".$payment_row['SNO']."
																															AND rsm.CID=5 
																															ORDER BY rsm.SNO desc
																															LIMIT 1;";
																								$res_status_last_added = db_all($res_status_last_added_query);
																								
																									//echo $res_status_last_added[0]['SID'].'<br/>';
																									$payment_res_str .="<div class='row'>
																															<div class='col-md-12'>
																																<div class='timeline p-4 block mb-4'>";
																																//Status added query result.
																																$j=0;
																																foreach($res_status_added AS $added_row){
																																	//for adding the active class just to indicate which one is the latest status updated.
																																		$j++;
																																			$payment_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
																																				<div class='tl-dot ".($res_status_last_added[0]['SID'] != $j ? 'b-success':'b-warning')." '></div>
																																				<div class='tl-content'>
																																					<div class=''><h4>".$added_row['REMARK']."</h4></div>
																																					<div class='tl-date text-muted mt-1'><h5>".$added_row['res_mod_date']."</h5></div>
																																				</div>
																																			</div>";
																																			//echo $added_row[$j]['MDATE'].'-'.$added_row[$i]['MDATE'];
																																			//$hod_res_str .="<div>".days_from_dates($added_row[$j]['MDATE'],$added_row[$i]['MDATE'])."</div>";
																																		
																																}
																												$payment_res_str .="</div>
																															</div>
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
																											AND RID=".$payment_row['SNO'];
																			$res_status_added = db_all($res_status_added_query);
																			
																			//$result_count = mysql_num_rows($res_status_added)		
																			//for printing the remaining statuses to be updated.
																			$res_status_remaining_query = "SELECT 
																									mrs.SNO,mrs.RSTATUSNAME
																								FROM 
																									mr_status mrs
																								WHERE 
																									1=1

																									AND mrs.CID=".$payment_row['CID']."
																									AND mrs.SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND RID=".$payment_row['SNO'].")";
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
																											AND rsm.RID=".$payment_row['SNO']."
																										ORDER BY rsm.SNO desc
																										LIMIT 1;";
																			$res_status_last_added = db_all($res_status_last_added_query);
																			
																				//echo $res_status_last_added[0]['SID'].'<br/>';
																				$payment_res_str .="<div class='row'>
																										<div class='col-md-12'>
																											<div class='timeline p-4 block mb-4'>";
																											//Status added query result.
																											$j=0;
																											foreach($res_status_added AS $added_row){
																												//for adding the active class just to indicate which one is the latest status updated.
																													$j++;
																														$payment_res_str .="<div class='tl-item ".($res_status_last_added[0]['SID']== $j ? 'active':'')."'>
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
																													$payment_res_str .="<div class='tl-item'>
																														<div class='tl-dot b-warning'></div>
																														<div class='tl-content'>
																															<div class=''><h4>".$rem_row['RSTATUSNAME']."</h4></div>
																															<div class='tl-date text-muted mt-1'></h6>about to happen</h6></div>
																														</div>
																													</div>";
																											}
																							$payment_res_str .="</div>
																										</div>
																									</div>
																								</div>
																							<!--Timeline Ends here-->";
																						}	


																				$payment_res_str .="
																<div class='clearfix'></div>
															</div>
															<div class='modal-footer'>
																<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>
																
															</div>
													</div>
													<!-- /.modal-content -->
												  </div>
												  <!-- /.modal-dialog -->
												</div>
												<!-- /.modal -->
												<button type='button' class='btn btn-warning' id='ch_status' data-toggle='modal' data-target='#ch_status".$payment_row['SNO']."'> <i class='fa fa-edit'></i></button>
													<div class='modal fade' id='ch_status".$payment_row['SNO']."' role='dialog'>
													  <div class='modal-dialog modal-lg'>
														<div class='modal-content'>
															<div class='modal-header bg-primary'>
																<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																  <span aria-hidden='true'>&times;</span></button>
																<h4 class='modal-title'> <i class='fa fa-exchange'></i> Change Status</h4>
															</div>
															<span class='help-block'>
																<div class='status_change_notification'>
																	<div id='loading_image' style='display:none;'></div>
																</div>
															</span>
															<div class='modal-body'>
																<div class='form-group col-md-12'>
																	<pre>".$payment_row['RES_TEXT']."</pre>
																</div>
																<div class='form-group col-md-6'>
																	<label class='help-block'>Resolution Code</label>
																		<h4>".$payment_row['RESCODE']."</h4>
																</div>
																<div class='form-group col-md-6'>
																	<label class='help-block'> Resolution Number </label>
																		<h4>".$payment_row['RESNO']."</h4>
																</div>
																<div class='form-group col-md-6'>
																	<label class='help-block'> Resolution Category </label>
																		<h4>".$payment_row['CATEGORY']."</h4>
																</div>";
																	$availabl_list_query = "SELECT * FROM res_status_master rsm INNER JOIN mr_status mrs ON mrs.SNO = rsm.SID WHERE rsm.CID=".$payment_row['CID']." AND rsm.RID=".$payment_row['SNO'];
																	$availabl_list_result = db_all($availabl_list_query);
																	
																	$remaining_status_query = "SELECT * FROM `mr_status` WHERE 1=1 AND CID=".$payment_row['CID']." AND SNO NOT IN (SELECT SID FROM res_status_master WHERE 1=1 AND CID=".$payment_row['CID']." AND RID=".$payment_row['SNO'].")";
																	$remaining_status_result = db_all($remaining_status_query);
																	$payment_res_str .="<div class='form-group col-md-6'>
																			<label class='help-block'>Current Resolution Status : <span class='text-danger'>*</span></label>";
																			//print_r($availabl_list_result);
																if(empty($remaining_status_result)){
																	//$cat_status_query = "SELECT * FROM mr_status mrs  WHERE mrs.CID=".$hod_row['CID'];
																	$payment_res_str .="<h3 class='text-success'>The Resolution Cycle is completed.</h3>";
																}else{
																	$status_str = "<select class='form-control res_status_id'>
																					<option value='0'>Choose One</option>";
																	foreach($availabl_list_result AS $alr){
																		$status_str .="<option value='".$alr['SNO']."' style='color:red;' disabled>".$alr['RSTATUSNAME']."</option>";
																	}
																	foreach($remaining_status_result AS $rsr){
																		$status_str .="<option value='".$rsr['SNO']."' ".($rsr['SNO'] == $payment_row['RES_STATUS_ID']? 'selected':'').">".$rsr['RSTATUSNAME']."</option>";
																	}
																	$payment_res_str .= $status_str;
																	$payment_res_str .="</select>";
																	
																}
																$payment_res_str .="</div>
																
																<div class='clearfix'></div>
															</div>
															<div class='modal-footer'>
																<input type='hidden' class='cat_id' value='".$payment_row['CID']."'>
																<input type='hidden' class='Res_id' value='".$payment_row['SNO']."'>
																<button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'>Close</button>
																<button type='button' id='payment_status_change_btn' ".((empty($remaining_status_result))?'disabled':'')." class='btn btn-primary btn-flat pull-right'><i class='fa fa-exchange'></i> Change</button>
															</div>
													</div>
													<!-- /.modal-content -->
												  </div>
												  <!-- /.modal-dialog -->
												</div>
												<!-- /.modal -->
												<!--button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#collapse".$payment_row['SNO']."' aria-expanded='false' aria-controls='collapseExample'>
												<i class='fa fa-search'></i>
											  </button-->
										  </td>
										 </tr>";
								
										$i++;
							}
								
								echo $payment_res_str;
							?>
							
							
							
							</tbody>
							
						  </table>
						</div>
						<!-- /.box-body -->
					</div>
					  <!-- /.box -->
							  
				</div>
			<?php //**********************ADMIN /SUPER ADMIN content**************.
			}else{?>
				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-header with-border">
						  <center><h3 class="box-title">Equipment Booking Statistics</h3></center>
							<h4 class="pull-left">Total Bookings</h4>
							<h4 class="pull-right">This Months Bookings</h4>
						  <!--div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						  </div-->
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
									
									
									<div class="col-md-4">
									  <div class="chart-responsive">
										<canvas id="pieChart" height="100"></canvas>
									  </div>
									  <!-- ./chart-responsive -->
									</div>
									<div class="col-md-4">
									  <ul class="chart-legend clearfix">
										<li><i class="fa fa-circle-o text-yellow "></i> Bookings Pending</li>
										<li><i class="fa fa-circle-o text-green"></i> Bookings Accepted</li>
										<li><i class="fa fa-circle-o text-red"></i> Bookings Rejected</li>
									  </ul>
									</div>
									
									<div class="col-md-4">
									  <div class="chart-responsive">
										<canvas id="pieChart1" height="100"></canvas>
									  </div>
									  <!-- ./chart-responsive -->
									</div>
							</div>
						  <!-- /.row -->
						</div>
						<!-- /.box-body -->
						
					</div>
					  <!-- /.box -->
				</div>
			<div class="clearfix"></div>
				<!--Box for booking equipment-->
				<?php //if($login_query_result['is_admin'] == 1) {?>
					
					<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
						<div class="small-box bg-green">
							<div class="inner">
							  <h3><?php
							   //$count_query="SELECT Count(*) AS eq_count FROM equipment_master WHERE 1=1";
								//		 $count_result = db_one($count_query);
								// echo $count_result['eq_count'];?></h3>

							  <p>Add an Equipment</p>
							</div>
							<div class="icon">
							  <i class="fa fa-plus"></i>
							</div>
								<button type="button" class="small-box-footer form-control" id="view_eq" data-toggle="modal" data-target="#add_eq_modal">Add <i class="fa fa-arrow-circle-right"></i></button>
								<div class="modal fade" id="add_eq_modal" role="dialog">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Add an Equipment</h4>
								  </div>
									  
									<span class="help-block">
										<div class="equipment_added_notification">
											<div id="loading_image" style="display:none;"></div>
										</div>
									</span>
									<form method="post" role="form">
										<div class="modal-body">
												<div class="form-group">
												<label class="help-block">Name :</label>
												  <input type="text" class="form-control" id="equip_name" required placeholder="Enter the name" value=""/>
												</div>
												<div class="form-group col-md-4">
												<label class="help-block">Id : <span class="text-light-blue">Auto generated</span></label>
												  <input type="text" class="form-control" id="equip_id" disabled="disabled" value=""/>
													
												</div>
												
												<div class="form-group col-md-4">
													<label class="help-block">Quantity : <span class="alert_notification"></span></label>
													<input type="text" class="form-control" id="equip_quantity" required placeholder="Enter the quantity"/>
												</div>
												<div class="form-group col-md-4">
													<label class="help-block">Unit Charge : (Price)<span class=""></span></label>
													<input type="text" class="form-control" id="unit_price" required placeholder="Enter the quantity"/>
												</div>
													<div class="clearfix"></div>
												<div class="equipment_codes">
												</div>
												<div class="form-group">
													<label class="help-block">Description :</label>
												  <textarea class="form-control" id="equip_desc" required placeholder="Enter the description"></textarea>
												</div>
												
										</div>
											
										<div class="modal-footer">
											<button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Close</button>
											<button type="reset" class="btn btn-default btn-flat"></i> Reset</button>
											<button type="button" class="btn btn-primary btn-flat" id="add_equipment"><i class="fa fa-plus"></i> ADD</button>
										</div>
									</form>
								</div>
								<!-- /.modal-content -->
							  </div>
							  <!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
												
						</div>
					</div>
					<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				 
					  <div class="small-box bg-yellow">
						 <span class="pull-right badge bg-blue">10</span>
						<div class="inner">
							<?php 
							 //$booking_manager_query = "SELECT count(*) AS requests_count FROM calender_event ce WHERE 1=1	AND ce.start >= CURDATE() AND ce.status=1";
							 //$booking_manager_count = db_one($booking_manager_query);
							?>
						  <h3><?php //echo($booking_manager_count['requests_count']); ?></h3>

						  <p>Booking Requests </p>
						</div>
						<div class="icon">
						  <i class="fa  fa-map-signs"></i>
						</div>
						<a  href="booking_requests.php" class="small-box-footer form-control" id="view_eq">Manage <i class="fa fa-arrow-circle-right"></i></a>
					  </div>
					</div>
					<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
					  <div class="small-box bg-green">
						<div class="inner">
						  <?php 
						   //$equipments_query = "SELECT count(*) AS booking_count FROM equipment_master em WHERE 1=1 AND em.status=1";
							// $equipments_count = db_one($equipments_query);
							?>
						  <h3><?php //echo($equipments_count['booking_count']); ?></h3>
						  <p>Equipment Manager</p>
						</div>
						<div class="icon">
						  <i class="fa fa-flag-o"></i>
						</div>
						<a  href="equipment_manager.php" class="small-box-footer form-control" id="view_eq">Manage <i class="fa fa-arrow-circle-right"></i></a>
					  </div>
					</div>
					<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
					  <div class="small-box bg-yellow">
						<div class="inner">
						  <?php 
						   //$bookings_count_query = "SELECT count(*) AS all_book_count FROM calender_event ce WHERE 1=1";
							// $bookings_count_result = db_one($bookings_count_query);
							?>
						  <h3><?php //echo($bookings_count_result['all_book_count']); ?></h3>
						  <p>All Bookings</p>
						</div>
						<div class="icon">
						  <i class="fa fa-book"></i>
						</div>
						<a  href="all_bookings.php" class="small-box-footer form-control" id="view_eq">View List <i class="fa fa-arrow-circle-right"></i></a>
					  </div>
					</div>
			<?php } ?>			
				
			<div class="clearfix"></div>
			
			</section>
			
		</div>
		  <!-- /.row (main row) -->
	</section>
	<?php mysqli_close($con);?>
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>KLS GIT</b> 
    </div>
    <strong>Copyright &copy; 2022 <a href="#"></a>.</strong> All rights
    reserved. GIT Software Team
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

	
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
$(document).ready(function(){	
	//for clock
  setInterval('updateClock()', 1000);
  

	//form processing for storing resolution data.
	$(document).on('click','.hod_view_res, #ch_status',function(){
		//e.preventDefault();
		if($(this).parent().parent().hasClass("danger")){
			$(this).parent().parent().removeClass("danger");
		}else{
			$(this).parent().parent().addClass("danger");
			
			
		}
	});

	//for editing the existing resolution. (image upload or text typing).
	$(document).on('click','.optionsRadios3',function(e){
		e.preventDefault();
		var raddio_button_val = $(this).val();
		//alert(raddio_button_val);
		if( raddio_button_val == 1){
			$('.upload_image').removeClass('hidden');
			$('.type_text').addClass('hidden');
		}else{
			$('.type_text').removeClass('hidden');
			$('.upload_image').addClass('hidden');
		}
	});
	
		//To Change the status of the resolution by HOD /Section Head 
	$(document).on('click','#hod_status_change_btn',function(e){
		e.preventDefault();
		var RID = $(this).parent().find('.Res_id').val();
		var CID = $(this).parent().find('.cat_id').val();
		
		var SID = $(this).parent().prev().find('.resolution_status_id').val();
		var status_remark = $(this).parent().prev().find('.status_remark').val();
		
		var change_status_url = 'ajax/hod_status_change.ajax.php';
		//alert(status_remark);
		if(SID == 0){
			alert('Please Select the appropriate STATUS for resolution');
		}else{
			$("div #loading_image").removeAttr("style");
		$.post(
			change_status_url,{
				c1 : RID, c2 : CID, c3 :SID, c4: status_remark
				},
			function(data,status){
					$('.status_change_notification').html(data);
						setTimeout(function () {
							window.location.reload();
							}, 2000);
			});
		}
		
	});
	
	//To Change the status of the resolution by Payment Section for Bill settlement (Last Status Update). 
	$(document).on('click','#payment_status_change_btn',function(e){
		e.preventDefault();
		var RID = $(this).parent().find('.Res_id').val();
		var CID = $(this).parent().find('.cat_id').val();
		
		var SID = $(this).parent().prev().find('.res_status_id').val();
		var change_status_url = 'ajax/payment_status_change.ajax.php';
		//alert(RID+'-'+CID+'-'+SID);
		if(SID == 0){
			alert('Please Select the appropriate STATUS for resolution');
		}else{
		//$("div #loading_image").removeAttr("style");
		$.post(
			change_status_url,{
				c1 : RID, c2 : CID, c3 :SID
				},
			function(data,status){
					$('.status_change_notification').html(data);
						setTimeout(function () {
							window.location.reload();
							}, 2000);
					$(this).addAttr('disabled');
			});
		}
	});
	
	$(document).on('click','.extra_email',function(e){
		e.preventDefault();
		//alert('clicked');
		var content = '<label class="help-block"> Add Email Address(es) <span class="text-danger"> if multiple , seperate them with qummas (,)</span></label><div class="input-group"><input type="text" class="form-control" name="extra-emails"/><div class="input-group-btn"><button class="btn btn-warning btn-flat no-extra-emails">No</button></div></div>';
		$('.extra-info-mails').html(content);

	});

	$(document).on('click','.no-extra-emails',function(e){
		e.preventDefault();
		//alert('clicked');
		
		$('.extra-info-mails').empty();

	});
	
	
	//form processing for UPDATING resolution data.
	$(document).on('submit','#res_update',function(e){
		e.preventDefault();
		/*var res_title = $('#res_title').val();
		var cat_id = $('#cat_id').val();
		var res_status_id = $('#res_status_id').val();
		var res_date = $('.res_date').val();
		var dept = $('#dept').val();
		var res_no = $('#res_no').val();
		var sanctioning_auth = $('#sanctioning_auth').val();
		var res_image = $('.res_image').prop('files')[0].name;
		//;//val();//
		var res_doc = $('#res_doc').val();
		
		//alert(res_image);
		alert(res_title+'-'+cat_id+'-'+res_status_id+'-'+res_date+'-'+dept+'-'+res_no+'-'+sanctioning_auth+'-'+res_doc+'-'+res_image);
		//alert()
		//var url = 'ajax/save_resolution_data.ajax.php';
		if(res_title == "" || cat_id == 0 || res_status_id == 0 || res_date == "" || dept == 0 || sanctioning_auth == 0){
			alert("FIll all the fields");
			
		}else{*/
			//var formData = new FormData()

			//var file_data = $('#resolution_image').prop('files')[0]; 
			//alert(formData);
			$("div #loading_image").removeAttr("style");
			$.ajax({
				url: 'ajax/update_resolution_data.ajax.php', 
				type: 'POST',
				data: new FormData(this),
				processData: false,
				contentType: false,
				success: function(data) {
					$('.resolution_updated_notification').html(data);
					setTimeout(function () {
							window.location.reload();
						}, 2000);
				}
			});
			/*$.post(
				url,{
					r1 : res_title, r2 :  cat_id, r3 : res_status_id, r4 : res_date, r5 : dept, r6 : res_no,  r7 : sanctioning_auth, r8 : res_doc, r9 : res_image
				},
				function(data,status){
						$('.resolution_added_notification').html(data);
						/*setTimeout(function () {
							window.location.reload();
						}, 3000);*/
		//}
				
	});
	
	
	$(document).on('click','.inpu_box_button',function(e){
		e.preventDefault();
		//alert('clicked');
		var content = '<label class="help-block"><span class="text-info"> Your Custom Status</span></label><div class="input-group form-group col-md-12"><input type="text" class="form-control custom_status"/><div class="input-group-btn"><button class="btn btn-danger btn-flat remove_input_box"><i class="fa fa-times"></button></div></div>';
		$('.custom_status_container').html(content);

	});


	$(document).on('click','.remove_input_box',function(e){
		e.preventDefault();
		//alert('clicked');
		
		$('.custom_status_container').empty();

	});

	//To Change the status of the resolution by HOD /Section Head - only for category 5 (general sanctions)
	$(document).on('click','#hod_status_additiopn',function(e){
		e.preventDefault();
		var RID = $(this).parent().find('.Res_id').val();
		var CID = $(this).parent().find('.cat_id').val();
		
		var custom_status = $(this).parent().prev().find('.custom_status').val();
		var change_status_url = 'ajax/hod_status_addition.ajax.php';
		//alert(RID+'-'+CID+'-'+custom_status);

		if(custom_status == undefined || custom_status == ""){
			alert('Please Select the appropriate STATUS for resolution');
		}else{
		$("div #loading_image").removeAttr("style");
		$.post(
			change_status_url,{
				c1 : RID, c2 : CID, c3 :custom_status
				},
			function(data,status){
					$('.status_change_notification').html(data);
						setTimeout(function () {
							window.location.reload();
							}, 2000);
					$(this).addAttr('disabled');
			});
		}
	});
	

		$(document).on('click','.res_complete_btn',function(e){
		e.preventDefault();
		//alert('clicked');
		var Complete_res_url = 'ajax/hod_resolution_complete.ajax.php';
		var Res_Id = $(this).parents().find('.res_row_pkey').val();
			$("div #loading_image").removeAttr("style");
		$.post(
			Complete_res_url,{
				R1 : Res_Id
				},
			function(data,status){
					$('.res_complete_notification').html(data);
						setTimeout(function () {
							window.location.reload();
							}, 2000);
					
			});
	});

	//for updating and changing the color of the clicked notification.
	$(document).on('click','.equipment_adding_notification',function(){
		var notify_id =$(this).prev().val();
		var notify_url='update_notification_color.ajax.php';
		//alert(notify_id);
				$(this).removeClass('notification_bg_color');
		$.post(
			notify_url,{
				p1 : notify_id
				},
			function(data,status){
				//do nothing
						setTimeout(function () {
							window.location.reload();
							}, 1000);
			});
	});
	
	//for adding an article.
	
	
	//for saving the data for applying leave.
	$(document).on('click','#leave_app',function(e){
		e.preventDefault();
		var leave_date = $('#leave_date').val();
		var leave_note = $('#note_text').val();
		//alert(leave_date+'--'+leave_note);
		var leave_url = 'apply_leave.ajax.php';
		$.post(
			leave_url,{
				l1 : leave_date, l2 : leave_note
				},
			function(data,status){
					$('.leave_notification').html(data);
						setTimeout(function () {
							window.location.reload();
							}, 3000);
			});
	});
	
	//for updating after the approval after approving the leave request
	$(document).on('click','.leave_approval',function(e){
		var leave_sno = $(this).prev().val();//('.leave_sno')
		var leave_val = 1;// if 1, then approved , 0 , then rejected
		var leave_url = 'leave_approval_rejection.ajax.php';
		$.post(
			leave_url,{
				lv1 : leave_sno, lv2 : leave_val
				},
			function(data,status){
					// $('.leave_manage_notification').html(data);
						// setTimeout(function () {
						// $().slideUp();
							 $('.leave_manage_notification').fadeOut(800, function(){
								$('.leave_manage_notification').html(data).fadeIn().delay(2000);

							});
							//}, 3000);
						//$('.leave_manage_notification').html();
			});
		e.preventDefault();
	});
	
		//for updating after the approval after rejecting the leave request
	$(document).on('click','.leave_rejection',function(e){
		
		var leave_sno = $(this).prev().prev().val();
		//alert(leave_sno);
		var leave_val = 0;// if 1, then approved , 0 , then rejected
		var leave_url = 'leave_approval_rejection.ajax.php';
		$.post(
			leave_url,{
				lv1 : leave_sno, lv2 : leave_val
				},
			function(data,status){
					$('.leave_manage_notification').html(data);
						setTimeout(function () {
					$('.leave_manage_notification').slideUp();
							}, 3000);
					$('.leave_manage_notification').html();
			});
		e.preventDefault();
	});
		
		$(document).on('click','.close_leave',function(){
			location.reload();
		});
		
	//for the loading from the ajax, the gif for loading
	$(document).ajaxSend(function(event, request, settings) {
		  $('#loading_image').show();
		});

		$(document).ajaxComplete(function(event, request, settings) {
		  $('#loading_image').hide();
		});
});
</script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script>
$(function() {
//Date picker
    $('#datepicker').datepicker({
		//"setDate": new Date(),
      autoclose: true
    });
	//Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
});


//for the display of clock

</script>
<!-- jQuery 2.2.3 -->

<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/fullcalendar/fullcalendar.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script><!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- date time clock -->
<script src="plugins/date_time/date_time.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--script src="dist/js/pages/dashboard2.js"></script-->

<!--IMPORTANT CUSTOM JS FILES with php extension for fetching statistical data.-->
<!--for statistics of total requests from user-->
<script type="text/javascript" src="pages/user_statistics_pie_chart_total.php"></script>
<!--for statistics of Monthly requests from user-->
<script type="text/javascript" src="pages/user_statistics_pie_chart_monthly.php"></script>
<!-- IMPORTANT CUSTOM JS FILES ENDS-->

<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
</body>
</html>
