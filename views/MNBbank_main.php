<div class="hero">
      <div class="hero-slide">
        <div
          class="img overlay"
          style="background-image: url('images/mnb.jpg')"
        ></div>
      </div>

      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-9 text-center">
            <h1 class="heading" data-aos="fade-up">
              SOAP-MNB
            </h1>
          </div>
        </div>
      </div>
    </div>

    

    <div class="section">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-lg-12">
                    <div class="mnb-div">
                    <?php
try {
    $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

    // Lekérjük a devizák listáját
    $response = $client->GetCurrencies();
    $result = simplexml_load_string($response->GetCurrenciesResult);  // A válasz átalakítása XML-be

    // Feltételezve, hogy a devizák a <Currencies> elem alatt vannak:
    $currencies = $result->Currencies->Curr;  // Hozzáférés a devizákhoz

} catch (SoapFault $e) {
    echo "Hiba történt a SOAP hívás során: " . $e->getMessage();
}
?>

<form id="exchangeRateForm">
    <label for="date">Dátum:</label>
    <input type="date" id="date" name="date" required><br><br>

    <label for="currencyFrom">Forrás deviza:</label>
    <select name="currencyFrom" id="currencyFrom" required>
        <?php foreach ($currencies as $currency): ?>
            <option value="<?= (string)$currency ?>"><?= (string)$currency ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="currencyTo">Cél deviza:</label>
    <select name="currencyTo" id="currencyTo" required>
        <?php foreach ($currencies as $currency): ?>
            <option value="<?= (string)$currency ?>"><?= (string)$currency ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit" class="btn btn-primary">Lekérdezés</button>
</form>
<br>
<br>
<div id="result"></div>  <!-- Itt jelenik meg az árfolyam eredmény -->

<script>
// AJAX használata a form elküldésére és az árfolyam megjelenítésére
document.getElementById('exchangeRateForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Megakadályozza az alapértelmezett form küldést

    const date = document.getElementById('date').value;
    const currencyFrom = document.getElementById('currencyFrom').value;
    const currencyTo = document.getElementById('currencyTo').value;

    const currencyPair = currencyFrom + ',' + currencyTo;

    fetch('../models/mnb_model.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `date=${date}&currencyPair=${currencyPair}`
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('result').innerHTML = data; // A válasz kiíratása a 'result' div-be
    })
    .catch(error => {
        console.error('Hiba történt:', error);
    });
});
</script>
</div>
