<?php
require_once("init.php");

if (isset($_POST["booking"])) {
} else {
    header("location: index.php");
}
template_header("Járat keresés");
navbar();
?>
<div class="container section">
    <form action="booking_checkout.php" method="post">
        <div class="columns">
            <div class="column is-8">
                <?php for ($i = 1; $i <= $_POST["szemely_szam"]; $i++) : ?>
                    <nav class="panel">
                        <p class="panel-heading">
                            <?php echo $i . ". utas adatai"; ?>
                        </p>
                        <div class="section">
                            <div class="field">
                                <div class="control">
                                    <input class="input" placeholder="Vezetéknév" type="text" name="utas_veznev[]">
                                </div>

                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" placeholder="Keresztnév" type="text" name="utas_kernev[]">
                                </div>

                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Születési idő (1999-02-02)" name="utas_szulido[]">
                                </div>
                            </div>
                        </div>
                    </nav>
                <?php endfor; ?>
            </div>
            <div class="column is-4">
                <!--<nav class="panel">
                    <p class="panel-heading">
                        Összegzés
                    </p>
                    <?php for ($i = 1; $i <= $_POST["szemely_szam"]; $i++) : ?>
                        <p class="panel-block">
                            <span class="panel-icon">
                                <i class="fa-solid fa-ticket"></i>
                            </span>
                            <?php echo $i . " - " . $_POST["ar"]; ?> Ft
                        </p>
                    <?php endfor; ?>
                    <p class="panel-block">
                        <span class="panel-icon"><i class="fa-solid fa-money-check"></i></span>
                        Összesen: <?php echo $_POST["szemely_szam"] * $_POST["ar"]; ?> Ft
                    </p>
                    <div class="panel-block">
                        <input type="hidden" name="szemely_szam" value="<?php echo $_POST["szemely_szam"] ?>">
                        <input type="hidden" name="repulogep_id" , value="<?php echo $_POST['repulogep_id'] ?>">
                        <input type="hidden" name="ar" value="<?php echo $_POST["ar"] ?>">
                        <input type="hidden" name="max_ferohely" value="<?php echo $_POST["max_ferohely"] ?>">
                        <button type="submit" name="choose_ulohely" class="button is-info is-outlined is-fullwidth">
                            Ülőhely kiválasztás
                        </button>
                    </div>
                </nav>-->

                <nav class="panel">
                    <p class="panel-heading">Ülőhely kiválasztás</p>
                    <div class="seat_container">
                        <div class="seat_row">
                            <?php
                            for ($i = 1; $i <= $_POST["max_ferohely"]; $i++) {
                                if ($i % 6 == 0) {
                                    echo "<div class='seat' id=".$_POST["szemely_szam"]." onclick='chooseSeat(this)'><i class='fa-solid fa-chair'></i></div></div><div class='seat_row'>";
                                } else {
                                    if($i % 3 == 0){
                                        echo "<div class='seat_kozep'></div>";
                                    }
                                    echo "<div class='seat' id=".$_POST["szemely_szam"]." onclick='chooseSeat(this)'><i class='fa-solid fa-chair'></i></div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </nav>
            </div>

        </div>
    </form>
</div>

<?php
template_footer();
?>