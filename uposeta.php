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
	foreach($_POST as $xx => $yy) {
		$$xx=$yy;
	}
	$sql='SELECT ID, status FROM imenik';
	$result = $mysqli->query($sql) or die;
	while ($row=$result->fetch_assoc()) {
	$ID=$row['ID'];
	$status=$row['status'];
		if (isset(${'check'.$ID})) {
			$sql='INSERT INTO posete (`osoba`, `datum`, `komentar`) VALUES ('.$ID.',"'.$datum.'","'.${'txt'.$ID}.'")';
			$mysqli->query($sql) or die;
			
			$sql2='SELECT pposeta FROM imenik WHERE ID="'.$ID.'"';
			$result2 = $mysqli->query($sql2) or die;
			$row2=$result2->fetch_assoc();
			$spposeta=$row2['pposeta'];
			$tspposeta=strtotime($spposeta);
			$tdatum=strtotime($datum);
			if ($tdatum>$tspposeta) {
				$sql='UPDATE imenik SET `pposeta`="'.$datum.'" WHERE `ID`="'.$ID.'"';
				$mysqli->query($sql) or die;
			}
			if ($status==2) {
				for ($i = 1; $i <= 34; $i++) {
					if (isset(${'tema'.$ID.'-'.$i})) {
						$sql3='INSERT INTO teme (`osoba`, `datum`, `tema`) VALUES ('.$ID.',"'.$datum.'","'.$i.'")';
						$mysqli->query($sql3) or die;
					}
				}
			}
		}
	}
	echo "<script type='text/javascript'>alert('Poseta je unesena');</script>";
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
<title id="Timerhead">Unos poseta - Pop helper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<style type="text/css">
</style>
<meta name="robots" content="noindex">
</head>
<body>
<form action="uposeta.php" method="post" onsubmit="return confirm('Potvrdi')">
<?php
$sql='SELECT ID, imegore FROM mesta ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	${'d'.$row['ID']}="";
	$svamesta[$row['ID']]=$row['imegore'];
}
$sql='SELECT * FROM imenik ORDER BY pposeta';
$danas=time();
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	foreach($row as $xx => $yy) {
		$$xx=$yy;
	}
	if ($pposeta==NULL) {
	$pposeta = 'X';
	$razlika = 'X';
	$boja='color:#a00';
	}
	else {
		$tada=strtotime($pposeta);
		$razlika=floor(($danas-$tada)/86400);
		if ($razlika <60) {
			$kolicina=floor(((60-$razlika)/60)*200);
			$boja='color: rgb(0, '.$kolicina.', 0)';
		}
		elseif ($razlika >59 AND $razlika <120) {
			$kolicina=floor((($razlika-60)/60)*255);
			$boja='color: rgb('.$kolicina.', 0, 0)';
		}
		else {
			$boja='color: rgb(255, 0, 0)';
		}
	}
	if ($status==1) $ime='<span style="color:#090">'.$ime.'</span>';
	elseif ($status==2) $ime='<span style="color:#00f">'.$ime.'</span>';
	$ime='<span style="'.$boja.';vertical-align:4px">'.$razlika.'</span><span style="vertical-align:4px">| '.$ime.'</span>';
	if ($pposeta!='X') $pposeta=date('d.m.\'y.',strtotime($pposeta));
	$sadrzaj='<div class="pcontainer"><div class="plevo"><input type="checkbox" name="check'.$ID.'" value="1">'.$ime.'</div><div class="pdesno"> - <span style="margin-right:5px;'.$boja.'">'.$pposeta.'</span><input type="button" value="&#x25BC;" id="down'.$ID.'" onclick="opener('.$ID.')" /><input type="button" value="&#x25B2;" id="up'.$ID.'" onclick="closer('.$ID.')" style="display:none" /></div></div><textarea name="txt'.$ID.'" id="txt'.$ID.'" rows="3" style="display:none"></textarea>';
	if ($status==2) {
		${'prouceneteme'.$ID}=array();
		$sql2='SELECT tema FROM `teme` WHERE osoba = "'.$ID.'" ORDER BY "tema" ASC';
		$result2 = $mysqli->query($sql2) or die;
		while ($row2=$result2->fetch_assoc()) {
			array_push(${'prouceneteme'.$ID},$row2['tema']);
		}
		$sadrzaj.='<div id="teme'.$ID.'" class="teme">';
		$sql3='SELECT rbuseriji, naziv FROM serije WHERE serija="'.$serija.'" ORDER BY rbuseriji ASC';
		$result3 = $mysqli->query($sql3) or die;
		while ($row3=$result3->fetch_assoc()) {
			$rbuseriji=$row3['rbuseriji'];
			$naziv=$row3['naziv'];
			$sadrzaj.='<input type="checkbox" name="tema'.$ID.'-'.$rbuseriji.'" value="1" /><span ';
			if (in_array($rbuseriji, ${'prouceneteme'.$ID})) {
				$sadrzaj.='style="color:#aaa"';
			}
			$sadrzaj.='>'.$rbuseriji.' - '.$naziv.'</span></br>';
		}
		$sadrzaj.='</div>';
	}
	${'d'.$mesto}.=$sadrzaj;

}

$datum=date('Y-m-d');
?>
<div id="uptoolbar">
<input type="date" name="datum" style="float:left;margin-left:5px" value="<?php echo $datum; ?>"/> <a href="index.php" style="color:#ffffff;float:left;margin-left:5px"><<</a><input type="submit" value=">>" style="float:right"/>
</div>
<div id="toolbar"><div id="mesto1" onclick="show(1)"><?php echo $svamesta[1]; ?></div><div id="mesto2" onclick="show(2)" style="font-size:14px;height:20px"><?php echo $svamesta[2]; ?></div><div id="mesto3" onclick="show(3)"><?php echo $svamesta[3]; ?></div><div id="mesto4" onclick="show(4)"><?php echo $svamesta[4]; ?></div></div>
<div id="wrap">
	<div id="lista1" style="display:inline"><?php echo $d1; ?>
	</div>
	<div id="lista2" style="display:none"><?php echo $d2; ?>
	</div>
	<div id="lista3" style="display:none"><?php echo $d3; ?>
	</div>
	<div id="lista4" style="display:none"><?php echo $d4; ?>
	</div>
</div>
<script type="text/javascript">
function show(pokazi)
	{
		if (pokazi!=1) document.getElementById("lista1").style.display="none";
			else document.getElementById("lista1").style.display="inline";
		if (pokazi!=2) document.getElementById("lista2").style.display="none";
			else document.getElementById("lista2").style.display="inline";
		if (pokazi!=3) document.getElementById("lista3").style.display="none";
			else document.getElementById("lista3").style.display="inline";
		if (pokazi!=4) document.getElementById("lista4").style.display="none";
			else document.getElementById("lista4").style.display="inline";
	}
function opener(koji)
	{
		document.getElementById("txt"+koji).style.display="inline";
		var element =  document.getElementById('teme'+koji);
		if (typeof(element) != 'undefined' && element != null)
		{
		document.getElementById("teme"+koji).style.display="block";
		}
		document.getElementById("down"+koji).style.display="none";
		document.getElementById("up"+koji).style.display="inline";
	}
function closer(koji)
	{
		document.getElementById("txt"+koji).style.display="none";
		var element =  document.getElementById('teme'+koji);
		if (typeof(element) != 'undefined' && element != null)
		{
		document.getElementById("teme"+koji).style.display="none";
		}
		document.getElementById("down"+koji).style.display="inline";
		document.getElementById("up"+koji).style.display="none";
	}

</script>
</form>
</body>
</html>