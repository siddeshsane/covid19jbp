function getLocation() {
    // alert(1);
   if (navigator.geolocation) {
     //  alert(2);
     navigator.geolocation.getCurrentPosition(showPosition);
   } else { 
     x.innerHTML = "Geolocation is not supported by this browser.";
   }
 }
 
 function showPosition(position) {
 
   var latV = position.coords.latitude;
   var lonV = position.coords.longitude;
  
   callAPI(latV,lonV);
   callAPIDistrict(latV,lonV);
 }
 
 function callAPI(lat,lon)
 {
     var request = new XMLHttpRequest()
     request.open('GET', 'https://pugmarks.tech/Covid19Tracker/webapi/index.php?State='+lat+'&District='+lon+'&Action=All', true)
     request.onload = function() {
       // Begin accessing JSON data here
       var data = JSON.parse(this.response)
     
       if (request.status >= 200 && request.status < 400) {
       
           console.log(data);
           papulateAll(data);
        
       } else {
         console.log('error')
       }
     }
     
     request.send()
 }

 function papulateAll(result)
 {
    var state = result.State;
    var district = result.District;
    document.getElementById('titleMain').innerHTML = district+" ["+state+"]";
    document.getElementById('titleTest').innerHTML = "Testing Summary for "+ "["+state+"]";
	document.getElementById('titleDict').innerHTML = "District Wise Summary "+ "["+state+"]";
    
    document.getElementById('dactive').innerHTML = result.DeltaActive;
    document.getElementById('drecovered').innerHTML = result.DeltaRecovered;
    document.getElementById('ddeceased').innerHTML = result.DeltaDeath;
    document.getElementById('dconfirmed').innerHTML = result.DeltaConfirmed;

    document.getElementById('active').innerHTML = result.Active;
    document.getElementById('recovered').innerHTML = result.Recovered;
    document.getElementById('deceased').innerHTML = result.Death;
    document.getElementById('confirmed').innerHTML = result.Confirmed;

    document.getElementById('tested').innerHTML = result.TotalTests;
    document.getElementById('positive').innerHTML = result.Positive;
    document.getElementById('negative').innerHTML = result.Negative;
    document.getElementById('inq').innerHTML = checkzero(result.InQuarantine); 

 }
 
 function callAPIDistrict(lat,lon)
 {
     var request = new XMLHttpRequest()
 
     request.open('GET', 'https://pugmarks.tech/Covid19Tracker/webapi/index.php?State='+lat+'&District='+lon+'&Action=District', true)
     request.onload = function() {
       // Begin accessing JSON data here
       var data = JSON.parse(this.response)
     
       if (request.status >= 200 && request.status < 400) {
       
           //console.log(data.Akola);
		   
var tabelHead = "<table class='w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white'><tr style='color:gray;font-size:19px;'><td>District</td><td>Confirmed</td><td>Active</td><td>Recovered</td><td>Death</td></tr>";
          var tabelBody = "";
          var tablefooter = "</table>";
			   for (let [key, value] of Object.entries(data)) {			   
				   tabelBody = tabelBody + "<tr style='color:#fc8403;font-size:17px;'><td>"+key+"</td><td>"+value["confirmed"]+"</td><td>"+value["active"]+"</td><td>"+value["recovered"]+"</td><td>"+value["deceased"]+"</td></tr>";
				}
				document.getElementById('xyz').innerHTML = tabelHead+tabelBody+tablefooter;//papulateDistrict(data);
        
       } else {
         console.log('error')
       }
     }
     
     request.send()
 }
 
 function checkzero(value)
 {
	 if (value.length === 0 || value === 0)
      {  	
         return "NA"; 
      }  
	  return value;
 }