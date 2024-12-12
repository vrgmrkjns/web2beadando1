<div class="hero">
  <div class="hero-slide">
    <div
      class="img overlay"
      style="background-image: url('images/pdf.png')"
      ></div>
    </div>

    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center">
          <h1 class="heading" data-aos="fade-up">
            PDF menü
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
                    <h1>PDF Generátor</h1>
                    <form action="../models/pdf_model.php" method="POST">
                        <label for="nev">Hajó név:</label>
                        <input type="text" id="nev" name="nev"><br><br>
                        
                        <label for="tipus">Hajó típus:</label>
                        <select id="tipus" name="tipus">
                            <option value="">Mind</option>
                            <option value="személyhajó">Személyhajó</option>
                            <option value="vitorlás">Vitorlás</option>
                            <option value="uszály">Uszály</option>
                        </select><br><br>
                        
                        <label for="uzemel">Üzemel:</label>
                        <select id="uzemel" name="uzemel">
                            <option value="">Mind</option>
                            <option value="1">Igen</option>
                            <option value="0">Nem</option>
                        </select><br><br>
                        
                        <button type="submit">PDF Generálás</button>
                    </form>
		            </div>
		        </div>
	      </div>
	  </div>
</div>