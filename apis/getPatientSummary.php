<?php 
  
  $state = $_GET['State'];
  $dict =  $_GET['District'];
  
// From URL to get webpage contents. 
$url = "https://api.covid19india.org/state_district_wise.json"; 
  
// Initialize a CURL session. 
$ch = curl_init();  
  
// Return Page contents. 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
//curl_setopt($ch, CURLOPT_POSTFIELDS, 'state=Maharastra');
  
//grab URL and pass it to the variable. 
curl_setopt($ch, CURLOPT_URL, $url); 
 

$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
$jsonResult = json_decode($result,true);
  
 // var_dump($jsonResult["Maharashtra"]["Satara"]);
   $patientSummary = $jsonResult[$state]["districtData"][$dict];
   
    $active = $patientSummary["active"];
    $confirmed = $patientSummary["confirmed"];
    $deceased = $patientSummary["deceased"];
    $recovered = $patientSummary["recovered"];
    
    var_dump(json_encode($patientSummary));
    
    //echo $patientSummary;
  
?>