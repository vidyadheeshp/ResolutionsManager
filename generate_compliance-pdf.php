<?php 

	include('pages/required/db_connection.php');
	include('pages/required/tables.php');
	require('pages/required/functions.php');

	require_once __DIR__ . '/vendor/autoload.php';

	$res_date = db_date($_GET['date']);//12;
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
													AND rm.RESDATE='".$res_date."'";
								$res_rows = db_all($res_query);





	
	

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);//(['mode' => 'utf-8', 'format' => [210, 149]]);
//$mpdf->SetHeader('<h1>Sri Krishna Math & Sabhabhavan</h1> <br/><h3>RPD Belagavi - 590008</h3>');


//header content
$header_arr = array (
    'L' => array (
      'content' => 'KLS-GIT',
      'font-size' => 10,
      'font-style' => 'B',
      'font-family' => 'serif',
      'color'=>'#000000'
    ),
    'C' => array (
      'content' => '<h3>GC Resolution Compliance</h3>',
      'font-size' => 10,
      'font-style' => 'B',
      'font-family' => 'serif',
      'color'=>'#000000'
    ),
    'R' => array (
      'content' => '{DATE d-m-Y}',
      'font-size' => 10,
      'font-style' => 'B',
      'font-family' => 'serif',
      'color'=>'#000000'
    ),
    'line' => 1,
);

//footer content
$footer_arr = array (
    'odd' => array (
        'L' => array (
            'content' => '',
            'font-size' => 10,
            'font-style' => 'B',
            'font-family' => 'serif',
            'color'=>'#000000'
        ),
        'C' => array (
            'content' => ' ',
            'font-size' => 10,
            'font-style' => 'B',
            'font-family' => 'serif',
            'color'=>'#000000'
        ),
        'R' => array (
            'content' => '{DATE d-m-Y}',
            'font-size' => 10,
            'font-style' => 'B',
            'font-family' => 'serif',
            'color'=>'#000000'
        ),
        'line' => 1,
    ),
    'even' => array ()
);

$mpdf->SetHeader($header_arr, 'O');
$reciept_html_content = '';
$reciept_html_content .="
	<table id='example1' class='table table-bordered table-hover'>
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
								<tbody>";

								$reciept_html_content = "";
								$i = 1;
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
									$reciept_html_content .="<tr>
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



								$reciept_html_content .="</tbody>
								
						</table>";
					

//$mpdf->SetFooter($footer_arr);

$mpdf->defaultheaderfontsize=10;
$mpdf->defaultheaderfontstyle='B';
$mpdf->defaultheaderline=0;

//for printing kannada scripts.
$mpdf->autoScriptToLang=true;
$mpdf->autoLangToFont=true;


//$mpdf->setWatermarkImage("images/krishna.jpg",0.3,'D','P');
//$mpdf->showWatermarkImage = true;
$mpdf->WriteHTML($reciept_html_content);
//for repeating the reciept content.
$mpdf->SetHeader($header_arr, 'O');
$mpdf->WriteHTML($reciept_html_content);
$mpdf->Output();
?>