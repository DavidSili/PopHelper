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

	if(isset($_POST['datum']) && !empty($_POST['datum'])) {

	if (isset($_POST['cep'])==FALSE) $_POST['cep']=0;
	$sql='INSERT INTO auto (`datum`,`vrsta`,`cep`,`naziv`,`km`,`trosak`,`litara`) VALUES ("'.$_POST['datum'].'","'.$_POST['vrsta'].'","'.$_POST['cep'].'","'.$_POST['naziv'].'","'.$_POST['km'].'","'.$_POST['trosak'].'","'.$_POST['litara'].'")';
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
<title id="Timerhead">Unos troškova auta - Pop helper 3.0</title>
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
<h1 style="font-size:27px"><a href="index.php"><<</a> Unos troškova auta</h1>
	<form action="#" method="POST"><div style="width:300px;height:215px;line-height:25px">
	<div style="width:300px;height:25px">Datum: <input type="date" name="datum" title="datum" value="<?php echo date('Y-m-d'); ?>" style="float:right;width:170px" /></div>
	<div style="width:300px;height:25px">
	Vrsta troška: <select name="vrsta" style="float:right;width:170px">
		<option value="1" selected="selected">TNG</option>
		<option value="2">Benzin</option>
		<option value="3">Ostalo</option>
	</select>
	</div>
	<div style="width:300px;height:25px">Naziv: <input type="text" name="naziv" title="naziv" style="float:right;width:170px" /></div>
	<div style="width:300px;height:25px">Litara: (do čepa <input type="checkbox" name="cep" value="1" /> ) <input type="number" step="0.01" name="litara" title="litara" style="float:right;width:150px" /></div>
	<div style="width:300px;height:25px">Kilometraža: <input type="number" name="km" title="kilometraža" style="float:right;width:170px" /></div>
	<div style="width:300px;height:25px;margin-bottom:5px">Trošak: <input type="number" name="trosak" title="Trošak (RSD)" style="float:right;width:170px" /></div>
	<div style="float:right;text-align:center;width:300px;height:25px;margin-top:3px"><input type="submit" value="Unesi" style="width:100px;height:35px" /></div></div>
<?php
$sql='SELECT COUNT(*) cnt FROM auto';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$brojtroskova=$row['cnt'];
if ($brojtroskova==0) {
	echo '<h3>Trenutno nije unesen ni jedan trošak</h3>';
}
else {
	echo '<h3 style="margin-bottom:5px">Najskoriji troškovi</h3>';
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
$sql='SELECT * FROM auto ORDER BY km DESC LIMIT 5';
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
</form>
</body>
</html>