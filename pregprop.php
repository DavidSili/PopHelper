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
	if(isset($_GET['crkva'])) $crkva=$_GET['crkva'];

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
<title id="Timerhead">Pregled propovedanja - Pop helper 3.0</title>
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
<h1><a href="index.php"><<</a> Pregled propovedanja <a href="fullpregprop.php">>></a></h1>
<form action="#" method="GET">
<?php
if (isset($crkva)==FALSE) $crkva=0;
echo '<select name="crkva">';
$sql='SELECT * FROM crkve ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	echo '<option value="'.$row['ID'].'"';
	if ($row['ID']==$crkva) echo ' selected="selected"';
	echo '>'.$row['crkva'].'</option>';
}
echo '</select><br/><input type="submit" value="Pokaži" style="margin:10px auto;width:100px;height:40px" />';
	if(isset($_GET['crkva'])) {

$sql='SELECT propoved, COUNT(ID) cnt FROM propovedanja GROUP BY propoved ORDER BY cnt DESC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$popularne[$row['propoved']]=$row['cnt'];
}

$sql='SELECT ID, naziv FROM propovedi ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$sveprop[$row['ID']]=$row['naziv'];
}

$sql='SELECT propoved FROM propovedanja WHERE crkva='.$crkva.' ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$propovedao[]=$row['propoved'];
}
if (isset($propovedao)) {
echo '<h2>Najpopularnije propovedi</h2><table border=1>
		<thead>
			<tr>
				<th scope="col">Propoved</th>
				<th scope="col">Koliko</th>
			</tr>
		</thead>
		<tbody>';
$popularcounter=0;
foreach ($popularne as $x=>$y) {
	if (in_array($x,$propovedao)==FALSE) {
		echo '<tr><td>'.$sveprop[$x].'</td><td>'.$y.'</td></tr>';
		$popularcounter++;
	};
	if ($popularcounter==5) break;
}
echo '</tbody>
	</table><h2 style="margin-top:5px">Najnovije propovedi</h2><table border=1>
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Propoved</th>
			</tr>
		</thead>
		<tbody>';	
$novocounter=0;
$noveprop=array_reverse($sveprop, true);
foreach ($noveprop as $x=>$y) {
	if (in_array($x,$propovedao)==FALSE) {
		echo '<tr><td>'.$x.'</td><td>'.$y.'</td></tr>';
		$novocounter++;
	};
	if ($novocounter==5) break;
}

echo '</tbody>
	</table><h2 style="margin-top:5px">Najdavnije propovedane</h2><table border=1>
		<thead>
			<tr>
				<th scope="col">Datum</th>
				<th scope="col">Propoved</th>
			</tr>
		</thead>
		<tbody>';	
$sql='SELECT propovedanja.datum, propovedi.naziv FROM propovedanja LEFT JOIN propovedi ON propovedanja.propoved = propovedi.ID WHERE propovedanja.crkva='.$crkva.' GROUP BY propovedanja.propoved ORDER BY propovedanja.datum ASC LIMIT 10 ';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$datum=date('d.m.Y.',strtotime($row['datum']));
	echo '<tr><td>'.$datum.'</td><td>'.$row['naziv'].'</td></tr>';
}
echo '</tbody>
	</table><h2 style="margin-top:5px">Najskorije propovedane</h2><table border=1>
		<thead>
			<tr>
				<th scope="col">Datum</th>
				<th scope="col">Propoved</th>
			</tr>
		</thead>
		<tbody>';	
$sql='SELECT propovedanja.datum, propovedi.naziv FROM propovedanja LEFT JOIN propovedi ON propovedanja.propoved = propovedi.ID WHERE propovedanja.crkva='.$crkva.' GROUP BY propovedanja.propoved ORDER BY propovedanja.datum DESC LIMIT 10 ';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$datum=date('d.m.Y.',strtotime($row['datum']));
	echo '<tr><td>'.$datum.'</td><td>'.$row['naziv'].'</td></tr>';
}
echo '</tbody>
	</table>';
		}
		else {
			echo '<h2>Još nema propovedanih propovedi</h2><br/>';
echo '<h2>Najpopularnije propovedi</h2><table border=1>
		<thead>
			<tr>
				<th scope="col">Propoved</th>
				<th scope="col">Koliko</th>
			</tr>
		</thead>
		<tbody>';
$najpopularnije=array_slice($popularne,0,5, true);
foreach ($najpopularnije as $x=>$y) {
	echo '<tr><td>'.$sveprop[$x].'</td><td>'.$y.'</td></tr>';
}
echo '</tbody>
	</table><h2 style="margin-top:5px">Najnovije propovedi</h2><table border=1>
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Propoved</th>
			</tr>
		</thead>
		<tbody>';	
$noveprop=array_reverse($sveprop, true);
$najnovije=array_slice($noveprop,0,5, true);
foreach ($najnovije as $x=>$y) {
	echo '<tr><td>'.$x.'</td><td>'.$y.'</td></tr>';
}

echo '</tbody>
	</table>';
		}
	}	
?>
</form>
</div>
</body>
</html>