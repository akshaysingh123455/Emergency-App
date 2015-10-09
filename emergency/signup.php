<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
if(isset($_POST['submit'])){
	$dbc = mysqli_connect('localhost','aaryan','nonepass','an_emergency_punjab_incident') OR die('error connection');
	$name = $_POST['name'];
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = "SELECT userid FROM users WHERE username='$username'";
	$user_check_query_result = mysqli_query($dbc,$query) OR die('error checking');
	$user_check_rows = mysqli_num_rows($user_check_query_result);
	if($user_check_rows >0){
		echo "Username already exist";
		echo " Please <a href='#'>Try again</a> with some different username..<br>";
		echo " Login <a href='#'> Here</a>...<br>";
		echo " If you have forget your password <a href='#'>Click Here</a>";
		exit();
	}
	
	
	$querynew = "INSERT INTO users(username,name,password) VALUES('$username','$name',SHA('$password'))";
	$result = mysqli_query($dbc,$querynew) OR die('error creating user');
	
		echo " your account has been created please <a href='index.php'>Continue</a>";
		exit();
	
	
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
body{
	
	color:black;
	
	
}
input{
	background-color:white;
	width:300px;
	height:30px;
	margin:10px;
	border:2px solid black;
	
}
label{
	font-size:22px;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
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
</head>

<body>


<div class="main" id="main" style="position:relative;  border:1px solid black;
height:400px; margin:auto; width:700px;  top:200px; text-align:center;">
<h1 style="color:white; text-shadow:grey; font-family:'Palatino Linotype', 'Book Antiqua', Palatino, serif;">Sign up to Emergency</h1>

<table style="position:relative; margin:auto;"><tr><td>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<label for="name">Name</label></td><td>
<input class="glowing-border" name="name" /><br /></td></tr><tr><td>

<label for="username">Choose Username</label></td><td>
<input class="glowing-border" name="username" /></td></tr><tr><td>
<label for="password">Choose Password</label></td><td>
<input class="glowing-border" name="password" type="password" /></td></tr>
</table>
<input type="submit" style="font:'Arial Black', Gadget, sans-serif; font-size:18px; font-weight:bolder; height:40px; padding-top:8px; padding-bottom:8px; width:150px; border-radius:7px; border:1px solid black; position:absolute; left:280px; top:300px;" name="submit" value="Sign up" />
</form>




</div>
</body>
</html>