<?php

class SummaryDetails
{
    public $DeltaActive = 1226;
    public $DeltaConfirmed = 1677;
	public $DeltaDeath = 1286;
    public $DeltaRecovered = 168;

    public $Active = 126;
    public $Confirmed = 16;
	public $Death = 126;
    public $Recovered = 16;
	public $Date = "2020-05-17";
    
    private $state = "Maharashtra";
    private $dict =  "Satara";
    
    public function __construct($st,$dct)
    {
        $this->state = $st;
        $this->dict = $dct;
    }

    public function init($da,$dc,$dd,$dr,$act,$con,$det,$rec,$dt)
    {
        $this->DeltaActive = $da;
        $this->DeltaConfirmed = $dc;
		$this->DeltaDeath = $dd;
        $this->DeltaRecovered = $dr;
        $this->Active = $act;
        $this->Confirmed = $con;
		$this->Death = $det;
		$this->Recovered = $rec;
		$this->Date = $dt;
    }
    
    public function papulate()
    {
        $url = "https://api.covid19india.org/state_district_wise.json"; 
        // Initialize a CURL session. 
        $ch = curl_init();  
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
         
        curl_setopt($ch, CURLOPT_URL, $url); 
        
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        
        $jsonResult = json_decode($result,true);
        $patientSummary = $jsonResult[$this->state]["districtData"][$this->dict];
        
        $active = $patientSummary["active"];
        $confirmed = $patientSummary["confirmed"];
        $deceased = $patientSummary["deceased"];
        $recovered = $patientSummary["recovered"];
        
        $date = "2020-05-17";
        $deltaConfirmed = $patientSummary["delta"]["confirmed"];
        $deltaDeceased= $patientSummary["delta"]["deceased"];
        $deltaRecovered = $patientSummary["delta"]["recovered"];
          
        $this->init(0,$deltaConfirmed,$deltaDeceased,$deltaRecovered,$active,$confirmed,$deceased, $recovered,$date);
         
        return $this;
    }
}

?>