<?php 
//this is for fetching the counts of , requested , accpted , rejected equipments booking of particular user.
	
	if (session_id() == '') {
    session_start();
	//$session_name = $_SESSION['first_name'];
	}
		//for restricting the user for pressing backspace button after log out.
	if(!isset($_SESSION['logged_in'])) {
		  header("Location: login.php"); 
	}  
	 
	 if(isset($_SESSION['s_id'])){
		$login_id = $_SESSION['s_id'];
		$login_name =$_SESSION['name'];
		$dept = $_SESSION['dept'];
		
	 }
 
	include('../required/db_connection.php');
	include('../required/tables.php');
	require('../required/functions.php');
	
	//Queries needs to be written here to fetch count values for each department.
	$Aero_query = "SELECT count(*) AS Aero_Count FROM res_master rm WHERE DEPT=1";
	$Aero_Count = db_one($Aero_query);

	//echo $Aero_Count[0];
	$ARCH_query = "SELECT count(*) AS ARCH_Count FROM res_master rm WHERE DEPT=2";
	$ARCH_Count = db_one($ARCH_query);

	$CHY_query = "SELECT count(*) AS CHY_Count FROM res_master rm WHERE DEPT=3";
	$CHY_Count = db_one($CHY_query);

	$CV_query = "SELECT count(*)AS CV_Count FROM res_master rm WHERE DEPT=4";
	$CV_Count = db_one($CV_query);

	$CC_query = "SELECT count(*) AS CC_Count FROM res_master rm WHERE DEPT=5";
	$CC_Count = db_one($CC_query);

	$CSE_query = "SELECT count(*) AS CSE_Count FROM res_master rm WHERE DEPT=6";
	$CSE_Count = db_one($CSE_query);

	$DeanAca_query = "SELECT count(*) AS DeanAca_Count FROM res_master rm WHERE DEPT=7";
	$DeanAca_Count = db_one($DeanAca_query);

	$DeanAdmin_query = "SELECT count(*) AS DeanAdmin_Count FROM res_master rm WHERE DEPT=8";
	$DeanAdmin_Count = db_one($DeanAdmin_query);

	$DeanInfra_query = "SELECT count(*) AS DeanInfra_Count  FROM res_master rm WHERE DEPT=9";
	$DeanInfra_Count = db_one($DeanInfra_query);

	$DeanRD_query = "SELECT count(*) AS DeanRD_Count FROM res_master rm WHERE DEPT=10";
	$DeanRD_Count = db_one($DeanRD_query);

	$DeanSA_query = "SELECT count(*) AS DeanSA_Count FROM res_master rm WHERE DEPT=11";
	$DeanSA_Count = db_one($DeanSA_query);

	$ElecMaint_query = "SELECT count(*) AS ElecMaint_Count FROM res_master rm WHERE DEPT=12";
	$ElecMaint_Count = db_one($ElecMaint_query);

	$EE_query = "SELECT count(*) AS EE_Count FROM res_master rm WHERE DEPT=13";
	$EE_Count = db_one($EE_query);

	$ECE_query = "SELECT count(*) AS ECE_Count FROM res_master rm WHERE DEPT=14";
	$ECE_Count = db_one($ECE_query);

	$ExamSec_query = "SELECT count(*) AS ExamSec_Count FROM res_master rm WHERE DEPT=15";
	$ExamSec_Count = db_one($ExamSec_query);

	$ISE_query = "SELECT count(*) AS ISE_Count FROM res_master rm WHERE DEPT=16";
	$ISE_Count = db_one($ISE_query);

	$Library_query = "SELECT count(*) AS Library_Count FROM res_master rm WHERE DEPT=17";
	$Library_Count = db_one($Library_query);

	$Maintenance_query = "SELECT count(*) AS Maintenance_Count FROM res_master rm WHERE DEPT=18";
	$Maintenance_Count = db_one($Maintenance_query);

	$MBA_query = "SELECT count(*) AS MBA_Count FROM res_master rm WHERE DEPT=19";
	$MBA_Count = db_one($MBA_query);

	$MCA_query = "SELECT count(*) AS MCA_Count FROM res_master rm WHERE DEPT=20";
	$MCA_Count = db_one($MCA_query);

	$Maths_query = "SELECT count(*) AS Maths_Count FROM res_master rm WHERE DEPT=21";
	$Maths_Count = db_one($Maths_query);

	$ME_query = "SELECT count(*) AS ME_Count FROM res_master rm WHERE DEPT=22";
	$ME_Count = db_one($ME_query);

	$Office_query = "SELECT count(*) AS Office_Count FROM res_master rm WHERE DEPT=23";
	$Office_Count = db_one($Office_query);

	$PHY_query = "SELECT count(*) AS PHY_Count FROM res_master rm WHERE DEPT=24";
	$PHY_Count = db_one($PHY_query);

	$Placement_query = "SELECT count(*) AS Placement_Count FROM res_master rm WHERE DEPT=25";
	$Placement_Count = db_one($Placement_query);

	$Sports_query = "SELECT count(*) AS Sports_Count FROM res_master rm WHERE DEPT=26";
	$Sports_Count = db_one($Sports_query);
		
	
	
