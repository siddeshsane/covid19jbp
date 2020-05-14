<html>
	<head>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/covid.css">
	<script src="scripts/script.js"></script>
	</head>
<body>
    
	 <?php
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
      
      $url = "https://pugmarks.tech/covid19jbp/apis/getPatientSummary.php?State=$state&District=$dict";
      //echo $url;
	 
        // Initialize a CURL session. 
        $ch = curl_init();  
          
        // Return Page contents. 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        //grab URL and pass it to the variable. 
        curl_setopt($ch, CURLOPT_URL, $url); 
        
        $result=curl_exec($ch);

        //curl_close ($ch);
        $idx = strlen($result)-15;
        $ff= substr($result,13,$idx);
        
        //echo $ff;
        
        $rr = json_decode($ff,true);
        
        $active = $rr["active"];
        $confirmed = $rr["confirmed"];
        $deceased = $rr["deceased"];
        $recovered = $rr["recovered"];
       
       $st = urldecode($state);
   

	  echo " <div class='navbar2'>      Covid19 [$dict] $st <br/><br/>
	    <span class='maker'>developed by Siddesh Sane</span></div>
    	<div>
    	<div class='Level'>
		<div class='level-item is-cherry fadeInUp' style='animation-delay: 1s;'>
		<h5>Confirmed</h5><h4>[+0]</h4><h1>$confirmed</h1></div>
		<div class='level-item is-blue fadeInUp' style='animation-delay: 1.1s;'>
		<h5 class='heading'>Active</h5><h4>[+0]</h4><h1 class='title has-text-info'>$active</h1></div>
		<div class='level-item is-green fadeInUp' style='animation-delay: 1.2s;'>
		<h5 class='heading'>Recovered</h5><h4>[+0]</h4><h1 class='title has-text-success'>$recovered</h1></div>
		<div class='level-item is-gray fadeInUp' style='animation-delay: 1.3s;'>
		<h5 class='heading'>Deceased</h5><h4>[+0]</h4><h1 class='title has-text-grey'>$deceased</h1></div>
		</div>";
		
		?>
	
	</div>

</body>
</html>