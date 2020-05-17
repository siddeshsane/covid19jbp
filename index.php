<html>
	<head>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/covid.css">
	<script src="scripts/aa.js"></script>
	</head>
<body onload="getLocation();">
     <Div id="loc" style="display:none;visibility:hidden">Getting your location...</Div>
     <input id="lat" type="hidden"></input>
     <input id="lon" type="hidden"></input>
	 <?php
	  require "utils/Helper.php";
	 
	  $state = urlencode($_GET['State']);
      $dict =  urlencode($_GET['District']);
      
      if($state && $dict)
      {
	    // do nothin
      }
      else
      {
        $state = "Madhya%20Pradesh";
	      $dict = "Jabalpur";
      }

    $st = urldecode($state);
    $helper = new Helper();

    $urlPatient = "https://pugmarks.tech/covid19jbp/webapi/?State=$state&District=$dict&Action=Patient";
       
    $get_data = $helper->callAPI('GET', $urlPatient, false);
    $response = json_decode($get_data, true);
    $errors = $response['response']['errors'];
       
    $active = $response["Active"];
    $confirmed = $response["Confirmed"];
    $deceased = $response["Death"];
    $recovered = $response["Recovered"];    
    $dactive = $response["DeltaActive"];
    $dconfirmed = $response["DeltaConfirmed"];
    $ddeceased = $response["DeltaDeath"];
    $drecovered = $response["DeltaRecovered"];

	  echo " <div class='navbar2'>      Covid19 [$dict] $st <br/><br/>
	   </div>
    	<div>
    	<div class='Level'>
      <div class='level-item is-cherry fadeInUp' style='animation-delay: 1s;'>
      <h5>Confirmed</h5><h4>[+$dconfirmed]</h4><h1>$confirmed</h1></div>
      <div class='level-item is-blue fadeInUp' style='animation-delay: 1.1s;'>
      <h5 class='heading'>Active</h5><h4>[+$dactive]</h4><h1 class='title has-text-info'>$active</h1></div>
      <div class='level-item is-green fadeInUp' style='animation-delay: 1.2s;'>
      <h5 class='heading'>Recovered</h5><h4>[+$drecovered]</h4><h1 class='title has-text-success'>$recovered</h1></div>
      <div class='level-item is-gray fadeInUp' style='animation-delay: 1.3s;'>
      <h5 class='heading'>Deceased</h5><h4>[+$ddeceased]</h4><h1 class='title has-text-grey'>$deceased</h1></div>
      </div>";

    $urlTest = "https://pugmarks.tech/covid19jbp/webapi/?State=$state&District=$dict&Action=Test";
       
    $get_data2 = $helper->callAPI('GET', $urlTest, false);
    $response2 = json_decode($get_data2, true);
    $errors2 = $response2['response']['errors'];
       
    $totalTest = $response2["TotalTests"];
    $positive = $response2["Positive"];
    $Negitive = $response2["Negitive"];
    $InQuarantine = $response2["InQuarantine"];
   
      echo "<br/><br/> <div class='navbar2'> $st Testing Summary <br/><br/>
	    </div>
    	<div>
    	<div class='Level'>
      <div class='level-item is-cherry fadeInUp' style='animation-delay: 1s;'>
      <h5>Total Tested</h5><h4>[+0]</h4><h1>$totalTest</h1></div>
      <div class='level-item is-blue fadeInUp' style='animation-delay: 1.1s;'>
      <h5 class='heading'>Positive</h5><h4>[+0]</h4><h1 class='title has-text-info'>$positive</h1></div>
      <div class='level-item is-green fadeInUp' style='animation-delay: 1.2s;'>
      <h5 class='heading'>Negative</h5><h4>[+0]</h4><h1 class='title has-text-success'>$Negitive</h1></div>
      <div class='level-item is-gray fadeInUp' style='animation-delay: 1.3s;'>
      <h5 class='heading'>In Quarantine</h5><h4>[+0]</h4><h1 class='title has-text-grey'>$InQuarantine</h1></div>
      </div>";
      
       echo "<br/><br/> <div class='footerbar2'>Developed by Siddesh Sane<br/>
	    <span class='maker'>SRC:covid19india.org</span></div>
    	<div>";

		
		?>
	
	</div>

</body>
</html>