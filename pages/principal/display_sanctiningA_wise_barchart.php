<?php
	//this is for the pie chart for displaying the total requests of equipment bookings
    header("Content-type: text/javascript");
	//include_once('get_dept_overall_stat.php');
		include('../required/db_connection.php');
		include('../required/tables.php');
		require('../required/functions.php');
	
	
		$SAwise_count_query1 = "SELECT count(*) AS SA_count FROM res_master rm WHERE DATE_FORMAT(RESDATE,'%Y')=".date('Y')." AND AID=1";
		$SAwise_count1 = db_one($SAwise_count_query1);	
		
		$SAwise_count_query2 = "SELECT count(*) AS SA_count FROM res_master rm WHERE DATE_FORMAT(RESDATE,'%Y')=".date('Y')." AND AID=2";
		$SAwise_count2 = db_one($SAwise_count_query2);	
		
		$SAwise_count_query3 = "SELECT count(*) AS SA_count FROM res_master rm WHERE DATE_FORMAT(RESDATE,'%Y')=".date('Y')." AND AID=3";
		$SAwise_count3 = db_one($SAwise_count_query3);	
		
		$SAwise_count_query4 = "SELECT count(*) AS SA_count FROM res_master rm WHERE DATE_FORMAT(RESDATE,'%Y')=".date('Y')." AND AID=4";
		$SAwise_count4 = db_one($SAwise_count_query4);	
	/*for($i=1;$i<=4;$i++){
		
		$categorywise_array [] = $Categorywise_count;
		//$final_array = array_push($categorywise_array,$Categorywise_count);
		//print_r($categorywise_array);
	*/
	//$complete_data = array ($categorywise_array[0]['cat_count'],$categorywise_array(1)['cat_count'],$categorywise_array[2]['cat_count'],$categorywise_array[3]['cat_count']);
	//print_r($final_array)
	//[65, 59, 80, 81, 56, 55, 40, 32, 81, 65, 40, 12]
?>
//-------------
    //- BAR CHART -
    //-------------
	 var areaChartData = {
      labels: ["Principal", "GC-Chairman", "GC", "BOM"],
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php  echo $SAwise_count1['SA_count'].','.$SAwise_count2['SA_count'].','.$SAwise_count3['SA_count'].','.$SAwise_count4['SA_count'];?>]
        }
      ]
    };
	
	
    var barChartCanvas = $("#barChart2").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[0].fillColor = "#9B00FF";
    barChartData.datasets[0].strokeColor = "#9B00FF";
    barChartData.datasets[0].pointColor = "#9B00FF";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);