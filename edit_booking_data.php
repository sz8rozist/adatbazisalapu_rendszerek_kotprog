<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");
if (!isset($_GET["jegy_id"]) && !isset($_GET["jegy_adatok_id"])) header("location: all_booking.php");
template_header("Vezérlőpult");
dashboardNavbar();

//TODO: Ülőhely szerkesztése / hozzáadás

$jegy = new Jegy();
if(isset($_GET["jegy_adatok_id"])){
    $row = $jegy->getJegyAdatok($_GET["jegy_adatok_id"]);
}
if(isset($_POST["edit_foglalas_data"])){
    $response = json_decode($jegy->updateJegy_adatok($_GET["jegy_adatok_id"], $_POST["utas_veznev"], $_POST["utas_kernev"], $_POST["utas_szulido"], $_POST["becsekkolas"]));
    if(empty($response->msg)) header("location: foglalas_adatok.php?jegy_id=".$_GET["jegy_id"]);
}
if(isset($_POST["new_foglalas_data"])){
    $response = json_decode($jegy->insertJegyAdatok($_GET["jegy_id"], $_POST["utas_veznev"], $_POST["utas_kernev"], $_POST["utas_szulido"], $_POST["becsekkolas"],$_POST["ar"]));
    if(empty($response->msg)) header("location: foglalas_adatok.php?jegy_id=".$_GET["jegy_id"]);
}

?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Foglalás adatok <?php echo (isset($_GET["jegy_adatok_id"])) ? "szerkesztése" : "hozzáadása"; ?>
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <form action="edit_booking_data.php?jegy_id=<?php echo $_GET["jegy_id"];
                                                        echo (isset($_GET["jegy_adatok_id"])) ? "&jegy_adatok_id=" . $_GET["jegy_adatok_id"] : "" ?>" method="post">
                <div class="field">
                    <label class="label">Utas vezetéknév</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->UTAS_VEZNEV : ""; ?>" type="text" name="utas_veznev">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Utas keresztnév</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->UTAS_KERNEV : ""; ?>" type="text" name="utas_kernev">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Utas születési idő</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? date("Y-m-d",strtotime($row->UTAS_SZULIDO)) : ""; ?>" type="date" name="utas_szulido">
                    </div>
                </div>
                <?php if(!isset($row)): ?>
                <div class="field">
                    <label class="label">Jegy ár</label>
                    <div class="control">
                        <input class="input" readonly value="<?php echo $jegy->getJegyAr($_GET["jegy_id"]) ?>" type="text" name="ar">
                    </div>
                </div>
                <?php endif; ?>
                <div class="field">
                    <label class="label">Becsekkolva</label>
                    <div class="control">
                        <?php $options = array("0" => "Nem", "1" => "Igen"); ?>
                        <select class="input" name="becsekkolas" id="">
                            <?php foreach ($options as $key => $val) : ?>
                                <option <?php echo (isset($row) && $key == $row->BECSEKKOLAS) ? "selected" : "" ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <div><?php echo (!empty($response)) ? $response->msg : ""; ?></div>
                </div>
                <div class="field">
                    <button class="button is-success" type="submit" name="<?php echo (isset($_GET["jegy_adatok_id"])) ? "edit_foglalas_data" : "new_foglalas_data"; ?>">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php template_footer(); ?>