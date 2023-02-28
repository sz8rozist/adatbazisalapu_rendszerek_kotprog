<?php
require_once("init.php");

if(isset($_POST["checkout"])){
    $booking = array();
    foreach ($_POST["utas_veznev"] as $key => $veznev) {
        array_push($booking, array("utas_veznev" => $veznev, "utas_kernev" => $_POST["utas_kernev"][$key], "utas_szulido" => $_POST["utas_szulido"][$key], "ules" => json_decode($_POST["ulohelyek"])[$key]));
    }
    var_dump($booking);
}

template_header("Járat keresés");
navbar();
?>
<div class="container section">
    <form action="booking.php?repulo=<?= $_GET['repulo'] ?>&max_ferohely=<?=$_GET['max_ferohely']?>&szemely_szam=<?=$_GET['szemely_szam']?>&ar=<?=$_GET["ar"]?>" method="post">
        <div class="columns">
            <div class="column is-8">
                <?php for ($i = 1; $i <= $_GET["szemely_szam"]; $i++) : ?>
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
                <nav class="panel">
                        <p class="panel-heading">
                            Fizetés mód
                        </p>
                        <div class="section">
                            <div class="field">
                                <div class="control">
                                    <input class="input" placeholder="Fizetési mód" type="text" name="fizetesi_mod">
                                </div>

                            </div>
                            
                        </div>
                    </nav>
            </div>
            <div class="column is-4">
                <nav class="panel">
                    <p class="panel-heading">Ülőhely kiválasztás</p>
                    <div class="seat_container" id="<?= $_GET["szemely_szam"] ?>">
                        <div class="seat_row">
                            <?php
                            for ($i = 1; $i <= $_GET["max_ferohely"]; $i++) {
                                if ($i % 6 == 0) {
                                    echo "<div class='seat' id=" . $i . "><i class='fa-solid fa-chair'></i></div></div><div class='seat_row'>";
                                } else {
                                    if ($i % 3 == 0) {
                                        echo "<div class='seat_kozep'></div>";
                                    }
                                    echo "<div class='seat' id=" . $i . "><i class='fa-solid fa-chair'></i></div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </nav>
                <input type="hidden" name="ulohelyek" id="ulohely_input" value="">
                <button type="submit" name="checkout" class="button is-info is-fullwidth">Foglalás</button>
            </div>
        </div>
    </form>
</div>
<?php
template_footer();
?>