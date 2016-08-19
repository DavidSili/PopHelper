<?php 
session_start();
include 'config.php';

if (isset($_GET["url"])) $url=$_GET["url"];
else $url="index.php";

if (isset($_GET['login'])) {

include 'config.php';

	$usersent=$_POST['username'];
	$passsent=$_POST['password'];
	$pass_url=$_POST['pass_url'];
	$usersent=stripslashes($usersent);
	$passsent=stripslashes($passsent);
	$pass_url=stripslashes($pass_url);
	$usersent=$mysqli->real_escape_string($usersent);
	$passsent=$mysqli->real_escape_string($passsent);
	$pass_url=$mysqli->real_escape_string($pass_url);
	if ($usersent=='DavidSili' AND $passsent=='somepassword') {
	
		$_SESSION['loggedin'] = 1;
		$_SESSION['user'] = $usersent;
		header("Location: $pass_url");
		exit;
		
	}
	else echo 'Pogrešna šifra';

}
?>

<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="favicon.png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true"></head>
<title id="Timerhead">Prijava - Pophelper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<meta name="robots" content="noindex">
</head>
<body>
<h2>Prijava</h2>
<form name="form" method="post" action="?login=1">
<div style="text-align:center;width:100%;font-size:16">
	<p>korisničko ime:<br/>
	<input name="username" type="text" /><br/>
	šifra: <br/>
	<input name="password" type="password"/><br/>
	<input type="submit" value="Login" style="width:200px;height:80px" />
	<input type="hidden" name="pass_url" value="<?php echo $url; ?>"/></p>
</div>
</form>

</body>
</html>
