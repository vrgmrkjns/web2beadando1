<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['date']) && isset($_POST['currencyPair'])) {
        $date = $_POST['date'];
        $currencyPair = $_POST['currencyPair'];

        try {
            $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

            // Lekérdezzük az árfolyamokat
            $response = $client->GetExchangeRates([
                'startDate' => $date,
                'endDate' => $date,
                'currencyNames' => $currencyPair
            ]);

            $xmlResult = simplexml_load_string($response->GetExchangeRatesResult);

            // Az árfolyam megjelenítése
            if (isset($xmlResult->Day->Rate)) {
                echo "<h4>Az árfolyam $currencyPair $date dátumra: " . $xmlResult->Day->Rate . " HUF</h4>";
            } else {
                echo "<h4>Nincs elérhető adat a megadott dátumra és devizapárra.</h4>";
            }

        } catch (SoapFault $e) {
            echo "Hiba történt a SOAP hívás során: " . $e->getMessage();
        }
    }
}
?>
