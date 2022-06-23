<?php 
	//number of data lines:
	$num_of_rows = 18;
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Departure Board</title>
		<link rel="stylesheet" href="css.css">
		<script src="jq.js"></script>
		<script src="js.js"></script>
		<script src="https://kit.fontawesome.com/dd348bbd0a.js" crossorigin="anonymous"></script>
		<link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet">
	</head>
	<body>
		<input type="hidden" id="num_of_rows" value="<?php echo $num_of_rows;?>">
		<input type="hidden" id="utc_offset" value="0">
		<table width="100%" class="arrivals_table">
			<tr>
				<td><h1><i class="fas fa-plane-arrival"></i>Arrivals</h1></td>
				<td><center><h1>Local time: <span class="local_time">12:30</span> | <span class="apt_name">Hong Kong</span> time: <span class="apt_time">12:30</span></h1></center></td>
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
				<td><h1><i class="fas fa-plane-departure"></i>Departures</h1></td>
				<td><center><h1>Local time: <span class="local_time">12:30</span> | <span class="apt_name">Hong Kong</span> time: <span class="apt_time">12:30</span></h1></center></td>
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
		<center><P></P>
			<?php
				//Read the settings file to see which airport is selected
				$settings_file = fopen("settings", "r") or die("Unable to open settings file!");
				$contents = fread($settings_file,filesize("settings"));
				fclose($settings_file);
				echo '<span class="normal_font">'.$contents.' - </span>';
			?>
			<a href="settings.php">Settings</a>
		</center>
	</body>
</html>

