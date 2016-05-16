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

	if(isset($_POST['naziv']) && !empty($_POST['naziv']) && isset($_POST['imegore']) && !empty($_POST['imegore'])) {

	$sql='INSERT INTO mesta (`naziv`, `imegore`) VALUES ("'.$_POST['naziv'].'","'.$_POST['imegore'].'")';
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
<title id="Timerhead">Podešavanja poseta - Pop helper 3.0</title>
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
<h1><a href="index.php"><<</a> Podešavanja za mesta u okrugu</h1>
<?php
$sql='SELECT COUNT(*) cnt FROM mesta';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojmesta=$row['cnt'];
if ($brojmesta==0) {
	echo '<h3>Trenutno nije uneseno ni jedno mesto</h3>';
}
else {
	echo '<h3>Postojeća mesta</h3>';
	echo '<table border=1>
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Naziv</th>
				<th scope="col">Gornji naziv</th>
				<th scope="col">Izmene</th>
			</tr>
		</thead>
		<tbody>';
$sql='SELECT * FROM mesta';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$ID=$row['ID'];
	$naziv=$row['naziv'];
	$imegore=$row['imegore'];
	echo '<tr><td style="text-align:right">'.$ID.'</td><td>'.$naziv.'</td><td>'.$imegore.'</td><td style="text-align:center"><a href="edit.php?tip=1&za=3&id='.$ID.'" target="_blank"><img src="images/edit.gif" alt="izmena" style="width:20px;height:20px;border:0" /></a></td></tr>';
}
		echo '</tbody>
	</table>';
}
	echo '<br/><h3>Unos novih mesta:</h3>';
	echo '<form action="#" method="POST"><div style="width:300px;height:75px">
	<div style="float:right">Naziv: <input type="text" name="naziv" title="Naziv" /></div>
	<div style="float:right;margin-top:3px">Gornji naziv: <input type="text" name="imegore" title="Gornji naziv" /></div>
	<div style="float:right;text-align:center;width:300px;height:25px;margin-top:3px"><input type="submit" value="Unesi"/></div></div>
	</form>';
?>
</div>
</form>
</body>
</html>