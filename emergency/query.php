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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
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

</style>
</head>
<?php
if(isset($_POST['submit'])){
	$lat= $_POST['latitude'];
	$lon = $_POST['longitude'];
	$output='0';
	$dbc = mysqli_connect('localhost','aaryan','nonepass','an_emergency_punjab_incident') OR die('connection error');
$query = "SELECT * FROM amritsar_record WHERE latitude=$lat AND longitude=$lon";
$result = mysqli_query($dbc,$query) OR die('error in executing command');
$i=0;
while($row= mysqli_fetch_array($result)) {
	if(!empty($row['city'])){
		
		$date=$row['date_time_incident'];
		$state =$row['state'];
		$city=$row['city'];
		$pin=$row['pincode'];
		$loc_street=$row['location_street'];
		$loc_area =$row['location_mohalla'];
		$other =$row['otherdetails'];
		if(!empty($row['type_incident'])){
		$type =$row['type_incident'];
		}else{
			$type="Restricted";
		}
		
		if(!empty($row['verified_status'])){
		$verfied =$row['verified_status'];
		}else{
			$verfied = "No";
		}
		$possible = $row['possible_reason'];
		$emergency_level = $row['emergency_level'];
		$autho =$row['authorities_required'];
		$victim_name=$row['victim_name'];
		$vitim_contact=$row['victim_contact'];
		$victim_vehicle=$row['victim_vehicle'];
		$culprit_vehicle=$row['culprit_vehicle'];
		$i =$i+1;
		
		?>
		<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false">
</script>

<script>
var myCenter=new google.maps.LatLng(<?php echo $lat?>,<?php echo $lon?>);

function initialize()
{
var mapProp = {
  center: myCenter,
  zoom:16,
  mapTypeId: google.maps.MapTypeId.ROADMAP
  };

var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
  position: myCenter,
  title:'Click to zoom'
  });

marker.setMap(map);

// Zoom to 9 when clicking on marker
google.maps.event.addListener(marker,'click',function() {
  map.setZoom(9);
  map.setCenter(marker.getPosition());
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<div style="position:absolute; left:50%; margin-left:-500px; width:1000px; height:100px; border-bottom:1px solid black;">
<a style="color:black;" href="index.php"><h1 style="position:absolute; left:20px; font-size:36px;">An Emergency</h1></a>
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

<a  href="#"><div id="usertab" class="login_class"><?php echo $emergency_username; ?></div></a>

<form method="post" action="index.php">

<input type="submit" id="logouttab" style="font:'Arial Black', Gadget, sans-serif; font-size:18px; font-weight:bolder; height:40px; padding-top:8px; padding-bottom:8px; width:150px; border-radius:7px; border:hidden; position:absolute; right:80px; top:50px;" name="logout_submit" value="Sign Out" />
</form>



<div id="lightboxlogout" class="lightbox"></div>

<script src="jquery/jquery-1.10.2.js"></script>
<script>
$(document).ready(function(){  
$("a#signout_lightbox_showpanel").click(function(){  
$("#lightboxlogout, #logout_div").fadeIn(300);  
})  
$("a.close-panel").click(function(){  
$("#lightboxlogout, #logout_div").fadeOut(300);  
})  
})

</script>









<?php
}
?>    
</div>
	
<div id="googleMap" style="width:1000px;height:600px; position:absolute; top:200px; left:50%; margin-left:-500px;" ></div>
<div style="position:absolute; width:1000px; top:830px; height:50px; left:50%;margin-left:-500px; border-top:1px solid black;">
</div>
<h1 style="position:absolute; top:830px; left:50%; margin-left:-500px;">Other Details:</h1>
<table style="position:absolute; top:900px; left:50%; margin-left:-500px;" width="1000" border="1">
  <tr>
    <td style="text-align:right; padding-right:20px;">Latitude</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $lat?></td>
    <td style="text-align:right; padding-right:20px;">Longitude</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $lon?></td>
  </tr>
  <tr>
    <td style="text-align:right; padding-right:20px;">State</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $state?></td>
    <td style="text-align:right; padding-right:20px;">City</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $city?></td>
  </tr>
  <tr>
    <td style="text-align:right; padding-right:20px;">Area</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $loc_area?></td>
    <td style="text-align:right; padding-right:20px;">Road / Street</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $loc_street?></td>
  </tr>
  <tr>
    <td style="text-align:right; padding-right:20px;">Other Details</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $other?></td>
    <td style="text-align:right; padding-right:20px;">Incident Type</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $type?></td>
  </tr>
  <tr>
    <td style="text-align:right; padding-right:20px;">Verified Status</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $verfied?></td>
    <td style="text-align:right; padding-right:20px;">Possible Reason</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $possible?></td>
  </tr>
  <tr>
    <td style="text-align:right; padding-right:20px;">Emergency Level</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $emergency_level?></td>
    <td style="text-align:right; padding-right:20px;">Authorities Required</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $autho?></td>
  </tr>
  <tr>
    <td style="text-align:right; padding-right:20px;">Victim Name</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $victim_name?></td>
    <td style="text-align:right; padding-right:20px;">Culprit Vehicle number</td>
    <td style="text-align:left; padding-left:10px;"><?php echo $victim_vehicle?></td>
  </tr>
  <tr>
  <td style="text-align:right; padding-right:20px;">Victim Contact</td>
  <td style="text-align:left; padding-left:10px;"><?php echo $vitim_contact?></td>
  <td style="text-align:right; padding-right:20px;">Culprit Vehicle number</td>
  <td style="text-align:left; padding-left:10px;"><?php echo $culprit_vehicle?></td>
  
</table>
<div style="position:absolute; top:1150px; height:20px; width:100px; ">
</div>

</body>
		
		
		
		
	<?php
	if($i>0){
			break;
		}
	}else{
		echo "testing";
		$lat=$row['latitude'];
		$lon=$row['longitude'];
		?>
		  <script>

function createCORSRequest(method, url) {
  var xhr = new XMLHttpRequest();

  if ("withCredentials" in xhr) {
    // XHR for Chrome/Firefox/Opera/Safari.
    xhr.open(method, url, true);

  } else if (typeof XDomainRequest != "undefined") {
    // XDomainRequest for IE.
    xhr = new XDomainRequest();
    xhr.open(method, url);

  } else {
    // CORS not supported.
    xhr = null;
  }
  return xhr;
}

function getLocationDetails()
{

latitude1="<?php echo $lat ?>";
longitude1="<?php echo $lon ?>";
id = "<?php echo $test?>";

var url="http://maps.googleapis.com/maps/api/geocode/json?latlng="+
        latitude1+","+longitude1+"&sensor=true";
    var xhr = createCORSRequest('POST', url);
           if (!xhr) {
             alert('CORS not supported');
           }
         
           xhr.onload = function() {
        
            var data =JSON.parse(xhr.responseText);
            
            if(data.results.length>0)
            {
            
            var locationDetails=data.results[0].formatted_address;
            var  value=locationDetails.split(",");
            
            count=value.length;
            
             country=value[count-1];
             state=value[count-2];
             city=value[count-3];
			 area= value[count-4];
			 road = value[count-5];
			 abc = value[count-6];
             pin=state.split(" ");
             pinCode=pin[pin.length-1];
             state=state.replace(pinCode,' ');         
             
            }
			window.location.href = "final.php?latitude=" + latitude1 + "&longitude=" + longitude1 + "&country=" + country +"&pincode=" + pinCode + "&state=" + state +"&city=" + city + "&area=" + area +"&abc="+abc+ "&road=" +road + "&id=" +id ;

            
           };

           xhr.onerror = function() {
               alert('Woops, there was an error making the request.');
               
           };
        xhr.send();
        
		
}

</script>
        
        
<?php
		echo '<script type="text/javascript">'
   , 'getLocationDetails();'
   , '</script>';
		
	}
	
}

}

?>


</html>