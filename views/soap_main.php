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
                <h1>Kapcsolt adatok</h1>
    <table>
        <tr>
            <?php foreach (array_keys($data[0]) as $key): ?>
                <th><?= htmlspecialchars($key) ?></th>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td><?= htmlspecialchars($cell) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
                </div>
            </div>
        </div>
    </div>
</div>