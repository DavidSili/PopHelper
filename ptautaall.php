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
<title id="Timerhead">Pregled troškova auta - Pop helper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<style type="text/css">
	td {
		padding:1px 1px;
		text-align:right;
	}
	th {
		padding:1px;
	}
</style>
<meta name="robots" content="noindex">
</head>
<body>
<div id="wrap">
<h1 style="font-size:22px"><a href="index.php"><<</a> <a href="ptauta.php"><</a> Pregled troškova auta</h1>
<?php
$sql='SELECT COUNT(*) cnt FROM auto';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojtroskova=$row['cnt'];
if ($brojtroskova==0) {
	echo '<h3>Trenutno nije unesen ni jedan trošak</h3>';
}
else {
	echo '<table border=1 style="font-size:14">
		<thead>
			<tr>
				<th scope="col">Dat.</th>
				<th scope="col">Naziv</th>
				<th scope="col">l</th>
				<th scope="col">RSD</th>
				<th scope="col">km</th>
			</tr>
		</thead>
		<tbody>';
$sql='SELECT * FROM auto ORDER BY km DESC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$datum=$row['datum'];
	$vrsta=$row['vrsta'];
	$naziv=$row['naziv'];
	$km=$row['km'];
	$cep=$row['cep'];
	$litara=$row['litara'];
	$trosak=$row['trosak'];
	$datum=date('d.m.',strtotime($datum));
	if ($litara=="0.00") $litara="";
switch($vrsta) {
    case 0:
		$boja="ccc";
        break;
    case 1:
		if ($cep==1) $boja="ada";
			else $boja="cfc";
        break;
    case 2:
		$boja="cdf";
        break;
    case 3:
 		$boja="edc";
        break;
}
	echo '<tr style="background:#'.$boja.'"><td>'.$datum.'</td><td style="text-align:left;width:112px">'.$naziv.'</td><td>'.$litara.'</td><td>'.$trosak.'</td><td>'.$km.'</td></tr>';
}
		echo '</tbody>
	</table>';
}
?>
</div>
</body>
</html>