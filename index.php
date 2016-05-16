<?php
	session_start();
	$uri=$_SERVER['REQUEST_URI'];
	$pos = strrpos($uri, "/");
	$url = substr($uri, $pos+1);
	if ($_SESSION['loggedin'] != 1) {
		header("Location: login.php?url=index.php");
		exit;
	}
	else {
	include 'config.php';
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
<title id="Timerhead">Pop helper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<style type="text/css">
a {
	width:100px;
	height:40px;
	text-align:center;
	padding:10px;
	margin:10px;
	display:block;
	color:#000;
	text-decoration:none;
	float:left;
}
.redovi {
	width:280px;
	height:80px;
	padding:0;
	margin:0 auto;
	
}
</style>
<meta name="robots" content="noindex">
</head>
<body>
<div class="redovi"><a style="background:#cdf;" href="uposeta.php">Unos poseta</a>
<a style="background:#cdf;" href="hpposeta.php">Hronološki pregled</a></div>
<div class="redovi"><a style="background:#cdf;" href="imenik.php">Sređivanje imenika</a>
<a style="background:#cdf;" href="podposeta.php">Podešavanja poseta</a></div>
<div class="redovi"><a style="background:#edc;" href="propovedanja.php">Propovedanja</a>
<a style="background:#edc;" href="pregprop.php">Pregled propovedanja</a></div>
<div class="redovi"><a style="background:#edc;" href="unosprop.php">Unos propovedi</a>
<a style="background:#edc;" href="podprop.php">Podešavanja propovedi</a></div>
<div class="redovi"><a style="background:#cfc;" href="utauta.php">Unos troškova auta</a>
<a style="background:#cfc;" href="ptauta.php">Pregled troškova auta</a></div>
<div></div>



<script type="text/javascript">
</script>
</body>
</html>