<?php 
	//number of data lines:
	$num_of_rows = 18;
?>

<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<title>Departure Board</title>
		<link rel="stylesheet" href="assets/css.css">
		<script src="assets/jq.js"></script>
		<script src="assets/js.js"></script>
		<!-- START ICONS -->
		<link rel="icon" type="image/png" href="assets/favicons/favicon-96x96.png" sizes="96x96" />
		<link rel="icon" type="image/svg+xml" href="assets/favicons/favicon.svg" />
		<link rel="shortcut icon" href="assets/favicons/favicon.ico" />
		<link rel="apple-touch-icon" sizes="180x180" href="assets/favicons/apple-touch-icon.png" />
		<!-- END ICONS -->
		<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet">
	</head>
	<body>
		<input type="hidden" id="num_of_rows" value="<?php echo $num_of_rows;?>">
		<input type="hidden" id="utc_offset" value="0">
		<table width="100%" class="arrivals_table">
			<tr>
				<td>
					<h1 style="margin-right: 10px;"><i class="fas fa-plane-arrival"></i>Arrivals</h1>
				</td>
				<td>
					<div style="display: flex; align-items: center; width: 100%;">
						<h1 style="text-align: center; flex-grow: 1;">Local time: <span class="local_time">12:30</span> | <span class="apt_name">Hong Kong</span> time: <span class="apt_time">12:30</span></h1>
						<img src="assets/airlabs_logo.svg" style="width:100px; height:auto; margin-left: auto;">
					</div>
				</td>
			</tr>
		</table>
		<table width="100%" class="arrivals_table">
			<?php 
				for($i = 0; $i < $num_of_rows; $i++){
					echo '<tr><td>';
					echo '<div id="arrivals_'.$i.'"></div>'."\n";
					echo '</td></tr>';
				}
			?>
		</table>
		<table width="100%" class="departures_table">
			<tr>
				<td>
					<h1 style="margin-right: 10px;"><i class="fas fa-plane-departure"></i>Departures</h1>
				</td>
				<td>
					<div style="display: flex; align-items: center; width: 100%;">
						<h1 style="text-align: center; flex-grow: 1;">Local time: <span class="local_time">12:30</span> | <span class="apt_name">Hong Kong</span> time: <span class="apt_time">12:30</span></h1>
						<img src="assets/airlabs_logo.svg" style="width:100px; height:auto; margin-left: auto;">
					</div>
				</td>
			</tr>
		</table>
		<table width="100%" class="departures_table">
			<?php
				for($i = 0; $i < $num_of_rows; $i++){
					echo '<tr><td>';
					echo '<div id="departures_'.$i.'"></div>'."\n";
					echo '</td></tr>';
				}
			?>
			</tr>
		</table>
		<div style="height: 20px; text-align:center; width:100%;">
			<?php
				//Read the settings file to see which airport is selected
				$settings_file = fopen("settings", "r") or die("Unable to open settings file!");
				$contents = fread($settings_file,filesize("settings"));
				fclose($settings_file);
				echo '<span class="normal_font">'.$contents.' - </span>';
			?>
			<a href="settings.php">Settings</a>
		</div>
	</body>
</html>

