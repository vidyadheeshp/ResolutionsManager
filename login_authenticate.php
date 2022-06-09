<?php
    @ob_start();
    //	session_start();
	include('pages/required/db_connection.php');
	include('pages/required/tables.php');
	include('pages/required/functions.php');
	
    if( empty(session_id()) && !headers_sent()){
        session_start();
    }
		if(isset($_POST['submit'])){
			$uname = $_POST['username'];
			$password = $_POST['password'];
			//$user_type = $_POST['user_type'];
			if($uname!=''&&$password!=''){
				$encrypted_password  = md5($password);
				$query = "SELECT 
								* 
						  FROM 
								user_master
						 WHERE 
								USERNAME ='".$uname."' AND PASSWORD ='".$encrypted_password."';";
				$result = db_one($query);
				//print_r ($result);
				//break;
				if($result!=NULL){
				    //print_r ($result);
					$_SESSION['s_id']=$result['SNO'];
					$_SESSION['name']=$result['NAME'];
					$_SESSION['dept']=$result['DEPT_ID'];
					$_SESSION['logged_in']=1;
					//$_SESSION['sno']=$result[0];
					    header('Location: index.php');
					    exit;
				  
				}else{
					login_message('<center><strong>Username or password is incorrect</strong></center>',0);
					//echo ;
				}
			}else{
				login_message('<center><strong>Enter both username and password</center></strong>',0);
			}
		}
		@ob_end_flush();
?>