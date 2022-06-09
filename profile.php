<?php ini_set('display_errors', 1);
 
  if (session_id() == '') {
    session_start();
  $login_id = $_SESSION['s_id'];
  $dept_id = $_SESSION['dept'];

  //echo "$login_id<br>";
  //echo "$dept_id";
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
  <title>Resolution Manager | User Profile</title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>R</b>M</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Resolution </b>Manager</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Tasks: style can be found in dropdown.less -->
          <!--li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger">9</span>
            </a>
           
          </li-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="images/GIT-logo.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"> <?php
                   echo  $_SESSION['name'];
                  ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="images/GIT-logo.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php
                   echo  $_SESSION['name'];
                  ?>
                </p>
              </li>
              <!-- Menu Body -->
              
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
          <!-- Control Sidebar Toggle Button -->
          
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
          <img src="images/GIT-logo.jpg" class="img-circle" alt="User Image">
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
      <!-- search form -->
      <!--form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span> Dashboard </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          </li>
        <!--<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>-->
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="images/GIT-logo.jpg" alt="User profile picture">

              <p class="text-muted text-center"> <?php echo $_SESSION['name']?></p>

             

              <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <strong><i class="fa fa-user margin-r-5"></i> Name</strong>

              <p class="text-muted">
               <?php echo $login_query_result['NAME'];?>
              </p>

              <hr>
               <strong><i class="fa fa-building margin-r-5"></i> Department</strong>

              <p class="text-muted"><?php echo $login_query_result['DEPT_ID'];?></p>

              
              <hr>

              <strong><i class="fa fa-envelope margin-r-5"></i> Email id</strong>

              <p class="text-muted">
                <?php echo $login_query_result['EMAIL'];?>
              </p>

              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i> Username</strong>
              <p class="text-muted"><?php echo $login_query_result['USERNAME'];?></p>
              

              <hr>
              <strong><i class="fa fa-mobile margin-r-5"></i> Mobile</strong>

              <p class="text-muted"><?php echo $login_query_result['PHONE'];?></p>
             <hr>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
            </ul>
            
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              
              <!-- /.tab-pane -->

                          <!-- END timeline item -->
                  <!-- timeline item -->
                  
                  <!-- END timeline item -->
                  
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <div class="Update_Notification"></div>
                <form method="POST" id="profile_update" name = "profile_update" class="form-horizontal">
                  
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="hidden" class="form-control" name="login_id" value = "<?php echo $login_id;?>">
                      <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name" value = "<?php echo $login_query_result['NAME'];?>">
                     
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputUsername" placeholder="Username" value = "<?php echo $login_query_result['USERNAME'];?>">
                     
                    </div>
                  </div>
                  <!--<div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputPassword" placeholder="Password" >
                     
                    </div>
                  </div>-->

                 

                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputEmail" placeholder="email" value = "<?php echo $login_query_result['EMAIL'];?>">
                     
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="inputMobile" class="col-sm-2 control-label">Mobile</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputMobile" placeholder="Mobile"value = "<?php echo $login_query_result['PHONE'];?>">
                      
                    </div>
                  </div>

                 <div style="width:230px;" align="center">
                   <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary pull-right" name = "profile_update"> Update </button>
                   </div>        
                  </div>

                 <!-- <div class="form-group">
                   <div class="col-sm-8">
                    <a href="http://localhost/ResManager/index.php"  class="btn btn-primary" name="homepage">Back</a>
                    </div>        
                  </div>
                  </div>-->

                  <?php 
                  /*if(isset($_POST['profilesave'])){
                      $name = $_POST['inputName'];
                      $email = $_POST['inputEmail'];
                      $Username = $_POST['inputUsername'];
                      //$Password = $_POST['inputPassword'];
                      $Mobile = $_POST['inputMobile'];

                      
                            // code...
                          //echo $login_id;
                          $sql = "update user_master set NAME = '$name',EMAIL = '$email', USERNAME = '$Username', PHONE = $Mobile where SNO= '$login_id' ";
                          /*$sql = "insert into user_profile(NAME,EMAIL,DEPARTMENT,QUALIFICATION,EXPERIENCE,MOBILE,ADDRESS)values('$name','$email', '$Department', '$Qualification','$Experience','$Mobile','$Address');"; */        
                        //mysqli_query($con,$sql);
                       // echo '<script>alert("Details Updated successfully")</script>'; 
                        
                              
                      
                        //}
                        
                      ?>
                  </form>

                <!--<form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="inputName" class="form-control" id="inputName" placeholder="Name">
                      <?php
                        $name = $_GET['Name'];
                        echo $name;
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputAddress" placeholder="Address">
                    </div>
                  </div>

                   <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputPassword" placeholder="Password"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Phone</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputPhone" placeholder="Phone">
                    </div>
                  </div>
                 
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Update</button>
                    </div>
                  </div>
                </form>-->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

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
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    
    <!-- Tab panes -->
   
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
$(document).ready(function(){
$(document).on('submit','#profile_update',function(e){
    e.preventDefault();
      $.ajax({
        url: 'ajax/profile_update.ajax.php', 
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(data) {
          $('.Update_Notification').html(data);
          setTimeout(function () {
              window.location.reload();
            }, 1000);
        }
      });
     });   
  });
  </script>>
</body>
</html>
