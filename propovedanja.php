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

	if(isset($_POST['crkva'])) {

	$sql='INSERT INTO propovedanja (`crkva`,`propoved`,`datum`) VALUES ("'.$_POST['crkva'].'","'.$_POST['propoved'].'","'.$_POST['datum'].'")';
	$mysqli->query($sql) or die(mysqli_error($mysqli));
	
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
<title id="Timerhead">Unos propovedanja - Pop helper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<style type="text/css">
</style>
<meta name="robots" content="noindex">
</head>
<body>
<div id="wrap">
<h1><a href="index.php"><<</a> Unos propovedanja</h1>
<form action="#" method="POST">
<?php
echo 'Crkva: <select name="crkva" style="margin-bottom:10px">';
$sql='SELECT * FROM crkve ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	echo '<option value="'.$row['ID'].'">'.$row['crkva'].'</option>';
}
echo '</select><br/>Propoved: <select name="propoved" style="margin-bottom:10px">';
$sql='SELECT * FROM propovedi ORDER BY naziv ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	echo '<option value="'.$row['ID'].'">'.$row['naziv'].'</option>';
}
$danusedmici=date('N');
$danas=date('Y-m-d');
if ($danusedmici==5 OR $danusedmici==6) $datum=$danas;
elseif ($danusedmici==7) {
	$danastime=time()-86400;
	$datum=date('Y-m-d',$danastime);
}
else {
	$danastime=time()-(($danusedmici+1)*86400);
	$datum=date('Y-m-d',$danastime);
}
echo '</select></br>Datum: <input type="date" name="datum" value="'.$datum.'" style="margin-bottom:10px" /><br/><input type="submit" value="unesi" style="margin-bottom:20px; width:150px;height:40px"/>';

$sql='SELECT ID, crkva FROM crkve ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$crkve[$row['ID']]=$row['crkva'];
}
$sql='SELECT ID, naziv FROM propovedi ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$propovedi[$row['ID']]=$row['naziv'];
}

$sql='SELECT COUNT(*) cnt FROM propovedanja';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojpropovedanja=$row['cnt'];
if ($brojpropovedanja==0) {
	echo '<h3>Trenutno nije uneseno ni jedno propovedanje</h3>';
}
else {
	echo '<h3 style="margin-bottom:5px">Poslednja propovedanja</h3>';
	echo '<table border=1>
		<thead>
			<tr>
				<th scope="col">Datum</th>
				<th scope="col">Crkva</th>
				<th scope="col">Propoved</th>
			</tr>
		</thead>
		<tbody>';
$sql='SELECT * FROM propovedanja ORDER BY datum DESC LIMIT 5';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$datum=$row['datum'];
	$datum=date('d.m.Y.',strtotime($datum));
	$crkva=$row['crkva'];
	$propoved=$row['propoved'];
	echo '<tr><td>'.$datum.'</td><td>'.$crkve[$crkva].'</td><td>'.$propovedi[$propoved].'</td></tr>';
}
		echo '</tbody>
	</table>';
}
?>
</div>
</form>
</body>
</html>