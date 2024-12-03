<div class="container">
    <div class="belepes-div align-middle">
        <form action="/beregiszt" method="POST" >
            <div class="form-group">
                <label for="fhnev">Felhasználó név</label>
                <input type="text" class="form-control" name="fhn" id="fhn" placeholder="Felhasználónév">
            </div>
            <div class="form-group">
                <label for="jlsz">Jelszó</label>
                <input type="password" class="form-control" name="jlsz" id="jlsz" placeholder="Jelszó">
            </div>
            <div class="form-group">
                <label for="jlszu">Jelszó újra</label>
                <input type="password" class="form-control" name="jlszu" id="jlszu" placeholder="Jelszó újra">
            </div>
            <div class="form-group form-check"></div>
            <div class="gomb-div">
                <button type="submit" class="btn btn-primary">Regisztráció</button><br><br><br><br>
                <p>Van már fiókod?</p>
                <a href="/belepes" class="btn btn-warning ">Bejelentkezés</a>
            </div>
        </form>
    </div>
</div>