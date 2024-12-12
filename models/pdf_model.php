<?php
require_once '../includes/database.inc.php';

$dbh = Database::getConnection();
// Form adatok megszerzése
$nev = isset($_POST['nev']) ? $_POST['nev'] : '';
$tipus = isset($_POST['tipus']) ? $_POST['tipus'] : '';
$uzemel = isset($_POST['uzemel']) ? $_POST['uzemel'] : '';

// SQL lekérdezés kezdete
$sql = "SELECT hajo.az, hajo.nev AS hajnev, hajo.tipus, tulajdonos.nev AS tulnev, 
        CASE WHEN hajo.uzemel = 1 THEN 'Igen' 
             WHEN hajo.uzemel = 0 THEN 'Nem' 
             ELSE 'Ismeretlen' END AS uzemel,
        GROUP_CONCAT(tort.nev ORDER BY tort.nev SEPARATOR ', ') AS tortnev
        FROM hajo
        INNER JOIN tulajdonos ON tulajdonos.az = hajo.tulaz
        LEFT JOIN tort ON hajo.az = tort.hajoaz";

// Dinamikus szűrés hozzáadása az SQL-hez
$conditions = [];
if (!empty($nev)) {
    $conditions[] = "hajo.nev LIKE :nev";
}
if (!empty($tipus)) {
    $conditions[] = "hajo.tipus = :tipus";
}
if ($uzemel !== '') {
    $conditions[] = "hajo.uzemel = :uzemel";
}

// Ha van szűrő, hozzáadjuk őket a WHERE részhez
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Csoportosítás
$sql .= " GROUP BY hajo.az, hajo.nev, hajo.tipus, tulajdonos.nev, tulajdonos.varos";

// Adatbázis kapcsolat és lekérdezés
try {
    $pdo = Database::getConnection();
    $sth = $pdo->prepare($sql);
    
    // Paraméterek kötése
    if (!empty($nev)) {
        $sth->bindValue(':nev', "%" . $nev . "%");
    }
    if (!empty($tipus)) {
        $sth->bindValue(':tipus', $tipus);
    }
    if ($uzemel !== '') {
        $sth->bindValue(':uzemel', $uzemel);
    }
    
    // Lekérdezés futtatása
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Hiba történt: " . $e->getMessage();
}

require_once('../tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8',
false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Web-programozás II');
$pdf->SetTitle('Hajók');
$pdf->SetSubject('Web-programozás II - Beadandó - TCPDF');
$pdf->SetKeywords('TCPDF, PDF, Web-programozás II, Beadandó');

$pdf->AddPage();


$html = '
<html>
<head>
<style>
table {border-collapse: collapse; width: 100%;}
th {font-weight: bold; border: 1px solid red; text-align: center; padding: 8px;}
td {border: 1px solid blue; text-align: center; padding: 8px;}
</style>
</head>
<body>
<h1 style="text-align: center; color: blue;">Hajók</h1>
<table>
<tr style="background-color: red; color: white;">
<th style="width: 5%;">&nbsp;</th>
<th style="width: 20%;">NÉV</th>
<th style="width: 20%;">TÍPUS</th>
<th style="width: 20%;">TULAJ</th>
<th style="width: 15%;">ÜZEMEL?</th>
<th style="width: 15%;">RÉGI NÉV</th>
</tr>
';

$i = 1;
foreach ($rows as $row) {
    $html .= $i ? '<tr style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 255);">' : 
                  '<tr style="background-color: rgb(0, 0, 255); color: rgb(255, 255, 255);">';

    $j = 0;
    foreach ($row as $cell) {
        if ($j == 0) {
            $html .= '<td style="text-align: right; width: 5%;">';
        } else if ($j < 4) {
            $html .= '<td style="text-align: left; width: 20%;">';
        } else {
            $html .= '<td style="text-align: left; width: 15%;">';
        }

        $html .= $cell;
        $html .= '</td>';
        $j++;
    }
    $html .= '</tr>';
    $i = !$i;
}

$html .= '</table>
</body>
</html>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('labor3-1.pdf', 'I');
?>
