<?php

class DistrictDetails
{
    private $lat;
    private $lon;
    public function __construct($st,$dct)
    {
        $this->lat = $st;
        $this->lon = $dct;
    }

    public function init($act,$con,$det,$rec)
    {
        $this->Active = $act;
        $this->Confirmed = $con;
		$this->Death = $det;
		$this->Recovered = $rec;
    }
    
    public function papulate()
    {
         $urlLoc = "https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=$this->lat&longitude=$this->lon&localityLanguage=en";

        // Initialize a CURL session. 
        $ch = curl_init();  

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        curl_setopt($ch, CURLOPT_URL, $urlLoc); 

        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        $jsonResult = json_decode($result,true);
        $st = $jsonResult["principalSubdivision"];
        
       //$st="Karnataka";
        
        $url = "https://api.covid19india.org/state_district_wise.json"; 
        // Initialize a CURL session. 
        $ch = curl_init();  
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
         
        curl_setopt($ch, CURLOPT_URL, $url); 
        
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        
        $jsonResult = json_decode($result,true);
        $dictSummary = $jsonResult[$st]["districtData"];
         
        return $dictSummary;
    }
}

?>