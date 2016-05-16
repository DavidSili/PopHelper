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

	if(isset($_POST['propoved']) && !empty($_POST['propoved'])) {

	$sql='INSERT INTO propovedi (`naziv`) VALUES ("'.$_POST['propoved'].'")';
	$mysqli->query($sql) or die;
	
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
<title id="Timerhead">Unos propovedi - Pop helper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<style type="text/css">
	td {
		padding:2px 5px;
	}
	th {
		padding:5px;
	}
</style>
<meta name="robots" content="noindex">
</head>
<body>
<div id="wrap">
<h1><a href="index.php"><<</a> Unos propovedi</h1>
<?php
$propovedao[]="";
$sql='SELECT propoved FROM `propovedanja` GROUP BY propoved ORDER BY propoved ';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$propovedao[]=$row['propoved'];
}

$sql='SELECT COUNT(*) cnt FROM propovedi';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojpropovedi=$row['cnt'];
if ($brojpropovedi==0) {
	echo '<h3>Trenutno nije unesena ni jedna propoved</h3>';
}
else {
	echo '<h3 style="margin-bottom:5px">Postojeće propovedi</h3>
	<table border=1>
		<thead>
			<tr>
				<th scope="col">Propoved</th>
				<th scope="col">Izmena</th>
			</tr>
		</thead>
		<tbody>';
$sql='SELECT * FROM propovedi ORDER BY naziv ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$ID=$row['ID'];
	$naziv=$row['naziv'];
	echo '<tr><td>'.$naziv.'</td><td><a href="edit.php?tip=1&za=5&id='.$ID.'" target="_blank"><img src="images/edit.gif" alt="izmena" style="width:20px;height:20px;border:0;margin-right:20px" /></a>';
	if (in_array($ID, $propovedao)==false) {
		echo '<a href="edit.php?tip=2&za=5&id='.$ID.'" target="_blank"><img src="images/del.gif" alt="izmena" style="width:20px;height:20px;border:0" /></a>';
	}
	echo '</td></tr>';
}
		echo '</tbody>
	</table>';
}
?>
	<br/><h3>Unos novih propovedi:</h3>
	<form action="#" method="POST"><div style="width:300px;height:75px">
	<div style="float:right">Propoved: <input type="text" name="propoved" title="propoved" /></div>
	<div style="float:right;text-align:center;width:300px;height:25px;margin-top:3px"><input type="submit" value="Unesi"/></div></div>
</div>
</form>
</body>
</html>