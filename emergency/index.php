<?php session_start()?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php

if(isset($_POST['logout_submit'])) {
	if(isset($_COOKIE['xusername'])){
		setcookie('xusername','',time()-(60*60*24));
	}
	if(isset($_SESSION['xusername'])){
		$_SESSION= array();
		session_destroy();
	}
	echo "Logout successfully done";
	echo "Please <a href='index.php'>Continue</a>";
	exit();
}

?>
<head>
<style>
a{
	text-decoration:none;
	color:black;
}
tr,td,th{
	padding:3px 2px;
	min-width:100px;
	
}
th{
	background-color:#CCC;
}
#signup_but {
	color:black;
	border:1px solid black;
	position:absolute;
	right:100px;
	bottom:10px;
	width:auto;
	padding-left:20px;
	padding-right:20px;
	height:auto;
	border-radius:7px;
	background-color:#CCC;
	font:'Arial Black', Gadget, sans-serif; font-size:18px; font-weight:bolder;
	
	
}
#login_but,#usertab{
position:absolute;
	color:black;
	border:1px solid black;
	right:250px;
	bottom:10px;
	width:auto;
	padding-left:20px;
	padding-right:20px;
	height:auto;
	border-radius:7px;
	font:'Arial Black', Gadget, sans-serif; font-size:18px; font-weight:bolder;
}
.login_class {
	border:1px solid black;
	text-align:center;
	padding-bottom:10px;
	padding-top:10px;
}	
.glowing-border {
    border: 2px solid #dadada;
    border-radius: 7px;
	font-size:18px;
	padding-left:10px;
}

.glowing-border:focus { 
    outline: none;
    border-color: #9ecaed;
    box-shadow: 0 0 10px #9ecaed;
}

</style>
<?php

$cur_page=isset($_GET['page']) ? $_GET['page'] :1;
$dbc = mysqli_connect('localhost','aaryan','nonepass','an_emergency_punjab_incident') OR die('connection error');
$query = "SELECT * FROM amritsar_record ORDER BY Amritsar_record_id DESC";
$result = mysqli_query($dbc,$query) OR die('error in executing command');

$totalnoresults=mysqli_num_rows($result);
	
	
	
	$i=0;
	$state = array();
	$pi = array();
	$city = array();
	$road = array();
	$area = array();
	$lat  = array();
	$lon = array();
	$date = array();
	$vic_name = array();
	$vic_con = array();
	$vic_vehicle = array();
	$id = array();
	$other = array();
	
	
	$resultforpage= mysqli_query($dbc,$query) OR die('kuuu');
	
	while($row= mysqli_fetch_array($resultforpage)) {
		$state[$i]=$row['state'];
		$city[$i]=$row['city'];
		$pi[$i] = $row['pincode'];
		$other[$i]= $row['otherdetails'];
		$road[$i]=$row['location_street'];
		$area[$i]=$row['location_mohalla'];
		$lat[$i]=$row['latitude'];
		$lon[$i]=$row['longitude'];
		$date[$i]=$row['date_time_incident'];
		$vic_name[$i]=$row['victim_name'];
		$vic_con[$i]=$row['victim_contact'];
		$vic_vehicle[$i]=$row['victim_vehicle'];
		$id[$i] = $row['Amritsar_record_id'];
		$i=$i +'1';
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="text-align:center;">
<div style="position:absolute; left:50%; margin-left:-500px; width:1000px; height:100px; border-bottom:1px solid black;">
<h1 style="position:absolute; left:20px; font-size:36px;">An Emergency</h1>
<?php
if( !isset($_COOKIE['xusername'])) {
	if( !isset($_SESSION['xusername'])) {

?>
<a  href="login.php"><div id="login_but" class="login_class">Login</div></a>
<a  href="signup.php"><div id="signup_but" class="login_class">Sign Up</div></a>

</div>






<?php
	}}

if( (isset($_COOKIE['xusername']) || isset($_SESSION['xusername'])) ||(isset($_COOKIE['xusername']) && isset($_SESSION['xusername']))) {
if( isset($_COOKIE['xusername'])){
	$emergency_username = $_COOKIE['xusername'];
}else {
	$emergency_username = $_SESSION['xusername'];
}



	?>
<form style="position:absolute; top:120px;" action="query.php" method="post" >
<input class="glowing-border" name="latitude" class="latitude" id="latitude" placeholder="latitude" />
<input class="glowing-border" name="longitude" placeholder="longitude" />
<input style="width:100px; height:30px; border-radius:3px;" type="submit" name="submit" />

</form>



<a  href="#"><div id="usertab" class="login_class"><?php echo $emergency_username; ?></div></a>

<form method="post" action="index.php">

<input type="submit" id="logouttab" style="font:'Arial Black', Gadget, sans-serif; font-size:18px; font-weight:bolder; height:40px; padding-top:8px; padding-bottom:8px; width:150px; border-radius:7px; border:hidden; position:absolute; right:80px; top:50px;" name="logout_submit" value="Sign Out" />
</form>










<?php
}
?>    
    

	

<table style="position:relative; margin:auto; top:200px;" width="1000" border="1">
  
  <tr>
  	<th scope="col">S.No</th>
    <th scope="col">State</th>
    <th scope="col">City</th>
    <th scope="col">PinCode</th>
    <th scope="col">Road</th>
    <th scope="col">Area</th>
    <th scope="col">Other Details</th>
    <th scope="col">Latitude</th>
    <th scope="col">Longitude</th>
    <th scope="col">Date & Time</th>
    
  </tr>
  <?php
  for($j=0;$j<$totalnoresults;$j=$j+1){
	  
	  ?>
  <tr>
  	<td><?php echo $j+1?></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $state[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $city[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $pi[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $road[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $area[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $other[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $lat[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $lon[$j]?></a></td>
    <td><a href="content.php?id=<?php echo $id[$j];?>"><?php echo $date[$j]?></a></td>
    
  </tr>
  
  <?php
  }
  ?>
  
</table>

</body>
</html>