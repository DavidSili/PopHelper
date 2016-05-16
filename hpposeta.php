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
<title id="Timerhead">Hronološki pregled poseta - Pop helper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<style type="text/css">
</style>
<meta name="robots" content="noindex">
</head>
<body>
<div id="wrap">
<h1><a href="index.php"><<</a> Hronološki pregled poseta</h1>
<?php
$sql='SELECT ID, imegore FROM mesta ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	${'d'.$row['ID']}="";
	$svamesta[$row['ID']]=$row['imegore'];
}
$sql='SELECT posete.ID pid, posete.datum datum, posete.komentar komentar, imenik.mesto mesto, imenik.ime ime, imenik.status status FROM posete LEFT JOIN imenik ON posete.osoba = imenik.ID ORDER BY posete.datum DESC, posete.ID DESC';
$result = $mysqli->query($sql) or die;
$ogodina=date('Y');
$omesec=date('n');
$pgodina='';
$pmesec='';
while ($row=$result->fetch_assoc()) {
	foreach($row as $xx => $yy) {
		$$xx=$yy;
	}
	$nmeseca=array(1=>"Januar",2=>"Februar",3=>"Mart",4=>"April",5=>"Maj",6=>"Jun",7=>"Jul",8=>"Avgust",9=>"Septembar",10=>"Oktobar",11=>"Novembar",12=>"Decembar");
	$godina=date('Y',strtotime($datum));
	$mesec=date('n',strtotime($datum));
	$dan=date('j.',strtotime($datum));
	if ($godina!=$pgodina) echo '<h2>'.$godina.'</h2>';
	if ($mesec!=$pmesec OR $godina!= $pgodina) echo '<h3 style="margin-left:10px">'.$nmeseca[$mesec].'</h3>';
	echo '<div class="indcon"><div class="datfield">'.$dan.'</div><div class="imefield" ';
	if ($status==1) echo 'style="color:#090" ';
	elseif ($status==2) echo 'style="color:#00f" ';
	echo '>'.$ime.'</div><div class="mesfield" >'.$svamesta[$mesto].'<div style="float:right;width:60px"><a href="edit.php?tip=1&za=1&id='.$pid.'" target="_blank"><img src="images/edit.gif" alt="izmena" style="width:20px;height:20px;border:0;margin:0 10px" /></a><a href="edit.php?tip=2&za=1&id='.$pid.'" target="_blank"><img src="images/del.gif" alt="izmena" style="width:20px;height:20px;border:0" /></a></div></div>';
	if ($komentar!="") echo '<br/><div><i>'.$komentar.'</i></div>';
	echo '</div>';
	$pgodina=$godina;
	$pmesec=$mesec;
}
?>
</div>
</body>
</html>