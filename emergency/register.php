<?php   
    
	$cul = $_POST['culprit_name'];
	$lat = $_POST['latitude'];
	$cul_no = $_POST['culprit_vehicle_number'];
	$lon = $_POST['longitude'];
	$victim = $_POST['victim_name'];
	$victim_contact = $_POST['victim_phone'];
	$victim_vechicle = $_POST['victim_vehicle_nuimber'];
	$dbc = mysqli_connect('localhost','root','fuckoff','an_emergency_punjab_incident')OR die('connection arror');
	$query = "INSERT INTO amritsar_record (date_time_incident,latitude,longitude,victim_name,victim_contact,victim_vehicle,culprit_vehicle,culprit_name) VALUES (now(),'$lat','$lon','$victim','$victim_contact','$victim_vechicle','$cul_no','$cul')";
	$FINAL = mysqli_query($dbc,$query) OR die('off');
	mysqli_close($dbc);
	$filename="a.html";
	file_put_contents($filename,$_POST['culprit_name']);
	
	
?>