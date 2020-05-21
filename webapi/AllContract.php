<?php


class AllRequest
{
    public $key = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsSWRlbnRpdHkiOiJzY2hpbnNhbW15QGdtYWlsLmNvbSJ9.WKuS35NLd-YroyOhT0JUzdzRxZP-qTsnp-nKPt2Fu9k";
    public $latlngs = null;//array(array($this->la,$this->lo));

    public function __construct($la,$lo)
    {
       // $this->la = $la;
      //  $this->lo = $lo;
      
       $this->latlngs = array(array($la,$lo));
    }
}

class AllDetails
{
    private $lat = 18.7514798;
    private $lon =  73.7138884;
    
    public function __construct($st,$dct)
    {
        $this->lat = $st;
        $this->lon = $dct;
    }

    public function initPaitent($da,$dc,$dd,$dr,$act,$con,$det,$rec,$dt)
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
      
        $this->State=$st;
     
        $url2 = 'https://data.geoiq.io/dataapis/v1.0/covid/locationcheck';
        $obj = new AllRequest($this->lat,$this->lon);
        $postObj = json_encode($obj);
         
        $ch2=curl_init($url2);
        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $postObj);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    
        $result2 = curl_exec($ch2);
        curl_close($ch2);
        
        $jsonResult2 = json_decode($result2,true);
        
        $this->District = $jsonResult2["data"][0]["district"];
         
        $this->papulatePatient();
        $this->papulateTest();

        return $this;
    }
    
    public function papulatePatient()
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
        $patientSummary = $jsonResult[$this->State]["districtData"][$this->District];
        
        $active = $patientSummary["active"];
        $confirmed = $patientSummary["confirmed"];
        $deceased = $patientSummary["deceased"];
        $recovered = $patientSummary["recovered"];
        
        $date = "2020-05-17";
        $deltaConfirmed = $patientSummary["delta"]["confirmed"];
        $deltaDeceased= $patientSummary["delta"]["deceased"];
        $deltaRecovered = $patientSummary["delta"]["recovered"];
          
        $this->initPaitent(0,$deltaConfirmed,$deltaDeceased,$deltaRecovered,$active,$confirmed,$deceased, $recovered,$date);
         
        //return $this;
    }

    public function initTest($tt,$iq,$ii,$ov,$pv,$nv,$dt)
    {
        $this->TotalTests = $tt;
        $this->InQuarantine = $iq;
		$this->InICU = $ii;
		$this->OnVentilator = $ov;
		$this->Positive = $pv;
		$this->Negative = $nv;
		$this->Date = $dt;       
    }
    
    public function papulateTest()
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
                return $k=="state" && $v == $this->State;
            }, ARRAY_FILTER_USE_BOTH));
            
            if($tempArray && $jsonResult["states_tested_data"][$i]["totaltested"])
                $resultArray = $jsonResult["states_tested_data"][$i];
        }
        
       
        $tt = $resultArray["totaltested"];
        $pv = $resultArray["positive"];
        $nv = $resultArray["negitive"];
        if(!$nv && $tt && $pv)
            {
                $nv = (string)((int)$tt - (int)$pv);
            }
        $date = $resultArray["updatedon"];        
        
        $this->initTest($tt,0,0,0,$pv,$nv,$date);
         
       // return $this;
    }
}

?>