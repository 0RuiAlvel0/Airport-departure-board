<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Set airport</title>
		<link rel="stylesheet" href="assets/css.css">
		<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet">
	</head>

<body style="text-align:center;">

	<h1>Choose an Airport</h1>

	<?php
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		
		// Read current settings to pre-populate the form
		$current_num_of_rows = 18;
		if(file_exists("settings")){
			$settings_file = fopen("settings", "r");
			$contents = fread($settings_file, filesize("settings"));
			fclose($settings_file);
			$settings_data = explode("\t", $contents);
			if(count($settings_data) >= 6 && is_numeric(trim($settings_data[5]))){
				$current_num_of_rows = intval(trim($settings_data[5]));
			}
		}
		
		if(array_key_exists('icao', $_POST)) {
            $icao = htmlspecialchars($_POST['icao']);
			$num_of_rows = isset($_POST['num_of_rows']) ? intval($_POST['num_of_rows']) : 18;
			echo "<font color=white>Airport to find : ".$icao."<br/>";
			$airport_file = fopen("assets/aptlist", "r") or die("Unable to open airport file!");
			$found = false;
			while ((!feof($airport_file)) and (!$found)) {
				$line = fgets($airport_file);
				$aux = explode("\t", $line);
				$found = ($aux[0] == $icao);
			}
			fclose($airport_file);
			if (!$found) 
				echo "Unknown airport !";
			else {
				echo "Airport found !";
				unlink('settings');
				$settings = fopen("settings", "w");
				// Append num_of_rows to the settings line
				$line = rtrim($line) . "\t" . $num_of_rows;
				fwrite($settings, $line);
				fclose($settings);
				header("Location: base.php");
			}
		}
	?>

	<form method="post">
		<select id="airport" onChange="update()">
			<option value="LFRB">Brest Bretagne</option>
            <option value="VHHH">Hong Kong International Airport</option>
			<option value="VTSG">Krabi International Airport</option>
			<option value="LFLL">Lyon Saint-Exupery</option>
			<option value="VMMC">Macau International Airport</option>
            <option value="LFRS">Nantes Atlantique</option>
            <option value="KJFK">New York JFK</option> 
            <option value="LFPG">Paris-Charles de Gaulle</option>
            <option value="LFPB">Paris-Le Bourget</option>
            <option value="LFPO">Paris-Orly</option>
			<option value="WMKP">Penang International Airport</option>
    	</select>
		<br><br>
		<label for="num_of_rows" style="color:white;">Number of rows to display:</label>
		<input type="number" id="num_of_rows" name="num_of_rows" value="<?php echo $current_num_of_rows; ?>" min="1" max="50" style="width: 60px;">
        <input type="hidden" name="icao" id="value">
		<br><br>
		<button> Save </button> <input type="button" onclick="location.href='base.php';" value=" Cancel " />
	</form>

        <script type="text/javascript">
		function update() {
			var select = document.getElementById('airport');
			var option = select.options[select.selectedIndex];
                        document.getElementById('value').value = option.value;
                }
                update();
        </script>

</body>

</html>
