<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$legitarsasag = new Legitarsasag();
$repter = new Repuloter();

$repterek = $repter->getRepterek();
$legitarsasagok = $legitarsasag->getLegitarsasagok();

if (isset($_POST["new_jarat"])) {
    $response = json_decode($legitarsasag->insertRepulo($_POST["model"], $_POST["osztaly"], $_POST["max_ferohely"], $_POST["legitarsasag_id"], $_POST["indulo_repter_id"], $_POST["erkezo_repter_id"], $_POST['indulasi_datum'], $_POST["indulasi_ido"], $_POST["erkezesi_datum"], $_POST["erkezesi_ido"], $_POST["jegy_ar"]));
    if (empty($response->msg)) header("location: jaratok.php");
}
if (isset($_GET["id"])) {
    $row = $legitarsasag->getRepuloById($_GET["id"]);
    if (isset($_POST["edit_jarat"])) {
        $response = json_decode($legitarsasag->editRepulo($_POST["model"], $_POST["osztaly"], $_POST["max_ferohely"], $_POST["legitarsasag_id"], $_POST["indulo_repter_id"], $_POST["erkezo_repter_id"], $_POST['indulasi_datum'], $_POST["indulasi_ido"], $_POST["erkezesi_datum"], $_POST["erkezesi_ido"],$_POST["jegy_ar"], $_GET["id"]));
        if (empty($response->msg)) header("location: jaratok.php");
    }
}
?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Járat <?php echo (isset($_GET["id"])) ? "szerkesztése" : "hozzáadása"; ?>
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <?php if (!empty($repterek) || !empty($legitarsasagok)) : ?>
                <form action="edit_jarat.php<?php echo (isset($_GET["id"])) ? "?id=" . $_GET["id"] : ""; ?>" method="post">
                    <div class="field">
                        <label class="label">Model</label>
                        <div class="control">
                            <input class="input" placeholder="FR205" value="<?php echo (isset($row)) ? $row->MODEL : ""; ?>" type="text" name="model">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Osztály</label>
                        <div class="control">
                            <input class="input" placeholder="turista" value="<?php echo (isset($row)) ? $row->OSZTALY : ""; ?>" type="text" name="osztaly">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Jegy ár</label>
                        <div class="control">
                            <input class="input" placeholder="25000" value="<?php echo (isset($row)) ? $row->JEGY_AR : ""; ?>" type="text" name="jegy_ar">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Férőhelyek száma</label>
                        <div class="control">
                            <input class="input" placeholder="150" value="<?php echo (isset($row)) ? $row->MAX_FEROHELY : ""; ?>" type="text" name="max_ferohely">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Légitársaság</label>
                        <div class="control">
                            <select name="legitarsasag_id" id="" class="input">
                                <?php foreach($legitarsasagok as $t): ?>
                                    <option <?php echo (isset($row) && $row->LEGITARSASAG_ID == $t["ID"]) ? "selected" : ""; ?> value="<?php echo $t["ID"] ?>"><?php echo $t["NEV"] ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Induló reptér</label>
                        <div class="control">
                            <select name="indulo_repter_id" id="" class="input">
                                <?php foreach($repterek as $t): ?>
                                    <option <?php echo (isset($row) && $row->INDULO_REPULOTER_ID == $t["ID"]) ? "selected" : ""; ?> value="<?php echo $t["ID"] ?>"><?php echo $t["NEV"] ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Érkező reptér</label>
                        <div class="control">
                            <select name="erkezo_repter_id" id="" class="input">
                                <?php foreach($repterek as $t): ?>
                                    <option <?php echo (isset($row) && $row->ERKEZO_REPULOTER_ID == $t["ID"]) ? "selected" : ""; ?> value="<?php echo $t["ID"] ?>"><?php echo $t["NEV"] ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Indulási dátum</label>
                        <div class="control">
                            <input class="input"  value="<?php echo (isset($row)) ? date("Y-m-d",strtotime($row->INDULASI_DATUM)) : ""; ?>" type="date" name="indulasi_datum">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Indulási idő</label>
                        <div class="control">
                            <input class="input ido" placeholder="14:50" value="<?php echo (isset($row)) ? $row->INDULASI_IDO : ""; ?>" type="text" name="indulasi_ido">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Érkezési dátum</label>
                        <div class="control">
                            <input class="input"  value="<?php echo (isset($row)) ? date("Y-m-d",strtotime($row->ERKEZESI_DATUM)) : ""; ?>" type="date" name="erkezesi_datum">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Érkezési idő</label>
                        <div class="control">
                            <input class="input ido" placeholder="14:50" value="<?php echo (isset($row)) ? $row->ERKEZESI_IDO : ""; ?>" type="text" name="erkezesi_ido">
                        </div>
                    </div>
                    <div class="field">
                        <div><?php echo (!empty($response)) ? $response->msg : ""; ?></div>
                    </div>
                    <div class="field">
                        <button class="button is-success" type="submit" name="<?php echo (isset($_GET["id"])) ? "edit_jarat" : "new_jarat"; ?>">Mentés</button>
                    </div>
                </form>
            <?php else : ?>
                <div>Nincs a rendszerben rögzítve reptér vagy légitársaság addig nem lehetséges a járat hozzáadás!</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php template_footer(); ?>