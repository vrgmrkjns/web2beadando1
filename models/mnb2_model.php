<?php
// Ha a form be van küldve, feldolgozzuk a lekérdezést
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['month'], $_POST['year'], $_POST['currencyPair'])) {
        $month = $_POST['month'];
        $year = $_POST['year'];
        $currencyPair = $_POST['currencyPair'];

        try {
            $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

            // Lekérjük az árfolyamokat a kiválasztott hónapra
            $startDate = "$year-$month-01";
            $endDate = date("Y-m-t", strtotime($startDate)); // A hónap utolsó napja

            $response = $client->GetExchangeRates([
                'startDate' => $startDate,
                'endDate' => $endDate,
                'currencyNames' => $currencyPair
            ]);

            $xmlResult = simplexml_load_string($response->GetExchangeRatesResult);

            // Adatok feldolgozása
            $rates = [];
            foreach ($xmlResult->Day as $day) {
                $rates[] = [
                    'date' => (string)$day->Date,
                    'rate' => (float)$day->Rate
                ];
            }

            // JSON válasz visszaadása a grafikonhoz
            echo json_encode($rates);
        } catch (SoapFault $e) {
            echo "Hiba történt a SOAP hívás során: " . $e->getMessage();
        }
    }
}
?>
