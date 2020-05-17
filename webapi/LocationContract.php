<?php

class LocationDetails
{   
    public $state =  "MH";
    public $dictrict =  "Satara";
    
    private $lat = "0";
    private $lon =  "0";
    
    public function __construct($la,$lo)
    {
        $this->lat = $la;
        $this->lon = $lo;
    }

    public function init($sta,$dic)
    { 
        $this->state = $sta;
        $this->dictrict = $dic;
    }
    
    public function papulate()
    {
        $urlLoc = "https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=18.7514798&longitude=73.7138884&localityLanguage=en";

        // Initialize a CURL session. 
        $ch = curl_init();  
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
         
        curl_setopt($ch, CURLOPT_URL, $urlLoc); 
        
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        
        $jsonResult = json_decode($result,true);
        $st = $jsonResult["principalSubdivision"];  
        $dct = $jsonResult["locality"];  
        
        $this->init($st,$dct);
         
        return $this;
    }
}

?>