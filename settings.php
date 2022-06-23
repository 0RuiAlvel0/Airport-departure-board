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
		<P></P>
		<P></P>
		<form>
			<span class="normal_font">Select airport:</span>
			<select name="aptcode">
				<?php //What is selected here is saved to the settings file. Note no extension.?>
				<option val="VHHH">Hong Kong International Airport</option>
				<option val="VTSG">Krabi International Airport</option>
				<option val="WMKP">Penang International Airport</option>
				<option val="VMMC">Macau International Airport</option>
			</select>
			
			<input type="button" action="submit" method="post" value=" Save "> <a href="base.php">Cancel</a>
		</form>
	</body>
</html>

