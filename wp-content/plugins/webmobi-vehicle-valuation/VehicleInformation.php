<?php
/*
    Author: Mufassir Islam <mufasseri@gmail.com>
    Contact: +92 (323) 406 2533
    Description: this page handle all api call from ukvehicledata.co.uk
 */
 
// Set API Key
// define('API_KEY', "90c2f03d-481c-4f6b-96e1-561413703732");
define('API_KEY', "e387636a-8360-48fd-9d47-fde0e75fd40d");
// Set BASE API URL
define('BASE_URL', "https://uk1.ukvehicledata.co.uk/api/datapackage/");
define('BASE_URL_V2', "https://uk.api.vehicledataglobal.com/r2/lookup?packagename=");

class VehicleInformation {

  function __construct(){
  }

  // Battery Data Created
  // https://uk1.ukvehicledata.co.uk/api/datapackage/BatteryData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function batteryDataCreated($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("BatteryDataCreated", $param);
    return $response;

  }

  // Fuel Price Data Created
  // https://uk1.ukvehicledata.co.uk/api/datapackage/FuelPriceData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_POSTCODE=BS12AN
  function fuelPriceDataCreated($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("FuelPriceDataCreated", $param);
    return $response;

  }

  // Mot History And Tax Status Data
  // https://uk1.ukvehicledata.co.uk/api/datapackage/MotHistoryAndTaxStatusData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function motHistoryAndTaxStatusData($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("MotHistoryAndTaxStatusData", $param);
    return $response;

  }

  // Mot History Data
  // https://uk1.ukvehicledata.co.uk/api/datapackage/MotHistoryData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function MotHistoryData($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("MotHistoryData", $param);
    return $response;

  }

  // Postcode Lookup
  // https://uk1.ukvehicledata.co.uk/api/datapackage/PostcodeLookup?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_POSTCODE=BS12AN
  function postcodeLookup($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("PostcodeLookup", $param);
    return $response;

  }

  // Spec And Options Data
  // https://uk1.ukvehicledata.co.uk/api/datapackage/SpecAndOptionsData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function specAndOptionsData($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("SpecAndOptionsData", $param);
    return $response;

  }

  // Tyre Data
  // https://uk1.ukvehicledata.co.uk/api/datapackage/TyreData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function tyreData($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("TyreData", $param);
    return $response;

  }

  // Valuation Can Price
  // https://uk1.ukvehicledata.co.uk/api/datapackage/ValuationCanPrice?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function valuationCanPrice($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("ValuationCanPrice", $param);
    return $response;

  }

 

  // Vdi Check Full
  // https://uk1.ukvehicledata.co.uk/api/datapackage/VdiCheckFull?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function vdiCheckFull($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("VdiCheckFull", $param);
    return $response;

  }

  // Vehicle And Mot History
  // https://uk1.ukvehicledata.co.uk/api/datapackage/VehicleAndMotHistory?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function vehicleAndMotHistory($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("VehicleAndMotHistory", $param);
    return $response;

  }

  // Vehicle Data Created
  // V1: https://uk1.ukvehicledata.co.uk/api/datapackage/VehicleData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  // V2: https://legacy.api.vehicledataglobal.com/api/datapackage/VehicleData?v=2&auth_apikey=90C2F03D-481C-4F6B-96E1-561413703732&key_vrm=RO22AHE
  function vehicleData($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCallForVehicleInfoData("VehicleData", $param);
    // $response = $this->doCURLCall("VehicleData", $param);
    return $response;

  }

  // Vehicle Image Data Created
  // https://uk1.ukvehicledata.co.uk/api/datapackage/VehicleImageData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function vehicleImageData($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("VehicleImageData", $param);
    // echo "Response<br>";
    // print_r($response);
    return $response;

  }

  // Vehicle Tax Data
  // https://uk1.ukvehicledata.co.uk/api/datapackage/VehicleTaxData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function vehicleTaxData($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("VehicleTaxData", $param);
    return $response;

  }


  // Vehicle Data IRL
  // https://uk1.ukvehicledata.co.uk/api/datapackage/VehicleDataIRL?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK
  function vehicleDataIRL($vehicleNumber){

    $param = [
      'key_VRM' => $vehicleNumber
    ];
    $response = $this->doCURLCall("VehicleDataIRL", $param);
    return $response;

  }

   // Valuation Can Price
  // https://uk1.ukvehicledata.co.uk/api/datapackage/ValuationData?v=2&api_nullitems=1&auth_apikey=90c2f03d-481c-4f6b-96e1-561413703732&key_VRM=KM12AKK

  //https://uk.api.vehicledataglobal.com/r2/lookup?packagename=ValuationDetailsv2&apikey=E387636A-8360-48FD-9D47-FDE0E75FD40D&vrm={vrm}&mileage={mileage}
  function valuationData($vehicleNumber, $mileage){

    $param = [
      'key_VRM' => $vehicleNumber,
      'mileage' => $mileage
    ];
    // echo "<pre>";
    // print_r($param);
    // echo "</pre>";
    // exit;

    // $response = $this->doCURLCall("ValuationData", $param);
    $response = $this->doCURLCallV2("ValuationDetailsv2", $param);
    
    // $response = $this->doCURLCallV2("ValuationData", $param);
    
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    // exit;
    
    return $response;

  }


  // do all api calls
  function doCURLCall($endpoint, $data=[], $url=''){
    // Init cURL session
    $curl = curl_init();
    
    $params = [];
    $params['v'] = 2;
    $params['auth_apikey'] = API_KEY;
    $params['key_VRM'] = $data['key_VRM'];
    $params['api_nullitems'] = $data['api_nullitems']?$data['api_nullitems']:1;
    $url = BASE_URL.$endpoint.'?'.http_build_query($params); 

    // Create array of options for the cURL session
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));

    // Execute cURL session and store the response in $response
    $response = curl_exec($curl);
    
    // If the operation failed, store the error message in $error
    $error = curl_error($curl);
    
    // Close cURL session
    curl_close($curl);
    
    // If there was an error, print it to screen. Otherwise, unserialize response and print to screen.
    if ($error) {
      return ["code"=>400, "status"=>false, "message" => "cURL Error: " . $error, "response"=>[]];
    } else {
      return ["code"=>200, "status"=>true, "message" => "cURL Success" . $error, "response"=>json_decode($response)]; 
      // For demonstration purposes - Unserialize response & dump array contents to screen
    }

  }



  // do all api calls
  function doCURLCallV2($endpoint="ValuationDetailsv2", $data=[], $url=''){
    
    // Init cURL session
    $curl = curl_init();
    
    $params = [];
    $params['v'] = 2;
    $params['apikey'] = API_KEY;
    $params['vrm'] = $data['key_VRM'];
    $params['mileage'] = $data['mileage'];
    // $params['v'] = 2;
    // $params['api_nullitems'] = $data['api_nullitems']?$data['api_nullitems']:1;
    $url = BASE_URL_V2.$endpoint.'&'.http_build_query($params); 
    //echo $url; exit;

    // echo "<pre>";
    // print_r($params);
    // echo "</pre>";
    // exit;

    // Create array of options for the cURL session
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));

    // Execute cURL session and store the response in $response
    $response = curl_exec($curl);
    
    // If the operation failed, store the error message in $error
    $error = curl_error($curl);
    
    // Close cURL session
    curl_close($curl);
    
    // If there was an error, print it to screen. Otherwise, unserialize response and print to screen.
    if ($error) {
      return ["code"=>400, "status"=>false, "message" => "cURL Error: " . $error, "response"=>[]];
    } else {
      return ["code"=>200, "status"=>true, "message" => "cURL Success" . $error, "response"=>json_decode($response)]; 
      // For demonstration purposes - Unserialize response & dump array contents to screen
    }

  }



  // do all api calls
  function doCURLCallForVehicleInfoData($endpoint="VehicleData", $data=[], $url=''){
    // Init cURL session
    $curl = curl_init();
    
    $params = [];
    $params['v'] = 2;
    $params['apikey'] = API_KEY;
    $params['vrm'] = $data['key_VRM'];

    // $params['v'] = 2;
    // $params['api_nullitems'] = $data['api_nullitems']?$data['api_nullitems']:1;
    $url = BASE_URL_V2.$endpoint.'&'.http_build_query($params); 

    // echo "<pre>";
    // print_r($params);
    // echo "</pre>";
    // exit;

    // Create array of options for the cURL session
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));

    // Execute cURL session and store the response in $response
    $response = curl_exec($curl);
    
    // If the operation failed, store the error message in $error
    $error = curl_error($curl);
    
    // Close cURL session
    curl_close($curl);
    
    // If there was an error, print it to screen. Otherwise, unserialize response and print to screen.
    if ($error) {
      return ["code"=>400, "status"=>false, "message" => "cURL Error: " . $error, "response"=>[]];
    } else {
      return ["code"=>200, "status"=>true, "message" => "cURL Success" . $error, "response"=>json_decode($response)]; 
      // For demonstration purposes - Unserialize response & dump array contents to screen
    }

  }

}



?>