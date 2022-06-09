<?php ini_set('display_errors', 1);
 
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
  <title>ResManager | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
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
   <!-- Bootstrap Counter -->
  <link rel="stylesheet" href="bootstrap/css/counter.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
	#datepicker1{z-index:1151 !important;}
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
		<!-- /.sidebar -->
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<?php //principal Section
				if($login_query_result['USERTYPE'] == 1){
			?>
			<li class="active treeview">
			  <a href="index.php">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li>
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
				<li class="active treeview">
			  <a href="index.php">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li>
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
			<li class="active">
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li>
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<?php //Office Section
			}else if($login_query_result['USERTYPE'] == 4){?>
				<li class="active">
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<li>
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			<?php //Payment Section
			}else if($login_query_result['USERTYPE'] == 5){?>
				<li class="active">
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
				<li>
			  <a href="resolutionlist.php">
				<i class="fa fa-list"></i> <span>Resolution List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
			
			<?php //ADMiN /Suer ADMiN section.
			} else {?>
					<li class="active">
			  <a href="index.php" >
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-right pull-right"></i>
				</span>
			  </a>
			</li>
				<li>
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
        Dashboard
        <!--small>Control panel</small-->
      </h1>
      <ol class="breadcrumb">
        <li class="active"> Home</li>
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
			?>
				<div class="col-lg-12 col-xs-12 col-md-12">
					<div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Statistics </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						<div class="box-body">
						<?php 
									$res_total_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1";
									$res_total_count = db_one($res_total_count_query);

									$res_on_going_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=1";
									$res_ongoing_count = db_one($res_on_going_count_query);

									$res_Completed_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=0";
									$res_completed_count = db_one($res_Completed_count_query);
									?>
							<!--div class="col-xs-4 col-md-4 col-lg-6 text-center" style="border-right: 1px solid #3A00FF">
							  <input type="text" class="knob" data-readonly="true" value="" data-width="100" data-height="100" data-fgColor="#3A00FF">

							  <div class="knob-label">Total Number of Resolution</div>
							</div-->
							<!--Counter Starts -->
							<div class="container">
							    <div class="row">
							        <div class="col-md-3 col-sm-6">
							            <div class="counter blue">
							                <div class="counter-icon">
							                    <i class="fa fa-solid fa-file"></i>
							                </div>
							                <h3>Total Resolutions</h3>
							                <span class="counter-value"><?php echo $res_total_count['res_count']?></span>
							            </div>
							        </div>
							        <div class="col-md-3 col-sm-6">
							            <div class="counter orange">
							                <div class="counter-icon">
							                    <i class="fa fa-light fa-file"></i>
							                </div>
							                <h3>On-Going Resolutions</h3>
							                <span class="counter-value"><?php echo $res_ongoing_count['res_count']?></span>
							            </div>
							        </div>
							        <div class="col-md-3 col-sm-6">
							            <div class="counter green">
							                <div class="counter-icon">
							                    <i class="fa fa-duotone fa-file"></i>
							                </div>
							                <h3>Completed Resolutions</h3>
							                <span class="counter-value"><?php echo $res_completed_count['res_count']?></span>
							            </div>
							        </div>

							    </div>
							</div>
							<!--Counter ENds-->
						</div>
					</div>
				</div>
				<div class="col-md-6">
				  <!-- PIE CHART FOR OVERALL RESOLUTIONS-->
				  <div class="box box-danger">
					<div class="box-header with-border">
					  <h3 class="box-title">Resolutions(Department wise)</h3>

					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
					  </div>
					</div>
					<div class="box-body">
					  <canvas id="pieChart1" style="height:250px"></canvas>
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
				</div>
				
				<div class="col-md-6">
					<!-- BAR CHART -->
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Month Wise </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						<div class="box-body">
						  <div class="chart">
							<canvas id="barChart" style="height:230px"></canvas>
						  </div>
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
				</div>
				<!--Categorywise list of resolutions-->
				<div class="col-md-6">
					<!-- BAR CHART -->
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Category Wise </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						<div class="box-body">
						  <div class="chart">
							<canvas id="barChart1" style="height:230px"></canvas>
						  </div>
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
				</div>
				<!--Categorywise list of resolutions-->
				<div class="col-md-6">
					<!-- BAR CHART -->
					  <div class="box box-danger">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Sanctioning Authority Wise </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						<div class="box-body">
						  <div class="chart">
							<canvas id="barChart2" style="height:230px"></canvas>
						  </div>
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
				</div>
				<!--Principal Section Ends-->
			<?php //GC- Chairman Section
				}else if($login_query_result['USERTYPE'] == 2){
			?>
				<div class="col-lg-12 col-xs-12 col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Resolutions - Statistics </h3>

					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
					  </div>
					</div>
					<div class="box-body">
					<?php 
								$res_total_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1";
								$res_total_count = db_one($res_total_count_query);

								$res_on_going_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=1";
								$res_ongoing_count = db_one($res_on_going_count_query);

								$res_Completed_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=0";
								$res_completed_count = db_one($res_Completed_count_query);
								?>
						<!--div class="col-xs-4 col-md-4 col-lg-6 text-center" style="border-right: 1px solid #3A00FF">
						  <input type="text" class="knob" data-readonly="true" value="" data-width="100" data-height="100" data-fgColor="#3A00FF">

						  <div class="knob-label">Total Number of Resolution</div>
						</div-->
						<!--Counter Starts -->
						<div class="container">
						    <div class="row">
						        <div class="col-md-3 col-sm-6">
						            <div class="counter blue">
						                <div class="counter-icon">
						                    <i class="fa fa-solid fa-file"></i>
						                </div>
						                <h3>Total Resolutions</h3>
						                <span class="counter-value"><?php echo $res_total_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter orange">
						                <div class="counter-icon">
						                    <i class="fa fa-light fa-file"></i>
						                </div>
						                <h3>On-Going Resolutions</h3>
						                <span class="counter-value"><?php echo $res_ongoing_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter green">
						                <div class="counter-icon">
						                    <i class="fa fa-duotone fa-file"></i>
						                </div>
						                <h3>Completed Resolutions</h3>
						                <span class="counter-value"><?php echo $res_completed_count['res_count']?></span>
						            </div>
						        </div>

						    </div>
						</div>
						<!--Counter ENds-->
					</div>
				</div>
			</div>
				<div class="col-md-6">
				  <!-- PIE CHART FOR OVERALL RESOLUTIONS-->
				  <div class="box box-danger">
					<div class="box-header with-border">
					  <h3 class="box-title">Resolutions(Department wise)</h3>

					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
					  </div>
					</div>
					<div class="box-body">
					  <canvas id="pieChart1" style="height:250px"></canvas>
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
				</div>
				
				<div class="col-md-6">
					<!-- BAR CHART -->
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Month Wise </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						<div class="box-body">
						  <div class="chart">
							<canvas id="barChart" style="height:230px"></canvas>
						  </div>
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
				</div>
				<!--Categorywise list of resolutions-->
				<div class="col-md-6">
					<!-- BAR CHART -->
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Category Wise </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						<div class="box-body">
						  <div class="chart">
							<canvas id="barChart1" style="height:230px"></canvas>
						  </div>
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
				</div>
				<!--Categorywise list of resolutions-->
				<div class="col-md-6">
					<!-- BAR CHART -->
					  <div class="box box-danger">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Sanctioning Authority Wise </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						<div class="box-body">
						  <div class="chart">
							<canvas id="barChart2" style="height:230px"></canvas>
						  </div>
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
				</div>
			<?php //HOD/ Section Head Section
				}elseif($login_query_result['USERTYPE'] == 3){
			?>
				<div class="col-md-12">
					<!-- BAR CHART -->
					  <div class="box box-danger">
						<div class="box-header with-border">
						  <h3 class="box-title">Resolutions - Status </h3>

						  <div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
						  </div>
						</div>
						
						
						<div class="box-body">

							<?php 
						$res_complete_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND status=0 AND DEPT=".$dept_id;
						$res_complete_count = db_one($res_complete_count_query);

						$res_pending_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND status=1 AND DEPT=".$dept_id;
							$res_pending_count = db_one($res_pending_count_query);

								$res_total_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND DEPT=".$dept_id;
							$res_total_count = db_one($res_total_count_query);

						?>
							<!--Counter Starts -->
						<div class="container">
						    <div class="row">
						        <div class="col-md-3 col-sm-6">
						            <div class="counter blue">
						                <div class="counter-icon">
						                    <i class="fa fa-solid fa-file"></i>
						                </div>
						                <h3>Total Resolutions</h3>
						                <span class="counter-value"><?php echo $res_total_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter orange">
						                <div class="counter-icon">
						                    <i class="fa fa-light fa-file"></i>
						                </div>
						                <h3>On-Going Resolutions</h3>
						                <span class="counter-value"><?php echo $res_pending_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter green">
						                <div class="counter-icon">
						                    <i class="fa fa-duotone fa-file"></i>
						                </div>
						                <h3>Completed Resolutions</h3>
						                <span class="counter-value"><?php echo $res_complete_count['res_count']?></span>
						            </div>
						        </div>

						    </div>
						</div>
						<!--Counter ENds-->

							<!--div class="col-xs-4 text-center" style="border-right: 1px solid #17FF00">
							  <input type="text" class="knob" data-readonly="true" value="" data-width="100" data-height="100" data-fgColor="#17FF00">

							  <div class="knob-label">Resolution Cycle Completed</div>
							</div>
							<div class="col-xs-4 text-center" style="border-right: 1px solid #FF7C00">
							  <input type="text" class="knob" data-readonly="true" value="" data-width="100" data-height="100" data-fgColor="#FF7C00">

							  <div class="knob-label">Pending Resolution</div>
							</div>
							
							<div class="col-xs-4 text-center" style="border-right: 1px solid #3A00FF">
							  <input type="text" class="knob" data-readonly="true" value="" data-width="100" data-height="100" data-fgColor="#3A00FF">

							  <div class="knob-label">Total Number of Resolution</div>
							</div-->
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
				</div>
					   
			<?php //**************Office Section*****************//
				}elseif($login_query_result['USERTYPE'] == 4){
				
				//include_once('generate_compliance.php');
			?>
				
				<div class="col-lg-3 col-xs-6 col-md-4">
			  <!-- small box -->
				  <div class="small-box bg-aqua">
					<div class="inner">
					 <?php $res_count_query ="SELECT count(*) AS res_count FROM res_master rm WHERE 1=1";
						 $Resolutions_count = db_one($res_count_query);
					?>
					  <h3><?php echo($Resolutions_count['res_count']); ?></h3>

					  <p>Resolutions</p>
					</div>
					<div class="icon">
					  <i class="fa fa-pencil"></i>
					</div>
					<button type="button" class="small-box-footer form-control" id="add_res" data-toggle="modal" data-target="#add_res_modal">Add <i class="fa fa-plus"></i></button>
							<div class="modal fade" id="add_res_modal" role="dialog">
								  <div class="modal-dialog modal-lg">
									<div class="modal-content">
									  <div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title"> <i class="fa fa-plus"></i> Add Resolution</h4>
									  </div>
									  
									<span class="help-block">
										<div class="resolution_added_notification">
											<div id="loading_image" style="display:none;"></div>
										
									<form method="post" id="res_add" enctype="multipart/form-data" role="form">
										<div class="modal-body">
												<div class="form-group">
													<label class="help-block">Resolution Title : <span class="text-danger">*</span></label>
													<input type="text" id="res_title" required name="res_title" class="form-control" placeholder="Enter a Title for resolution"/>
												</div>
												<div class="form-group col-md-4">
													<label class="help-block">Resolution Category : <span class="text-danger">*</span></label>
													<select id="cat_id" required name="cat_id" class="form-control res_cat">
														<option value="0">Choose One</option>
													<?php 
														$Category_query = "SELECT CID,CATEGORY FROM mr_category WHERE 1=1";
														$category_result = db_all($Category_query);
														$cr_str = "";
														foreach($category_result AS $cr){
															$cr_str .="<option value=".$cr['CID']." class='help-block'>".$cr['CATEGORY']."</option>";
														}
														echo $cr_str;
													?>
													</select>
												</div>
												<!--div class="form-group col-md-4">
													<label class="help-block">Resolution Status :</label>
													<div class="res_status">
														
														
													</div>
												</div-->
												<div class="form-group col-md-4">
													<label class="help-block">Resolution Date: <span class="text-danger">*</span></label>

													<div class="input-group date">
													  <div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													  </div>
													  <input type="text" required class="form-control pull-right res_date" name="res_date" id="datepicker1">
													</div>
													<!-- /.input group -->
												</div>
												<div class="form-group col-md-4">
													<label class="help-block">Department : <span class="text-danger">*</span></label>
													<select id="dept" required name="dept" class="form-control">
														<option>Choose One</option>
													<?php 
														$Dept_query = "SELECT id,deptname FROM mr_department WHERE 1=1";
														$Dept_result = db_all($Dept_query);
														$d_str = "";
														foreach($Dept_result AS $d){
															$d_str .="<option value=".$d['id']." class='help-block'>".$d['deptname']."</option>";
														}
														echo $d_str;
													?>
													</select>
												</div>
												<div class="form-group col-md-4">
													<label class="help-block">Resolution Number <span class=""></span></label>
													<input type="text" class="form-control" id="res_no" name="res_no" placeholder="Enter the Resolution Number"/>
												</div>
												<div class="form-group col-md-4">
													<label class="help-block">Sanctioning Authority : <span class="text-danger">*</span></label>
													<select id="sanctioning_auth" name="sanctioning_auth" required class="form-control">
														<option>Choose One</option>
													<?php 
														$SancAuthority_query = "SELECT AID,AUTHORITY FROM mr_sancauthority WHERE 1=1";
														$SancAuthority_result = db_all($SancAuthority_query);
														$sa_str = "";
														foreach($SancAuthority_result AS $sa){
															$sa_str .="<option value='".$sa['AID']."' class='help-block'>".$sa['AUTHORITY']."</option>";
														}
														echo $sa_str;
													?>
													</select>
												</div>
												<div class="clearfix"></div>
												<div class="form-group col-md-4">
													<label class="help-block">Want to inform Concerned Person ? : <button class="btn btn-sm btn-primary extra_email">Yes</button></label>
													<!--This is where an input box appears, and if needed the resolution concerned to any person will be informed-->
													
												</div>
												<div class="col-md-8">
													<div class="extra-info-mails input-group"></div>
												</div>
												
												<div class="clearfix"></div>
												<div class="form-group text-center row">
													<label class="help-block">
													  <input type="radio" name="optionsRadios"  id="optionsRadios2" value="1">
													  Upload Image
													  &nbsp;&nbsp;&nbsp;&nbsp;
													<!--/label>
													<label class="help-block"-->
													  <input type="radio" name="optionsRadios"  id="optionsRadios2" value="2">
													  Type the Text
													</label>
												</div>
												
												<div class="clearfix"></div>
												<div class="form-group upload_image hidden">
													<label class="help-block">Resolution Image :<span class="text-danger">*</span></label>
													<input type="file"  name="res_image" class="res_image" accept="application/jpeg"/>
												    
												</div>
												<div class="form-group type_text hidden">
													<label class="help-block">Resolution Text :<span class="text-danger">*</span></label>
													<textarea class="form-control" id="res_doc" name="res_doc" rows="20" cols="20"></textarea>
													<!--input type="file"  name="res_doc" class="" accept="application/pdf"/-->
												    
												</div>
												
												<div class="clearfix"></div>
										</div>
											
										<div class="modal-footer">
											<button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Close</button>
											<button type="reset" class="btn btn-default btn-flat"></i> Reset</button>
											<button type="submit" class="btn btn-primary btn-flat" id="add_resolution"><i class="fa fa-plus"></i> ADD</button>
										</div>
									</form>
									</div>
									</span><!--end of help block-->
								</div>
								<!-- /.modal-content -->
							  </div>
							  <!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
					</div>
				</div>
			<div class="col-lg-8 col-xs-12 col-md-8">
				<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Resolutions - Statistics </h3>

					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
					  </div>
					</div>
					<div class="box-body">
					<?php 
								$res_total_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1";
								$res_total_count = db_one($res_total_count_query);

								$res_on_going_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=1";
								$res_ongoing_count = db_one($res_on_going_count_query);

								$res_Completed_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=0";
								$res_completed_count = db_one($res_Completed_count_query);
								?>
						<!--div class="col-xs-4 col-md-4 col-lg-6 text-center" style="border-right: 1px solid #3A00FF">
						  <input type="text" class="knob" data-readonly="true" value="" data-width="100" data-height="100" data-fgColor="#3A00FF">

						  <div class="knob-label">Total Number of Resolution</div>
						</div-->
						<!--Counter Starts -->
						<div class="container">
						    <div class="row">
						        <div class="col-md-3 col-sm-6">
						            <div class="counter blue">
						                <div class="counter-icon">
						                    <i class="fa fa-solid fa-file"></i>
						                </div>
						                <h3>Total Resolutions</h3>
						                <span class="counter-value"><?php echo $res_total_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter orange">
						                <div class="counter-icon">
						                    <i class="fa fa-light fa-file"></i>
						                </div>
						                <h3>On-Going Resolutions</h3>
						                <span class="counter-value"><?php echo $res_ongoing_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter green">
						                <div class="counter-icon">
						                    <i class="fa fa-duotone fa-file"></i>
						                </div>
						                <h3>Completed Resolutions</h3>
						                <span class="counter-value"><?php echo $res_completed_count['res_count']?></span>
						            </div>
						        </div>

						    </div>
						</div>
						<!--Counter ENds-->
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-lg-12 col-xs-12 col-md-12">
				<div class="box box-warning">
					<div class="box-header with-border">
					  <h3 class="box-title">Resolutions - Compliance </h3>

					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
					  </div>
					</div>
					<div class="box-body">
						<form>
								<div class="form-group col-md-4">
									<div class="input-group date">
									  <div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									  </div>
									  <input type="text" required class="form-control pull-right resolution_date" name="" placeholder="Resolution Date" id="datepicker">
									</div>
									<!-- /.input group -->
								</div>
								<div class="form-group col-md-4">
										<button type="button" class="btn btn-primary" id="comp_generate"><i class="fa fa-search"></i> Search</button>
								
								
								</div>
						</form>
							<div class="compliance-report-content">
									<div id="loading_image" style="display:none;"></div>
							</div>
					
					</div>
				</div>
			</div>
			<?php //User type = 5 Payment Section
				}else if($login_query_result['USERTYPE'] == 5){	
			?>
			<div class="col-lg-8 col-xs-4 col-md-8">
				<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Resolutions - Statistics </h3>

					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<!--button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
					  </div>
					</div>
					<div class="box-body">
						<?php 
								$res_total_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1";
								$res_total_count = db_one($res_total_count_query);

								$res_on_going_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=1";
								$res_ongoing_count = db_one($res_on_going_count_query);

								$res_Completed_count_query = "SELECT COUNT(*) AS res_count FROM res_master WHERE 1=1 AND STATUS=0";
								$res_completed_count = db_one($res_Completed_count_query);
								?>
					<!--Counter Starts -->
						<div class="container">
						    <div class="row">
						        <div class="col-md-3 col-sm-6">
						            <div class="counter blue">
						                <div class="counter-icon">
						                    <i class="fa fa-solid fa-file"></i>
						                </div>
						                <h3>Total Resolutions</h3>
						                <span class="counter-value"><?php echo $res_total_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter orange">
						                <div class="counter-icon">
						                    <i class="fa fa-light fa-file"></i>
						                </div>
						                <h3>On-Going Resolutions</h3>
						                <span class="counter-value"><?php echo $res_ongoing_count['res_count']?></span>
						            </div>
						        </div>
						        <div class="col-md-3 col-sm-6">
						            <div class="counter green">
						                <div class="counter-icon">
						                    <i class="fa fa-duotone fa-file"></i>
						                </div>
						                <h3>Completed Resolutions</h3>
						                <span class="counter-value"><?php echo $res_completed_count['res_count']?></span>
						            </div>
						        </div>

						    </div>
						</div>
						<!--Counter ENds-->
					</div>
				</div>
			</div>
			<?php //ADMIN /SUPER ADMIN content.
			}else{?>
				
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
	<?php   } ?>			
				
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
<script type="text/javascript" src="plugins/table2excel/dist/jquery.table2excel.min.js"></script>

