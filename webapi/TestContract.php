<?php

class TestDetails
{   
    public $TotalTests = 126;
    public $InQuarantine = 16;
    public $Positive = 126;
    public $Negitive = 16;
	public $InICU = 126;
    public $OnVentilator = 16;
	public $Date = "2020-05-14";
    
    private $state = "Maharashtra";
    private $dict =  "Satara";
    
    public function __construct($st,$dct)
    {
        $this->state = $st;
        $this->dict = $dct;
    }

    public function init($tt,$iq,$ii,$ov,$pv,$nv,$dt)
    {
        $this->TotalTests = $tt;
        $this->InQuarantine = $iq;
		$this->InICU = $ii;
		$this->OnVentilator = $ov;
		$this->Positive = $pv;
		$this->Negitive = $nv;
		$this->Date = $dt;       
    }
    
    public function papulate()
    {
        $url = "https://api.covid19india.org/state_test_data.json"; 
        // Initialize a CURL session. 
        $ch = curl_init();  
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
         
        curl_setopt($ch, CURLOPT_URL, $url); 
        
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        
        $jsonResult = json_decode($result,true);
        $testSummary = $jsonResult["states_tested_data"][0]["populationncp2019projection"];
        
        $resultArray = null;
        $cnt = count($jsonResult["states_tested_data"]);
        
        for($i=0;$i<$cnt;$i++)
        {
            $tempArray = (array_filter($jsonResult["states_tested_data"][$i], function($v, $k) {
                return $k=="state" && $v == $this->state;
            }, ARRAY_FILTER_USE_BOTH));
            
            if($tempArray)
                $resultArray = $jsonResult["states_tested_data"][$i];
        }
        
        //var_dump($resultArray);
       
        $tt = $resultArray["totaltested"];
        $pv = $resultArray["positive"];
        $nv = $resultArray["negitive"];
        if(!$nv && $tt && $pv)
            {
                $nv = (string)((int)$tt - (int)$pv);
            }
        $date = $resultArray["updatedon"];        
        
        $this->init($tt,0,0,0,$pv,$nv,$date);
         
        return $this;
    }
}

?>