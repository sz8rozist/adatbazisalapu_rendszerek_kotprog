<?php
require_once("init.php");

if(isset($_POST["jarat_search"])){
    $jarat = new Jarat();
    $jaratok = $jarat->getJaratok();
}else{
    header("location: index.php");
}
template_header("Járat keresés");
navbar();
searchBox();
?>
<div class="container section">
    <?php foreach($jaratok as $jarat): ?>
    <div class="card">
        <div class="columns">
            <div class="column is-four-fifths">
                <div class="flight">
                    <div class="badge"><?=$jarat["DATUM"]?></div>
                    <span class="airline-brand">LOGO</span>
                    <div class="flight-inner">
                        <div class="flight-from">
                            <div class="time"><?=$jarat["INDULASI_IDO"]?></div>
                            <div class="city"><?= $jarat["HONNAN"]?></div>
                            <div class="airport">Liszt Ferenc Repülőtér</div>
                        </div>
                        <div class="short-info"><span>2ó 40p</span><i class="fa-solid fa-plane-departure"></i></div>
                        <div class="flight-to">
                            <div class="time"><?=$jarat["ERKEZESI_IDO"]?></div>
                            <div class="city"><?= $jarat["HOVA"]?></div>
                            <div class="airport">Liszt Ferenc Repülőtér</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column booking_column">
                <div class="booking">
                    <div class="price">
                        <div class="price_title">Teljes ár</div>
                        1 Felnőtt részére:
                        <div class="osszeg">
                            <?=$jarat["AR"]?> Ft
                        </div>
                        <div class="booking_btn">
                            <button class="button is-info"
                                <?php echo (!isset($_SESSION['login'])) ? "disabled" : "" ?>>Foglalás</button>
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