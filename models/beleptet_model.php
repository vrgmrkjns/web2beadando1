<?php
class Beleptet_Model
{
	public function get_data($vars)
	{
		$retData['eredmeny'] = "";
		try {
			$connection = Database::getConnection();
			$sql = "SELECT * FROM felhasznalok WHERE fhn='".$vars['fhn']."' and jlsz='".sha1($vars['jlsz'])."'";
			//$sql = "SELECT * FROM felhasznalok WHERE fhn='teszt' and jlsz='teszt'";
			$stmt = $connection->query($sql);
			$felhasznalo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			switch(count($felhasznalo)) {
				case 0:
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Helytelen felhasználói név-jelszó pár!";
					break;
				case 1:
					$retData['eredmény'] = "OK";
					$retData['uzenet'] = "Üdv, ".$felhasznalo[0]['fhn']."!";
					$_SESSION['userid'] =  $felhasznalo[0]['id'];
					$_SESSION['fhnev'] =  $felhasznalo[0]['fhn'];
					$_SESSION['userlevel'] = $felhasznalo[0]['priv'];
					Menu::setMenu();
					break;
				default:
					$retData['eredmény'] = "ERROR";
					$retData['uzenet'] = "Több felhasználót találtunk a megadott felhasználói név -jelszó párral!";
			}
		}
		catch (PDOException $e) {
					$retData['eredmény'] = "ERROR";
					$retData['uzenet'] = "Adatbázis hiba: ".$e->getMessage()."!";
		}
		return $retData;
	}
}
?>