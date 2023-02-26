<?php
require_once("init.php");

if (isset($_POST["jarat_search"])) {
    $j = new Legitarsasag();
    $search = array("indulo_repuloter_id" => $_POST["indulasi_repuloter_id"], "erkezo_repuloter_id" => $_POST["erkezesi_repuloter_id"], "indulasi_datum" => $_POST["indulasi_datum"], "erkezesi_datum" => (isset($_POST["erkezesi_datum"])) ? $_POST["erkezesi_datum"] : NULL, "szemely_szam" => $_POST["szemely_szam"], "osztaly" => $_POST["osztaly"]);
    $jaratok = $j->getJaratok($search);
} else {
    header("location: index.php");
}
template_header("Járat keresés");
navbar();
searchBox();
?>
<div class="container section">
    <?php foreach ($jaratok as $jarat) :
        $r = new Repuloter();
        $indulo_repter = $r->getJaratVarosByRepterId($jarat["INDULO_REPULOTER_ID"]);
        $erkezo_repter = $r->getJaratVarosByRepterId($jarat["ERKEZO_REPULOTER_ID"]);
    ?>
        <div class="card">
            <div class="columns">
                <div class="column is-four-fifths">
                    <div class="flight">
                        <div class="badge"><?= $jarat["INDULASI_DATUM"] ?></div>
                        <span class="airline-brand"><img width="50" style="margin-left: 15px" src="<?php echo (!is_null($jarat["LOGO"])) ? "uploads/" . $jarat["LOGO"] : "img/missing_logo.png"; ?>"></span>
                        <div class="flight-inner">
                            <div class="flight-from">
                                <div class="time"><?= $jarat["INDULASI_IDO"] ?></div>
                                <div class="city">
                                    <?php echo $indulo_repter->VAROS; ?>
                                </div>
                                <div class="airport"><?= $jarat["INDULO_REPTER"] ?></div>
                            </div>
                            <div class="short-info"><span>2ó 40p</span><i class="fa-solid fa-plane-departure"></i></div>
                            <div class="flight-to">
                                <div class="time"><?= $jarat["ERKEZESI_IDO"] ?></div>
                                <div class="city"><?php echo $erkezo_repter->VAROS; ?></div>
                                <div class="airport"><?= $jarat["ERKEZO_REPTER"] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column booking_column">
                    <div class="booking">
                        <div class="price">
                            <div class="price_title">Teljes ár</div>
                            <?php echo $_POST["szemely_szam"] ?> Ember részére:
                            <div class="osszeg">
                                <?= $jarat["JEGY_AR"] * $_POST["szemely_szam"] ?> Ft
                            </div>
                            <div class="booking_btn">
                                <form action="booking.php" method="post">
                                    <input type="hidden" name="repulogep_id" , value="<?php echo $jarat['ID'] ?>">
                                    <input type="hidden" name="max_ferohely" value="<?php echo $jarat['MAX_FEROHELY'] ?>">
                                    <input type="hidden" name="szemely_szam" value="<?php echo $_POST["szemely_szam"] ?>">
                                    <input type="hidden" name="ar" value="<?php echo $jarat["JEGY_AR"] ?>">
                                    <button type="submit" name="booking" class="button is-info" <?php echo (!isset($_SESSION['login'])) ? "disabled" : "" ?>>Foglalás</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
template_footer();
?>