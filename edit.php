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

	$tip=$_GET['tip'];
	$za=$_GET['za'];
	$id=$_GET['id'];
	if ($tip==1) {
		$tipt='Izmena';
	}
	else {
		$tipt='Brisanje';
	}
	if(isset($_GET['do']) && !empty($_GET['do'])) {
		if ($tip==1) {
			switch ($za) {
			case 1:
				$osoba=$_POST['osoba'];
				$datum=$_POST['datum'];
				if (isset($_POST['komentar'])==false) $komentar="";
					else $komentar=$_POST['komentar'];
				$sql='UPDATE posete SET `osoba`="'.$osoba.'",`datum`="'.$datum.'",`komentar`="'.$komentar.'" WHERE ID='.$id;
				break;
			case 2:
				$ime=$_POST['ime'];
				$mesto=$_POST['mesto'];
				$serija=$_POST['serija'];
				$pposeta=$_POST['pposeta'];
				$status=$_POST['status'];
				if ($serija=="n") $sql='UPDATE imenik SET `ime`="'.$ime.'",`mesto`="'.$mesto.'",`serija`=NULL,`pposeta`="'.$pposeta.'",`status`="'.$status.'" WHERE ID='.$id;
					else $sql='UPDATE imenik SET `ime`="'.$ime.'",`mesto`="'.$mesto.'",`serija`="'.$serija.'",`pposeta`="'.$pposeta.'",`status`="'.$status.'" WHERE ID='.$id;
				break;
			case 3:
				$naziv=$_POST['naziv'];
				$imegore=$_POST['imegore'];
				$sql='UPDATE mesta SET `naziv`="'.$naziv.'",`imegore`="'.$imegore.'" WHERE ID='.$id;
				break;
			case 4:
				$datum=$_POST['datum'];
				$crkva=$_POST['crkva'];
				$propoved=$_POST['propoved'];
				$sql='UPDATE propovedanja SET `datum`="'.$datum.'",`crkva`="'.$crkva.'",`propoved`="'.$propoved.'" WHERE ID='.$id;
				break;
			case 5:
				$naziv=$_POST['naziv'];
				$sql='UPDATE propovedi SET `naziv`="'.$naziv.'" WHERE ID='.$id;
				break;
			case 6:
				$crkva=$_POST['crkva'];
				$sql='UPDATE crkve SET `crkva`="'.$crkva.'" WHERE ID='.$id;
				break;
			}
			$mysqli->query($sql) or die;
			echo  "<script type='text/javascript'>";
			echo "window.close();";
			echo "</script>";
		}
		else {
			switch ($za) {
			case 1:
				$sql='DELETE FROM posete WHERE ID='.$id;
				break;
			case 2:
				$sql='DELETE FROM imenik WHERE ID='.$id;
				break;
			case 4:
				$sql='DELETE FROM propovedanja WHERE ID='.$id;
				break;
			case 5:
				$sql='DELETE FROM propovedi WHERE ID='.$id;
				break;
			case 6:
				$sql='DELETE FROM crkve WHERE ID='.$id;
				break;
			}
			$sql2='SELECT osoba FROM posete WHERE ID='.$id;
			$result2 = $mysqli->query($sql2) or die;
			$row2=$result2->fetch_assoc();
			$osoba=$row2['osoba'];
			
			$mysqli->query($sql) or die;
			
			if ($za==1) {
				$sql='SELECT datum FROM posete WHERE osoba='.$osoba.' ORDER BY datum DESC LIMIT 1';
				$result = $mysqli->query($sql) or die;
				$row=$result->fetch_assoc();
				if (isset($row) AND empty($row)==false) {
				$pposeta=$row['datum'];
				$sql='UPDATE imenik SET `pposeta`="'.$pposeta.'" WHERE ID="'.$osoba.'"';
				} else $sql='UPDATE imenik SET `pposeta`=NULL WHERE ID="'.$osoba.'"';
				$mysqli->query($sql) or die;
			}
			
			echo  "<script type='text/javascript'>";
			echo "window.close();";
			echo "</script>";
		}
	
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
<title id="Timerhead"><?php echo $tipt; ?> - Pop helper 3.0</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<style type="text/css">
	td {
		padding:1px 3px;
	}
	th {
		padding:3px;
	}
</style>
<meta name="robots" content="noindex">
</head>
<body>
<div id="wrap">
<h1><?php echo $tipt; ?></h1>
<?php
		if ($tip==1) {
			switch ($za) {
			case 1:
				echo '<h3 style="margin-bottom:5px">Izmena poseta</h3>
				<form method="POST" action="edit.php?tip=1&za=1&id='.$id.'&do=1">
				<table border=1 style="font-size:12">
					<thead>
						<tr>
							<th scope="col">Polje</th>
							<th scope="col">Prošlo</th>
							<th scope="col">Novo stanje</th>
						</tr>
					</thead>
					<tbody>';
					$sql='SELECT posete.osoba osoba, imenik.ime ime, posete.datum datum, posete.komentar komentar FROM posete LEFT JOIN imenik ON posete.osoba = imenik.ID WHERE posete.ID='.$id;
					$result = $mysqli->query($sql) or die;
					$row=$result->fetch_assoc();
					$ime=$row['ime'];
					$osoba=$row['osoba'];
					$datum=$row['datum'];
					$komentar=$row['komentar'];
					echo '<tr><td>ID</td><td>'.$id.'</td><td>'.$id.'</td></tr>
					<tr><td>osoba</td><td>'.$ime.'</td><td><select name="osoba" style="width:150px">';
					$sql='SELECT imenik.ID idx, imenik.ime ime, mesta.naziv mesto FROM imenik LEFT JOIN mesta ON imenik.mesto = mesta.ID ORDER BY mesto ASC, ime ASC';
					$result = $mysqli->query($sql) or die;
					while ($row=$result->fetch_assoc()) {
					$idx=$row['idx'];
					$ime=$row['ime'];
					$mesto=$row['mesto'];
						echo '<option value="'.$idx.'" ';
						if ($idx==$osoba) echo 'selected="selected"';
						echo '>'.$mesto.' - '.$ime.'</option>';
					}
					$datumx=date('Y-m-d',strtotime($datum));
					echo '</select></td></tr>
					<tr><td>datum</td><td>'.$datum.'</td><td><input type="date" name="datum" value="'.$datumx.'" style="width:150px" /></td></tr>
					<tr><td>komentar</td><td>'.$komentar.'</td><td><textarea name="komentar" style="width:150px;height:50px">'.$komentar.'</textarea></td></tr>';
					echo '</tbody></table><div style="width:300px;height:50px;margin-top:20px"><input type="submit" value="Izmeni" style="float:left;width:100px;height:50px" />
				<button type="button" 
        onclick="window.open(\'\', \'_self\', \'\'); window.close();"  style="float:right;width:100px;height:50px">Odustani</button></div></form>';
				break;
			case 2:
				echo '<h3 style="margin-bottom:5px">Sređivanje imenika</h3>
				<form method="POST" action="edit.php?tip=1&za=2&id='.$id.'&do=1">
				<table border=1 style="font-size:12">
					<thead>
						<tr>
							<th scope="col">Polje</th>
							<th scope="col">Prošlo</th>
							<th scope="col">Novo stanje</th>
						</tr>
					</thead>
					<tbody>';
					$sql='SELECT imenik.ime ime, imenik.mesto mesto, mesta.naziv nazivmesta, imenik.serija serija, imenik.pposeta pposeta, imenik.status status FROM imenik LEFT JOIN mesta ON imenik.mesto = mesta.ID WHERE imenik.ID='.$id;
					$result = $mysqli->query($sql) or die;
					$row=$result->fetch_assoc();
					$ime=$row['ime'];
					$mesto=$row['mesto'];
					$nazivmesta=$row['nazivmesta'];
					$serija=$row['serija'];
					$pposeta=$row['pposeta'];
					$status=$row['status'];
					echo '<tr><td>ID</td><td>'.$id.'</td><td>'.$id.'</td></tr>
					<tr><td>ime</td><td>'.$ime.'</td><td><input type="text" name="ime" value="'.$ime.'" style="width:150px"/></td></tr>
					<tr><td>mesto</td><td>'.$nazivmesta.'</td><td><select name="mesto" style="width:150px">';
					$sql='SELECT ID, naziv FROM mesta ORDER BY ID ASC';
					$result = $mysqli->query($sql) or die;
					while ($row=$result->fetch_assoc()) {
					$naziv=$row['naziv'];
					$idx=$row['ID'];
						echo '<option value="'.$idx.'" ';
						if ($idx==$mesto) echo 'selected="selected"';
						echo '>'.$naziv.'</option>';
					}
					echo '</select></td></tr><tr><td>Serija</td><td>';
					switch ($serija) {
						case 1:
							echo "Biblija uči";
							break;
						case 2:
							echo "Čudesne činjenice";
							break;
					}
					echo '</td><td><select name="serija" style="width:150px"><option value="n" ';
					if ($serija==NULL) echo 'selected="selected" ';
					echo '></option><option value="1" ';
					if ($serija==1) echo 'selected="selected" ';
					echo '>Biblija uči</option><option value="2" ';
					if ($serija==2) echo 'selected="selected" ';
					echo '>Čudesne činjenice</option></select></td>';
					$pposeta=date('Y-m-d',strtotime($pposeta));
					echo '</select></td></tr>
					<tr><td>poslednja poseta</td><td>'.$pposeta.'</td><td><input type="date" name="pposeta" value="'.$pposeta.'" style="width:150px" /></td></tr>
					<tr><td>status</td><td>';
					if ($status==1) echo 'Prijatelj';
						else echo 'Član';
					echo '</td><td><select name="status" title="Status osobe ili porodice" style="width:150px"><option value="1" ';
					if ($status==1) echo 'selected="selected" ';
					echo '>Prijatelj</option><option value="2" ';
					if ($status==2) echo 'selected="selected" ';
					echo '>Član</option></select></td></tr>';
					echo '</tbody></table><div style="width:300px;height:50px;margin-top:20px"><input type="submit" value="Izmeni" style="float:left;width:100px;height:50px" />
				<button type="button" 
        onclick="window.open(\'\', \'_self\', \'\'); window.close();"  style="float:right;width:100px;height:50px">Odustani</button></div></form>';
				break;
			case 3:
				echo '<h3 style="margin-bottom:5px">Izmene mesta u okrugu</h3>
				<form method="POST" action="edit.php?tip=1&za=3&id='.$id.'&do=1">
				<table border=1 style="font-size:12">
					<thead>
						<tr>
							<th scope="col">Polje</th>
							<th scope="col">Prošlo</th>
							<th scope="col">Novo stanje</th>
						</tr>
					</thead>
					<tbody>';
					$sql='SELECT naziv, imegore FROM mesta WHERE ID='.$id;
					$result = $mysqli->query($sql) or die;
					$row=$result->fetch_assoc();
					$naziv=$row['naziv'];
					$imegore=$row['imegore'];
					echo '<tr><td>ID</td><td>'.$id.'</td><td>'.$id.'</td></tr>
					<tr><td>Naziv</td><td>'.$naziv.'</td><td><input type="text" name="naziv" value="'.$naziv.'" style="width:150px"/></td></tr><tr><td>Gornji naziv</td><td>'.$imegore.'</td><td><input type="text" name="imegore" value="'.$imegore.'" style="width:150px"/></td></tr></tbody></table><div style="width:300px;height:50px;margin-top:20px"><input type="submit" value="Izmeni" style="float:left;width:100px;height:50px" />
				<button type="button" 
        onclick="window.open(\'\', \'_self\', \'\'); window.close();"  style="float:right;width:100px;height:50px">Odustani</button></div></form>';
				break;
			case 4:
				echo '<h3 style="margin-bottom:5px">Izmene propovedanja</h3>
				<form method="POST" action="edit.php?tip=1&za=4&id='.$id.'&do=1">
				<table border=1 style="font-size:12">
					<thead>
						<tr>
							<th scope="col">Polje</th>
							<th scope="col">Prošlo</th>
							<th scope="col">Novo stanje</th>
						</tr>
					</thead>
					<tbody>';
					$sql='SELECT propovedanja.crkva crkva, propovedanja.propoved propoved, propovedanja.datum datum, crkve.crkva nazivcrkve, propovedi.naziv nazivpropovedi FROM propovedanja LEFT JOIN crkve ON propovedanja.crkva = crkve.ID LEFT JOIN propovedi ON propovedanja.propoved = propovedi.ID WHERE propovedanja.ID='.$id;
					$result = $mysqli->query($sql) or die;
					$row=$result->fetch_assoc();
					$crkva=$row['crkva'];
					$propoved=$row['propoved'];
					$nazivcrkve=$row['nazivcrkve'];
					$nazivpropovedi=$row['nazivpropovedi'];
					$datum=$row['datum'];
					$datumx=date('d.m.Y.',strtotime($datum));
					echo '<tr><td>ID</td><td>'.$id.'</td><td>'.$id.'</td></tr>
					<tr><td>Datum</td><td>'.$datumx.'</td><td><input type="date" name="datum" value="'.$datum.'" style="width:150px" /></td></tr><tr><td>Crkva</td><td>'.$nazivcrkve.'</td><td><select name="crkva" style="width:150px">';
					$sql='SELECT ID, crkva FROM crkve ORDER BY ID ASC';
					$result = $mysqli->query($sql) or die;
					while ($row=$result->fetch_assoc()) {
					$crkva=$row['crkva'];
					$idx=$row['ID'];
						echo '<option value="'.$idx.'" ';
						if ($idx==$crkva) echo 'selected="selected"';
						echo '>'.$crkva.'</option>';
					}
					echo '</select></td></tr><tr><td>Propoved</td><td>'.$nazivpropovedi.'</td><td><select name="propoved" style="width:150px">';
					$sql='SELECT ID, naziv FROM propovedi ORDER BY ID ASC';
					$result = $mysqli->query($sql) or die;
					while ($row=$result->fetch_assoc()) {
					$naziv=$row['naziv'];
					$idx=$row['ID'];
						echo '<option value="'.$idx.'" ';
						if ($idx==$propoved) echo 'selected="selected"';
						echo '>'.$naziv.'</option>';
					}
					echo '</select></td></tr></tbody></table><div style="width:300px;height:50px;margin-top:20px"><input type="submit" value="Izmeni" style="float:left;width:100px;height:50px" />
				<button type="button" 
        onclick="window.open(\'\', \'_self\', \'\'); window.close();"  style="float:right;width:100px;height:50px">Odustani</button></div></form>';
				break;
			case 5:
				echo '<h3 style="margin-bottom:5px">Izmena propovedi</h3>
				<form method="POST" action="edit.php?tip=1&za=5&id='.$id.'&do=1">
				<table border=1 style="font-size:12">
					<thead>
						<tr>
							<th scope="col">Polje</th>
							<th scope="col">Prošlo</th>
							<th scope="col">Novo stanje</th>
						</tr>
					</thead>
					<tbody>';
					$sql='SELECT naziv FROM propovedi WHERE ID='.$id;
					$result = $mysqli->query($sql) or die;
					$row=$result->fetch_assoc();
					$naziv=$row['naziv'];
					echo '<tr><td>ID</td><td>'.$id.'</td><td>'.$id.'</td></tr>
					<tr><td>Naziv</td><td>'.$naziv.'</td><td><input type="text" name="naziv" value="'.$naziv.'" style="width:150px"/></td></tr></tbody></table><div style="width:300px;height:50px;margin-top:20px"><input type="submit" value="Izmeni" style="float:left;width:100px;height:50px" />
				<button type="button" 
        onclick="window.open(\'\', \'_self\', \'\'); window.close();"  style="float:right;width:100px;height:50px">Odustani</button></div></form>';
				break;
			case 6:
				echo '<h3 style="margin-bottom:5px">Izmena crkvi</h3>
				<form method="POST" action="edit.php?tip=1&za=6&id='.$id.'&do=1">
				<table border=1 style="font-size:12">
					<thead>
						<tr>
							<th scope="col">Polje</th>
							<th scope="col">Prošlo</th>
							<th scope="col">Novo stanje</th>
						</tr>
					</thead>
					<tbody>';
					$sql='SELECT crkva FROM crkve WHERE ID='.$id;
					$result = $mysqli->query($sql) or die;
					$row=$result->fetch_assoc();
					$crkva=$row['crkva'];
					echo '<tr><td>ID</td><td>'.$id.'</td><td>'.$id.'</td></tr>
					<tr><td>Crkva</td><td>'.$crkva.'</td><td><input type="text" name="crkva" value="'.$crkva.'" style="width:150px"/></td></tr></tbody></table><div style="width:300px;height:50px;margin-top:20px"><input type="submit" value="Izmeni" style="float:left;width:100px;height:50px" />
				<button type="button" 
        onclick="window.open(\'\', \'_self\', \'\'); window.close();"  style="float:right;width:100px;height:50px">Odustani</button></div></form>';
				break;
			}
		}
		else {
			switch ($za) {
			case 1:
				$sql='SELECT imenik.ime ime, posete.datum datum FROM imenik LEFT JOIN posete ON posete.osoba = imenik.ID WHERE posete.ID='.$id;
				$result = $mysqli->query($sql) or die;
				$row=$result->fetch_assoc();
				$datum=date('d.m.Y',(strtotime($row['datum'])));
				$info=$row['ime'].'</b> od <b>'.$datum;
				break;
			case 2:
				$sql='SELECT ime FROM imenik WHERE ID='.$id;
				$result = $mysqli->query($sql) or die;
				$row=$result->fetch_assoc();
				$info=$row['ime'];
				break;
			case 4:
				$sql='SELECT crkve.crkva crkva, propovedi.naziv propoved FROM propovedanja LEFT JOIN crkve ON propovedanja.crkva = crkve.ID LEFT JOIN propovedi ON propovedanja.propoved = propovedi.ID WHERE propovedanja.ID='.$id;
				$result = $mysqli->query($sql) or die;
				$row=$result->fetch_assoc();
				$info=$row['propoved'].'</b> u <b>'.$row['crkva'];
				break;
			case 5:
				$sql='SELECT naziv FROM propovedi WHERE ID='.$id;
				$result = $mysqli->query($sql) or die;
				$row=$result->fetch_assoc();
				$info=$row['naziv'];
				break;
			case 6:
				$sql='SELECT crkva FROM crkve WHERE ID='.$id;
				$result = $mysqli->query($sql) or die;
				$row=$result->fetch_assoc();
				$info=$row['crkva'];
				break;
			}
			echo 'Da li sigurno želiš da obrišeš unos za <b>'.$info.'</b>?
			<form method="GET" action="#">
				<input type="hidden" name="tip" value="'.$tip.'" />
				<input type="hidden" name="za" value="'.$za.'" />
				<input type="hidden" name="id" value="'.$id.'" />
				<input type="hidden" name="do" value="1" />
				<div style="width:300px;height:50px;margin-top:20px"><input type="submit" value="Briši" style="float:left;width:100px;height:50px" />
				<button type="button" 
        onclick="window.open(\'\', \'_self\', \'\'); window.close();"  style="float:right;width:100px;height:50px">Odustani</button></div>
			</form>';
		}


?>
</div>
</form>
</body>
</html>