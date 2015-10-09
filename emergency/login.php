<?php session_start()?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
if(isset($_POST['submit'])){
	$dbc = mysqli_connect('localhost','aaryan','nonepass','an_emergency_punjab_incident') OR die('error connection');
	$username = $_POST['login_username'];
	$pass = $_POST['login_password'];
	$query ="SELECT userid FROM users WHERE username='$username' AND password=SHA('$pass')";
	$login = mysqli_query($dbc,$query) OR die('error checking');
	$login_rows = mysqli_num_rows($login);
	if($login_rows !=1) {
		echo "Sorry.. your username and password you entered may be correct";
		echo "<a href='#'>Try Again</a>";
		echo "If you don't have account please <a href='#'>create an account</a> first to login successfully";
		exit();
	}else {
		setcookie('xusername',$username,time()+(60*60*24*365));
		$_SESSION['xusername']=$username;
		mysqli_close($dbc);
	}
	echo " Login Successful..";
	echo " PLEASE <a href='index.php'>Continue</a>";
	exit();
	
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
body{
	
	
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
<h1 style="color:white; text-shadow:grey; font-family:'Palatino Linotype', 'Book Antiqua', Palatino, serif;">Login to Emergency</h1>

<table style="position:relative; margin:auto;"><tr><td>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<label for="login_username"> Username</label></td><td>
<input class="glowing-border" name="login_username" value="test" /><br /></td></tr><tr><td>
<label for="login_password">Password</label></td><td>
<input class="glowing-border" name="login_password" type="password" /></td></tr>
<tr><td></td><td><a style="text-decoration:none; color:white; position:absolute; right:20px;" href="#">Forgot Password?</a></td></tr></table>
<input type="submit" style="font:'Arial Black', Gadget, sans-serif; font-size:18px; font-weight:bolder; height:40px; padding-top:8px; padding-bottom:8px; width:150px; border-radius:7px; border:1px solid black; position:absolute; left:280px; top:240px;" name="submit" value="Login" />
</form>




</div>
</body>
</html>