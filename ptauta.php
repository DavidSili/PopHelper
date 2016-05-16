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
<h1 style="font-size:22px"><a href="index.php"><<</a> Pregled troškova auta <a href="ptautaall.php">>></a></h1>
<?php
$sql='SELECT COUNT(*) cnt FROM auto';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojtroskova=$row['cnt'];
if ($brojtroskova==0) {
	echo '<h3>Trenutno nije unesen ni jedan trošak</h3>';
}
else {

// statistike
$sql='SELECT * FROM auto WHERE vrsta=1 AND cep=1';
$result = $mysqli->query($sql) or die;

$sql='SELECT * FROM auto';
$result = $mysqli->query($sql) or die;

$ltuk=0;
$trosuk=0;
$totaltros=0;
$lastkm=210704;

while ($row=$result->fetch_assoc()) {
	$vrsta=$row['vrsta'];
	$cep=$row['cep'];
	$km=$row['km'];
	$trosak=$row['trosak'];
	$litara=$row['litara'];

	if ($vrsta==1 OR $vrsta==2) {
		
		$ltuk=$ltuk+$litara;
		$trosuk=$trosuk+$trosak;
		$lastkm=$km;
	}
	$totaltros=$totaltros+$trosak;
}
$predjeno=$lastkm-210704;
$avg100km=($ltuk/$predjeno)*100;
$avgrsd=$trosuk/$predjeno;
$avg100km=round($avg100km,2);
$avgrsd=round($avgrsd,2);
$sada=time();
$razlika=$sada-1444644000;
$avgmes=$trosuk/$razlika*2629760;
$avggod=$avgmes*12;
$avggod=number_format($avggod, 0, '.', ',');;
$avgmes=number_format($avgmes, 0, '.', ',');;

echo '<div>Prosečna potrošnja:<br/><b>'.$avg100km.'</b> l/100km & <b>'.$avgrsd.'</b> rsd/km.<br/>Ukupno: <b>'.$avgmes.'</b> RSD/mes., <b>'.$avggod.'</b> RSD/god.</div>';

// listanje
	
	echo '<h3 style="margin:5px 0">Najskoriji troškovi</h3>';
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
$sql='SELECT * FROM auto ORDER BY km DESC LIMIT 20';
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