<?php
	//Get request posted data - at this moment only the number of data rows we have to send out:
	//Currently this is defined at the top of base.php
	$num_of_rows = $_POST['num_of_rows'];
	
	//Provides connection to the API that delivers airport arrival and departure times
	//API related settings:
	$api_key = "ENTER_YOUR_KEY_HERE";
	$api_base = "https://airlabs.co/api/v9/";
	
	//read the settings file and get the selected ICAO airport 4 letter code
	$settings_file = fopen("settings", "r") or die("Unable to open settings file!");
	$contents = fread($settings_file,filesize("settings"));
	$apt_code = explode(' ', $contents);
	$icao_code = trim($apt_code[0]);
	fclose($settings_file);
	
	//Make the API request for arrivals
	$params = array();
	$params["arr_icao"] = $icao_code;
	$params["api_key"] = $api_key;
	
	$arrivals_results = apiCall($api_base, 'schedules', $params);
	
	//Make the API request for departures
	$params = array();
	$params["dep_icao"] = $icao_code;
	$params["api_key"] = $api_key;
	
	$departures_results = apiCall($api_base, 'schedules', $params);

	//Send out arrival data formatted for the output
	//time, carrier logo, flight, origin, status
	$data['error'] = false;
	
	//The airport the user selected (this is displayed at the top):
	$data['airport'] = airport_name($icao_code, 0, 13);
	
	$data['utc_offset'] = 0;
	for($i = 0; $i < sizeof($arrivals_results["response"]); $i++){
		$aux = explode(" ", $arrivals_results["response"][$i]["arr_time"]);
		$data['arrivals'][$i]['arr_time'] = $aux[1];
		$data['arrivals'][$i]['carrier_logo'] = "https://airlabs.co/img/airline/s/".$arrivals_results["response"][$i]["airline_iata"].".png";
		$data['arrivals'][$i]['flight_iata'] = substr($arrivals_results["response"][$i]["flight_iata"], 0, 5);
		//Dep ICAO, for this we need to translate the code to the text of the airport:
		$data['arrivals'][$i]['origin'] = substr(airport_name($arrivals_results["response"][$i]["dep_icao"]), 0, 13);
		if(trim(strtoupper($arrivals_results["response"][$i]["status"])) != "ACTIVE")
			$data['arrivals'][$i]['status'] = $arrivals_results["response"][$i]["status"];
		else
			$data['arrivals'][$i]['status'] = "ESTIMATED";
		
		//Use the last item to assess the UTC offset to be used to display the local airport time
		$utc_time = $arrivals_results["response"][$i]["arr_time_utc"];
		$airport_time = $arrivals_results["response"][$i]["arr_time"];
			
		if($i >= $num_of_rows){
			break;
		}
	}
	
	//Use the last item to assess the UTC offset to be used to display the local airport time
	$aux1 = strtotime($utc_time);
	$aux2 = strtotime($airport_time);
	
	$data['utc_offset'] = ($aux2 - $aux1) / 3600;
	
	//Send out departure data formatted for the output
	//time, carrier logo, flight, destination, status
	$data['error'] = false;
	for($i = 0; $i < sizeof($departures_results["response"]); $i++){
		$aux = explode(" ", $departures_results["response"][$i]["dep_time"]);
		$data['departures'][$i]['dep_time'] = $aux[1];
		$data['departures'][$i]['carrier_logo'] = "https://airlabs.co/img/airline/s/".$departures_results["response"][$i]["airline_iata"].".png";
		$data['departures'][$i]['flight_iata'] = substr($departures_results["response"][$i]["flight_iata"], 0, 5);
		//Dep ICAO, for this we need to translate the code to the text of the airport:
		$data['departures'][$i]['destination'] = substr(airport_name($departures_results["response"][$i]["arr_icao"]), 0, 13);
		if(trim(strtoupper($departures_results["response"][$i]["status"])) != "ACTIVE")
			$data['departures'][$i]['status'] = $departures_results["response"][$i]["status"];
		else
			$data['departures'][$i]['status'] = "BRDING CLSED";
		if($i >= $num_of_rows)
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
		$lines = file("aptlist");
		foreach ($lines as $lineNumber => $line) {
			if (strpos($line, trim($icao_code)) !== false) {
				$airport_name = explode("\t", $line);
				$airport_name = trim($airport_name[3]);
			}
    		}
		return $airport_name;
	}
?>
