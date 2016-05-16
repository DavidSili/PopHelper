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

	if(isset($_POST) && !empty($_POST)) {
	
	$mesto=$_POST['mesto'];
	$ime=$_POST['ime'];
	$serija=$_POST['serija'];
	$status=$_POST['status'];
	if ($serija=="n") $sql='INSERT INTO imenik (`mesto`, `ime`, `serija`, `status`) VALUES ("'.$mesto.'","'.$ime.'",NULL,"'.$status.'")';
	else $sql='INSERT INTO imenik (`mesto`, `ime`, `serija`, `status`) VALUES ("'.$mesto.'","'.$ime.'","'.$serija.'","'.$status.'")';
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
<title id="Timerhead">Sređivanje imenika - Pop helper 3.0</title>
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
<h1><a href="index.php"><<</a> Sređivanje imenika</h1>
<?php
$posetio[]="";
$sql='SELECT osoba FROM posete GROUP BY osoba ORDER BY osoba ';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$posetio[]=$row['osoba'];
}

$sql='SELECT COUNT(*) cnt FROM imenik';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojmesta=$row['cnt'];
if ($brojmesta==0) {
	echo '<h3>Trenutno nije unesena ni jedna osoba</h3>';
}
else {
	echo '<h3>Postojeće osobe</h3>';
	echo '<table border=1>
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Ime</th>
				<th scope="col">Mesto</th>
				<th scope="col">Serija</th>
				<th scope="col">Poslednja poseta</th>
				<th scope="col">Status</th>
				<th scope="col">Izmena</th>
			</tr>
		</thead>
		<tbody>';
$sql='SELECT ID, naziv FROM mesta';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$mesta[$row['ID']]=$row['naziv'];
}
$sql='SELECT * FROM imenik ORDER BY mesto ASC, ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$ID=$row['ID'];
	$mesto=$row['mesto'];
	$ime=$row['ime'];
	$serija=$row['serija'];
	$pposeta=$row['pposeta'];
	$status=$row['status'];
switch ($serija) {
     case "1":
         $serija="Biblija uči";
         break;
     case "2":
         $serija="Čudesne činjenice";
         break;
 }
switch ($status) {
     case "1":
         $status="Prijatelj";
         break;
     case "2":
         $status="Član";
         break;
 }
	if(empty($pposeta)) $pposeta="";
	else $pposeta=date('d.m.Y.',strtotime($pposeta));
	echo '<tr><td style="text-align:right">'.$ID.'</td><td>'.$ime.'</td><td>'.$mesta[$mesto].'</td><td>'.$serija.'</td><td>'.$pposeta.'</td><td>'.$status.'</td><td><div style="float:right;width:60px"><a href="edit.php?tip=1&za=2&id='.$ID.'" target="_blank"><img src="images/edit.gif" alt="izmena" style="width:20px;height:20px;border:0;margin-right:20px" /></a>';
	if (in_array($ID, $posetio)==false) {
		echo '<a href="edit.php?tip=2&za=2&id='.$ID.'" target="_blank"><img src="images/del.gif" alt="izmena" style="width:20px;height:20px;border:0" /></a></div></tr>';
	}
}
		echo '</tbody>
	</table>';
}
	echo '<br/><h3>Unos novih osoba:</h3>';
	echo '<form action="#" method="POST"><div style="width:300px;height:75px">
	<div style="float:right">Mesto: <select name="mesto" style="width:175px">';
	$sql='SELECT ID, naziv FROM mesta ORDER BY ID';
	$result = $mysqli->query($sql) or die;
	while ($row=$result->fetch_assoc()) {
	echo '<option value="'.$row['ID'].'">'.$row['naziv'].'</option>';
	}
	echo '</select></div>
	<div style="float:right;margin-top:3px">Ime: <input type="text" name="ime" title="Naziv porodice ili pojedinca" style="width:175px" /></div>
	<div style="float:right;margin-top:3px">Serija: <select name="serija" style="width:175px"><option value="n"></option><option value="1">Biblija uči</option><option value="2">Čudesne činjenice</option></select></div>
	<div style="float:right;margin-top:3px">Status: <select name="status" title="Status osobe ili porodice" style="width:175px"><option value="1">Prijatelj</option><option value="2" selected="selected">Član</option></select></div>
	<div style="float:right;text-align:center;width:300px;height:25px;margin-top:3px"><input type="submit" value="Unesi"/></div></div>
	</form>';
?>
</div>
</form>
</body>
</html>