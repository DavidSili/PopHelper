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

	if(isset($_POST['crkva']) && !empty($_POST['crkva'])) {

	$sql='INSERT INTO crkve (`crkva`) VALUES ("'.$_POST['crkva'].'")';
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
<title id="Timerhead">Podešavanja propovedi - Pop helper 3.0</title>
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
<h1><a href="index.php"><<</a> Podešavanja za propovedi u crkvama</h1>
<?php
$propovedao[]="";
$sql='SELECT crkva FROM `propovedanja` GROUP BY crkva ORDER BY crkva ';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$propovedao[]=$row['crkva'];
}

$sql='SELECT COUNT(*) cnt FROM crkve';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojmesta=$row['cnt'];
if ($brojmesta==0) {
	echo '<h3>Trenutno nije unesena ni jedna crkva</h3>';
}
else {
	echo '<h3>Postojeće crkve</h3>';
	echo '<table border=1>
		<thead>
			<tr>
				<th scope="col">Crkva</th>
				<th scope="col">Izmena</th>
			</tr>
		</thead>
		<tbody>';
$sql='SELECT * FROM crkve ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$ID=$row['ID'];
	$crkva=$row['crkva'];
	echo '<tr><td>'.$crkva.'</td><td><a href="edit.php?tip=1&za=6&id='.$ID.'" target="_blank"><img src="images/edit.gif" alt="izmena" style="width:20px;height:20px;border:0;margin-right:20px" /></a>';
	if (in_array($ID, $propovedao)==false) {
		echo '<a href="edit.php?tip=2&za=6&id='.$ID.'" target="_blank"><img src="images/del.gif" alt="izmena" style="width:20px;height:20px;border:0" /></a>';
	}
	echo '</td></tr>';
}
		echo '</tbody>
	</table>';
}
	echo '<br/><h3>Unos novih crkava:</h3>';
	echo '<form action="#" method="POST"><div style="width:300px;height:75px">
	<div style="float:right">Crkva: <input type="text" name="crkva" title="crkva" /></div>
	<div style="float:right;text-align:center;width:300px;height:25px;margin-top:3px"><input type="submit" value="Unesi"/></div></div>
	</form>';
?>
</div>
</form>
</body>
</html>