<?php
require_once '../includes/database.inc.php';

$dbh = Database::getConnection();

$sql = "SELECT * FROM hajo";
$sth = $dbh->query($sql);
$rows = $sth->fetchAll(PDO::FETCH_ASSOC);

require_once('../tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8',
false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Web-programozás II');
$pdf->SetTitle('FELHASZNÁLÓK');
$pdf->SetSubject('Web-programozás II - 3. Labor - TCPDF');
$pdf->SetKeywords('TCPDF, PDF, Web-programozás II, Labor3');

$html = '
<html>
<head>
<style>
table {border-collapse: collapse;}
th {font-weight: border: 1px solid red; text-align: center;}
td {border: 1px solid blue;}
</style>
</head>
<body>
<h1 style="text-align: center; color: blue;">FELHASZNÁLÓK</h1>
<table>
<tr style="background-color: red; color: white;">
<th style="width: 5%;">&nbsp;<br>&nbsp;<br>&nbsp;</th>
<th style="width: 20%;">&nbsp;<br>CSALÁDI NÉV</th>
<th style="width: 20%;">&nbsp;<br>UTÓNÉV</th>
<th style="width: 20%;">&nbsp;<br>BEJELENTKEZÉS</th>
<th style="width: 35%;">&nbsp;<br>JELSZÓ</th>
</tr>
';
$i=1;
foreach($rows as $row) {
if($i)
$html .= '
<tr style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 255);">
';
else
$html .= '
<tr style="background-color: rgb(0, 0, 255); color: rgb(255, 255, 255);">
';
$j=0;
foreach($row as $cell) {
if($j==0)
$html .= '
<td style="text-align: right; width: 5%;">
';
else if($j < 4)
$html .= '
<td style="text-align: left; width: 20%;">
';
else if($j == 4)
$html .= '
<td style="text-align: left; width: 35%;">
';
$html .= $cell;
$html .= '
</td>
';
$j++;
}
$html .= '
</tr>
';
$i = !$i;
}
$html .= '
</table>
<body>
</html>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('labor3-1.pdf', 'I');
?>
