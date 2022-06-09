<?php
	//this is for the pie chart for displaying the total requests of equipment bookings
    header("Content-type: text/javascript");
	//include_once('get_dept_overall_stat.php');
		include('../required/db_connection.php');
		include('../required/tables.php');
		require('../required/functions.php');
	
	$monthwise_array = array();
	
	for($i=1;$i<=12;$i++){
		$Monthwise_count_query = "SELECT count(*) AS month_count FROM res_master rm WHERE DATE_FORMAT(RESDATE,'%Y')=".date('Y')." AND DATE_FORMAT(RESDATE,'%m')=".$i;
		$Monthwise_count = db_one($Monthwise_count_query);	
		$final_array [] = $Monthwise_count;//array_push($monthwise_array,$Monthwise_count);
	}
	//print_r($final_array);
	$complete_data= $final_array[0]['month_count'].','.$final_array[1]['month_count'].','.$final_array[2]['month_count'].','.$final_array[3]['month_count'].','.$final_array[4]['month_count'].','.$final_array[5]['month_count'].','.$final_array[6]['month_count'].','.$final_array[7]['month_count'].','.$final_array[8]['month_count'].','.$final_array[9]['month_count'].','.$final_array[10]['month_count'].','.$final_array[11]['month_count'];
	//print_r($complete_data)
	//[65, 59, 80, 81, 56, 55, 40, 32, 81, 65, 40, 12]
?>
//-------------
    //- BAR CHART -
    //-------------
	 var areaChartData = {
      labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $complete_data;?>]
        }
      ]
    };
	
	
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[0].fillColor = "#00a65a";
    barChartData.datasets[0].strokeColor = "#00a65a";
    barChartData.datasets[0].pointColor = "#00a65a";
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