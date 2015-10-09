<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
echo $_GET['latitude'];
echo "<br/>";
$id = $_GET['id'];
echo $_GET['longitude'];echo "<br/>";
$country= $_GET['country'];echo "<br/>";
$state= $_GET['state'];echo "<br/>";
$city= $_GET['city'];echo "<br/>";
$area= $_GET['area'];echo "<br/>";
$road= $_GET['road'];echo "<br/>";
$abc = $_GET['abc'];
$pincode = $_GET['pincode'];
echo"done";	



$dbc = mysqli_connect('localhost','aaryan','nonepass','an_emergency_punjab_incident') OR die('error in connection');
$query ="UPDATE amritsar_record SET state='$state',city='$city',pincode='$pincode',location_street='$road',location_mohalla='$area',otherdetails='$abc' WHERE Amritsar_record_id='$id'";
$result = mysqli_query($dbc,$query) OR die('error insertion');
?>
<script>
function getLocationDetails()
{
	id="<?php echo $id?>";
	window.location.href = "content.php?id=" + id;
}
</script>

        
<?php
		echo '<script type="text/javascript">'
   , 'getLocationDetails();'
   , '</script>';
		
	
	
?>





<body>
</body>
</html>