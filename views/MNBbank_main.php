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
    <label for="month">Hónap, havi árfolyamhoz:</label>
    <input type="month" id="month" name="month" required><br><br>

    <label for="date">Dátum napi árfolyamhoz:</label>
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

    <input type="hidden" name="currencyPair" id="currencyPair">

    <button type="submit" class="btn btn-primary">Lekérdezés</button>
</form>
<br>
<br>
<div id="result"></div>  <!-- Itt jelenik meg az árfolyam eredmény -->

<script>
function updateCurrencyPair() {
    const from = document.getElementById('currencyFrom').value;
    const to = document.getElementById('currencyTo').value;
    const currencyPair = `${from},${to}`;

    // Beállítjuk a hidden input értékét
    document.getElementById('currencyPair').value = currencyPair;
}

// Eseményfigyelők hozzáadása a select mezőkhöz
document.getElementById('currencyFrom').addEventListener('change', updateCurrencyPair);
document.getElementById('currencyTo').addEventListener('change', updateCurrencyPair);

// Inicializálás, hogy már a kezdő értékekkel beállítsuk a hidden input értékét
updateCurrencyPair();


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

//hónap
document.getElementById('exchangeRateForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Megakadályozza az alapértelmezett form elküldést

    const month = document.getElementById('month').value;
    const currencyPair = document.getElementById('currencyPair').value;
    console.log(currencyPair);

    // Formátum: YYYY-MM
    const [year, monthOnly] = month.split("-");

    let chart;

    fetch('../models/mnb2_model.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `month=${monthOnly}&year=${year}&currencyPair=${currencyPair}`
    })
    .then(response => response.json())
    .then(data => {
        console.log('Kapott adat:', data);
        if (data.error) {
            alert(data.error); // Hibák megjelenítése a felhasználónak
            return;
        }


        // Táblázat feltöltése
        const tableBody = document.querySelector('#rateTable tbody');
        tableBody.innerHTML = '';
        data.forEach(item => {
            const row = document.createElement('tr');
            const dateCell = document.createElement('td');
            const rateCell = document.createElement('td');
            dateCell.textContent = item.date;
            rateCell.textContent = item.rate.toFixed(2);
            row.appendChild(dateCell);
            row.appendChild(rateCell);
            tableBody.appendChild(row);
        });

        // Grafikon frissítése
        const labels = data.map(item => item.date);
        const rates = data.map(item => item.rate);

        const ctx = document.getElementById('exchangeRateChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Árfolyam',
                    data: rates,
                    borderColor: 'rgb(3, 255, 217)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Hiba történt:', error);
    });
});

</script>
<br>
<br>
<br>
<canvas id="exchangeRateChart" style="width: 700px; height: 200px"></canvas>
<br>
<br>
    <table style="width: 300px; margin: auto;" class="table table-striped" id="rateTable" border="1">
        <thead>
            <tr>
                <th class="col">Dátum</th>
                <th class="col">Árfolyam</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
