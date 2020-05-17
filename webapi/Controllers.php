<?php

class Covid19Controller {
   
    private $requestMethod;
    private $state;
    private $dict;
    private $act;
    
    public function __construct($requestMethod,$state,$dict,$action)
    {
        $this->requestMethod = $requestMethod;
        $this->state = $state;
        $this->dict = $dict;
        $this->act = $action;
    }
    
    public function processRequest()
    {
        switch ($this->act) {
            case 'Patient': 
                    $response = $this->getPatientSummaryData();
                break;
            case 'Test': 
                    $response = $this->getTestSummaryData();
                break;
            case 'Location': 
                    $response = $this->getLocationSummaryData();
                break;
           default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    
    private function getPatientSummaryData()
    {
        $sumDetails = new SummaryDetails($this->state, $this->dict);
        
        $result = $sumDetails->papulate();
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    
    private function getTestSummaryData()
    {
        $testDetails = new TestDetails($this->state, $this->dict);
        
        $result = $testDetails->papulate();
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getLocationSummaryData()
    {
        $locationDetails = new LocationDetails($this->state, $this->dict);
        
        $result = $locationDetails->papulate();
        
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
   
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
?>