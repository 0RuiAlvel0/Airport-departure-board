<?php

	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);

	require_once __DIR__ . '/vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, null, true);
	$dotenv->load();

	//Get request posted data - at this moment only the number of data rows we have to send out:
	//Currently this is defined at the top of base.php
	$num_of_rows = $_POST['num_of_rows'];

	//Provides connection to the API that delivers airport arrival and departure times
	//API related settings:
	//$api_key = "YOUR-API_KEY-HERE";
	$api_key = $_ENV['api_key'];
	$api_base = "https://airlabs.co/api/v9/";

	//read the settings file and get the selected ICAO airport 4 letter code
	$settings_file = fopen("settings", "r") or die("Unable to open settings file!");
	$contents = fread($settings_file, filesize("settings"));
	$apt_code = explode("\t", $contents);
	$icao_code = trim($apt_code[0]);
	fclose($settings_file);

	//Make the API request for arrivals
	$params = array();
	$params["arr_icao"] = $icao_code;
	$params["api_key"] = $api_key;
	$params["limit"] = 20;
	$arrivals_results = apiCall($api_base, 'schedules', $params);

	//Make the API request for departures
	$params = array();
	$params["dep_icao"] = $icao_code;
	$params["api_key"] = $api_key;
	$params["limit"] = 20;
	$departures_results = apiCall($api_base, 'schedules', $params);

	//No error encountered so far
	$data['error'] = false;

	//The airport the user selected (this is displayed at the top):
	$data['airport'] = airport_name($icao_code, 0, 13);

	//Compute time difference (in hours) between UTC and airport local time
	$data['utc_offset'] = 0;

	if(sizeof($arrivals_results["response"]) > 0){
		$arr_time_utc = $arrivals_results["response"][0]["arr_time_utc"];
		$airport_arr_time = $arrivals_results["response"][0]["arr_time"];
		$aux1 = strtotime($arr_time_utc);
		$aux2 = strtotime($airport_arr_time);
		$data['utc_offset'] = ($aux2 - $aux1) / 3600;
	}

	//Compute airport local timestamp
	$gmt = gmdate("Y-m-d H:i");
	$utc = new DateTime($gmt);
	$utc_timestamp = $utc->getTimestamp();
	$now = $utc_timestamp + ($data['utc_offset'] * 60 * 60);

    //Send out arrival data formatted for the output
    //time, carrier logo, flight, origin, status
	$row = -1;
	$i = 0;
	while ($i < sizeof($arrivals_results["response"])){
		//$i++;
        // $earlier = new DateTime($arrivals_results["response"][$i]["arr_time"]);
        // $earlier = $earlier->getTimestamp();
		// $span = (int)(($now - $earlier) / 3600);
		// if ($span > 0){
		// 	continue;
        // }
		$row++;
		$aux = explode(" ", $arrivals_results["response"][$i]["arr_time"]);
		$data['arrivals'][$row]['arr_time'] = $aux[1];
		$data['arrivals'][$row]['carrier_logo'] = "https://airlabs.co/img/airline/s/".$arrivals_results["response"][$i]["airline_iata"].".png";
		$data['arrivals'][$row]['flight_iata'] = substr($arrivals_results["response"][$i]["flight_iata"], 0, 6);
		//Dep ICAO, for this we need to translate the code to the text of the airport:
		$data['arrivals'][$row]['origin'] = substr(airport_name($arrivals_results["response"][$i]["dep_iata"]), 0, 13);
		//$data['arrivals'][$row]['origin'] = 'TEST';

		// NOTE: override the below as status no longer available on free plans
		// if(trim(strtoupper($arrivals_results["response"][$i]["status"])) != "ACTIVE")
		// 	$data['arrivals'][$row]['status'] = $arrivals_results["response"][$i]["status"];
		// else{
		// 	$aux = explode(" ", $arrivals_results["response"][$i]["arr_estimated"]);
		// 	$data['arrivals'][$row]['status'] = "EST.".$aux[1];
		// }
		$data['arrivals'][$row]['status'] = "ON TIME";

		//Deal with code share flights. Show only the first flight in situations where the arrival time and the origin between the current flight and the previous.
		// if($row > 0){
		// 	if(!($data['arrivals'][$row]['arr_time'] == $data['arrivals'][$row-1]['arr_time'] && $data['arrivals'][$row]['origin'] == $data['arrivals'][$row-1]['origin']))
		// 		$i++;
        // }
		// else
		//	$i++;
		$i++;

		if($row >= $num_of_rows){
			break;
		}
    }

	//No error encountered so far
	$data['error'] = false;

	//Send out departure data formatted for the output
	//time, carrier logo, flight, destination, status
	$row = -1;
	for($i = 0; $i < sizeof($departures_results["response"]); $i++){
        // $earlier = new DateTime($departures_results["response"][$i]["dep_time"]);
        // $earlier = $earlier->getTimestamp();
        // $span = (int)(($now - $earlier) / 3600);
        // if ($span > 0) continue;
        $row++;
		$aux = explode(" ", $departures_results["response"][$i]["dep_time"]);
		$data['departures'][$row]['dep_time'] = $aux[1];
		$data['departures'][$row]['carrier_logo'] = "https://airlabs.co/img/airline/s/".$departures_results["response"][$i]["airline_iata"].".png";
		$data['departures'][$row]['flight_iata'] = substr($departures_results["response"][$i]["flight_iata"], 0, 6);
		//Dep ICAO, for this we need to translate the code to the text of the airport:
		$data['departures'][$row]['destination'] = substr(airport_name($departures_results["response"][$i]["arr_iata"]), 0, 13);

		// NOTE: override the below as status no longer available on free plans
		// $status = trim(strtoupper($departures_results["response"][$i]["status"]));		
		// if($status != "ACTIVE"){
		// 	if ($status == "SCHEDULED" and $departures_results["response"][$i]["dep_estimated"] != "") {
		// 		$aux = explode(" ", $departures_results["response"][$i]["dep_estimated"]);
		// 		$data['departures'][$row]['status'] = "SCHE.".$aux[1];
		// 	}
		// 	else
		// 		$data['departures'][$row]['status'] = $status;
		// }
		// else
		// 	$data['departures'][$row]['status'] = "EN ROUTE";
		$data['departures'][$row]['status'] = "EN ROUTE";

		if($row >= $num_of_rows)
			break;
	}

	echo json_encode($data);

	//Actually implements the API call
	function apiCall($api_base, $method, $params) {
		$c = curl_init(sprintf('%s%s?%s', $api_base, $method, http_build_query($params)));
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$res = json_decode(curl_exec($c), true);
		curl_close($c);
		return $res;
	}

	function airport_name($icao_code){
		$airport_name = '';
		$lines = file("assets/aptlist");
		foreach ($lines as $lineNumber => $line) {
			if (strpos($line, trim($icao_code)) !== false) {
				$airport_name = explode("\t", $line);
				$airport_name = trim($airport_name[3]);
			}
    		}
		return $airport_name;
	}
?>