$value = '[
    {
      value: '.($Aero_Count["Aero_Count"]==0?0:$Aero_Count["Aero_Count"]).',
      color: "#F4D03F",
      highlight: "#F4D03F",
      label: "Aeronautical Engineering"
    },
    {
      value: '.($ARCH_Count['ARCH_Count']==0?0: $ARCH_Count['ARCH_Count']).',
      color: "#00a65a",
      highlight: "#00a65a",
      label: "Architecture"
    },
    {
      value: '.($CHY_Count['CHY_Count']==0?0: $CHY_Count['CHY_Count']).',
      color: "#A1EBE8",
      highlight: "#A1EBE8",
      label: "Chemistry"
    },
	{
      value: '.($CV_Count['CV_Count']==0?0: $CV_Count['CV_Count']).',
      color: "#C8E224",
      highlight: "#C8E224",
      label: "Civil Engineering"
    },
	{
      value: '.($CC_Count['CC_Count']==0?0: $CC_Count['CC_Count']).',
      color: "#9660F3",
      highlight: "#9660F3",
      label: "Computer Center"
    },
	{
      value: '.($CSE_Count['CSE_Count']==0?0: $CSE_Count['CSE_Count']).',
      color: "#24E22A",
      highlight: "#9660F3",
      label: "Computer Science & Engineering"
    },
	{
      value: '.($DeanAca_Count['DeanAca_Count']==0?0: $DeanAca_Count['DeanAca_Count']).',
      color: "#24E2AB",
      highlight: "#9660F3",
      label: "Dean Academics"
    },
	{
      value: '.($DeanAdmin_Count['DeanAdmin_Count']==0?0: $DeanAdmin_Count['DeanAdmin_Count']).',
      color: "#24C8E2",
      highlight: "#9660F3",
      label: "Dean Admin"
    },
	{
      value: '.($DeanInfra_Count['DeanInfra_Count']==0?0: $DeanInfra_Count['DeanInfra_Count']).',
      color: "#246CE2",
      highlight: "#9660F3",
      label: "Dean Infra & Planning"
    },
	{
      value: '.($DeanRD_Count['DeanRD_Count']==0?0: $DeanRD_Count['DeanRD_Count']).',
      color: "#9124E2",
      highlight: "#9660F3",
      label: "Dean R & D"
    },
	{
      value: '.($DeanSA_Count['DeanSA_Count']==0?0: $DeanSA_Count['DeanSA_Count']).',
      color: "#BA24E2",
      highlight: "#9660F3",
      label: "Dean Student Affairs"
    },
	{
      value: '.($ElecMaint_Count['ElecMaint_Count']==0?0: $ElecMaint_Count['ElecMaint_Count']).',
      color: "#E224D6",
      highlight: "#9660F3",
      label: "Electrical Maintenance"
    },
	{
      value: '.($EE_Count['EE_Count']==0?0: $EE_Count['EE_Count']).',
      color: "#E2246C",
      highlight: "#9660F3",
      label: "Electrical & Electronics Engineering"
    },
	{
      value: '.($ECE_Count['ECE_Count']==0?0: $ECE_Count['ECE_Count']).',
      color: "#E22432",
      highlight: "#9660F3",
      label: "Electronics & Communication Engineering"
    },
	{
      value: '.($ExamSec_Count['ExamSec_Count']==0?0: $ExamSec_Count['ExamSec_Count']).',
      color: "#F9FD07",
      highlight: "#9660F3",
      label: "Exam Section"
    },
	{
      value: '.($ISE_Count['ISE_Count']==0?0: $ISE_Count['ISE_Count']).',
      color: "#A4DCC8",
      highlight: "#9660F3",
      label: "Information Science & Engineering"
    },
	{
      value: '.($Library_Count['Library_Count']==0?0: $Library_Count['Library_Count']).',
      color: "#69774E",
      highlight: "#9660F3",
      label: "Library"
    },
	{
      value: '.($Maintenance_Count['Maintenance_Count']==0?0: $Maintenance_Count['Maintenance_Count']).',
      color: "#A4DCC8",
      highlight: "#9660F3",
      label: "Maintenance"
    },
	{
      value: '.($MBA_Count['MBA_Count']==0?0: $MBA_Count['MBA_Count']).',
      color: "#087554",
      highlight: "#9660F3",
      label: "Master of Business Administration"
    },
	{
      value: '.($MCA_Count['MCA_Count']==0?0: $MCA_Count['MCA_Count']).',
      color: "#AB99C9",
      highlight: "#9660F3",
      label: "Master of Computer Application"
    },
	{
      value: '.($Maths_Count['Maths_Count']==0?0: $Maths_Count['Maths_Count']).',
      color: "#7C6784",
      highlight: "#9660F3",
      label: "Mathematics"
    },
	{
      value: '.($ME_Count['ME_Count']==0?0: $ME_Count['ME_Count']).',
      color: "#04F9CC",
      highlight: "#9660F3",
      label: "Mechanical Engineering"
    },
	{
      value: '.($Office_Count['Office_Count']==0?0: $Office_Count['Office_Count']).',
      color: "#EE9053",
      highlight: "#9660F3",
      label: "Office"
    },
	{
      value: '.($PHY_Count['PHY_Count']==0?0: $PHY_Count['PHY_Count']).',
      color: "#506E4E",
      highlight: "#9660F3",
      label: "Physics"
    },
	{
      value: '.($Placement_Count['Placement_Count']==0?0: $Placement_Count['Placement_Count']).',
      color: "#0326C6",
      highlight: "#9660F3",
      label: "Placement Cell"
    },
	{
      value: '.($Sports_Count['Sports_Count']==0?0: $Sports_Count['Sports_Count']).',
      color: "#FE0485",
      highlight: "#9660F3",
      label: "Sports"
    }
  ]';
  
  $data = $value;