<script>
$(document).ready(function(){	
	//for clock
  setInterval('updateClock()', 1000);
  
/*Commented on 16/3/2022 , as its not needed as per the requirement.
 	//for auto Selecting the status of selected category
	$(document).on('change','.res_cat',function(e){
		e.preventDefault();
		var category_id = $(this).val();
		//alert(name_string);
		var url = 'ajax/generate_catagory_status_list.ajax.php';
		if(category_id >0){
		$.post(
			url,{
				c1 : category_id
			},
			function(data,status){
					$('.res_status').html(data);
			});
		}else{
			alert("Choose the correct catogory");
		}	
	});
	*/
	$(document).on('click','#optionsRadios2',function(e){
		e.preventDefault();
		var raddio_button_val = $(this).val();
		if( raddio_button_val == 1){
			$('.upload_image').removeClass('hidden');
			$('.type_text').addClass('hidden');
		}else{
			$('.type_text').removeClass('hidden');
			$('.upload_image').addClass('hidden');
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


	
	
	//form processing for storing resolution data.
	$(document).on('submit','#res_add',function(e){
		e.preventDefault();
		/*var res_title = $('#res_title').val();
		var cat_id = $('#cat_id').val();
		//var res_status_id = $('#res_status_id').val();
		var res_date = $('.res_date').val();
		var dept = $('#dept').val();
		var res_no = $('#res_no').val();
		var sanctioning_auth = $('#sanctioning_auth').val();
		var res_image = $('.res_image').prop('files')[0];
		//;//val();//
		var res_doc = $('#res_doc').val();
		
		//alert(res_image);
		//alert(res_title+'-'+cat_id+'-'+res_status_id+'-'+res_date+'-'+dept+'-'+res_no+'-'+sanctioning_auth+'-'+res_doc+'-'+res_image);
		//alert()
		//var url = 'ajax/save_resolution_data.ajax.php';
		if(res_title == "" || cat_id == 0  || res_date == "" || dept == 0 || sanctioning_auth == 0  || (typeof(res_image) != "undefined" && res_image !== null)){
			alert("Fill all the fields");
			
		}else{*/
			//var formData = new FormData()
			//alert('Everything is filled up');
			$.ajax({
				url: 'ajax/save_resolution_data.ajax.php', 
				type: 'POST',
				data: new FormData(this),
				processData: false,
				contentType: false,
				success: function(data) {
					$('.resolution_added_notification').html(data);
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
//****** Compliance Generation *******//
$(document).on('click','#comp_generate',function(e){
		e.preventDefault();
		var res_date_val = $('.resolution_date').val();
		//alert(res_date_val);
		var comp_generate_url = 'ajax/compliance_generate.ajax.php';
		if(res_date_val == ''){
			alert('Date Not set');
		}else{
		$("div #loading_image").removeAttr("style");
		$.post(
				comp_generate_url,{
					p1 : res_date_val
				},
				function(data,status){
						$('.compliance-report-content').html(data);
						/*setTimeout(function () {
							window.location.reload();
						}, 3000);*/
					});
		}
	});

	$(document).on('click','#export_btn',function(e){
	 var compliance_date = $(this).prev().val();
	 //alert();
		$(".compliance_report_table").table2excel({
		name: "Report",
		filename: "ComplianceReport_"+compliance_date,//do not include extension
		fileext: ".xls" // file extension
	  });
	});

		/*var target = $(this).attr('id');
		switch(target){
			case 'export_btn':
			$('#hidden-type').val(target);
			$('#export-form').submit();
			$('#hidden-type').val('');
			break;
		}*/

	
	//for adding the equipment
	$(document).on('click','#add_equipment',function(e){
		e.preventDefault();
		//alert('clicked');
		var equip_name = $('#equip_name').val();
		var equip_id = $('#equip_id').val();
		var equip_desc = $('#equip_desc').val();
		var equip_quantity = $('#equip_quantity').val();
		var unit_price = $('#unit_price').val();
		//alert(equip_name+'-'+equip_id+'-'+equip_desc);
		var url='add_equipment.ajax.php';
		//checking for un-filled fields. 
		if(equip_name == '' || equip_desc == '' || equip_quantity == '' || unit_price == ''){
			alert ('Please Fill All the Fields.');
			if(equip_name == ''){
				$('#equip_name').focus();
			}else if(equip_desc == ''){
				$('#equip_desc').focus();
			}else{
				$('#equip_quantity').focus();
				
			}
		}else{
				 $("div #loading_image").removeAttr("style");
		$.post(
			url,{
				e1 : equip_name, e2 : equip_id, e3 : equip_desc, e4 : equip_quantity, e5 : unit_price
			},
			function(data,status){
				$('.equipment_added_notification').html(data);
						setTimeout(function () {
							window.location.reload();
							}, 5000);
					  //$('#loader').hide();
			});
		}
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
	$(document).on('click','#postarticle',function(e){
		e.preventDefault();
		var title = $('#title').val();
		var article_text = $('#article_text').val();
		var url = 'save_article.ajax.php';
		//alert(title+'-'+article_text);
		$.post(
			url,{
				e1 : title, e2 : article_text, edit :0
				},
			function(data,status){
					$('.article_notification').html(data);
						setTimeout(function () {
							window.location.reload();
							}, 3000);
			});
	});
	
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
    $('#datepicker1').datepicker({
    	autoclose: true,
    	 setDate : new Date()
    });
    $('#datepicker').datepicker({
    	autoclose: true,
    	defaultDate : new Date()
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
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<script>
  $(function () {
    /* jQueryKnob */

    $(".knob").knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv)  // Angle
              , sa = this.startAngle          // Previous start angle
              , sat = this.startAngle         // Start angle
              , ea                            // Previous end angle
              , eat = sat + a                 // End angle
              , r = true;

          this.g.lineWidth = this.lineWidth;

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3);

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }

          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();

          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();

          return false;
        }
      }
    });
	
});
    /* END JQUERY KNOB */
</script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

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
<script type="text/javascript" src="pages/principal/display_dept_overall_stat.php"></script>
<!--for statistics of Monthly requests from user-->
<script type="text/javascript" src="pages/user_statistics_pie_chart_monthly.php"></script>
<!-- IMPORTANT CUSTOM JS FILES ENDS-->

<!--Bar chart data (Principal Login)-->
<!-- ChartJS 1.0.1  IMPORTANT (REQUIRED FOR CHART)-->
<script src="plugins/chartjs/Chart.min.js"></script>
<script type="text/javascript" src="pages/principal/display_monthwise_barchart.php"></script>
<script type="text/javascript" src="pages/principal/display_categorywise_barchart.php"></script>
<script type="text/javascript" src="pages/principal/display_sanctiningA_wise_barchart.php"></script>

<!--Bar chart data ends-->	
	
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="bootstrap/js/counter.js"></script>
</body>
</html>
