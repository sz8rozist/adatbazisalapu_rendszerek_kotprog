<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$repter = new Repuloter();
if (isset($_POST["new_repter"])) {
    //$response = json_decode($repter->insert($_POST["nev"], $_POST["varos"], $_POST["orszag"]));
    //if(empty($response->msg)) header("location: repuloter.php");
    try {
        $conn = oci_connect("SYSTEM", "oracle", "localhost/xe");
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $stmt = oci_parse($conn, "BEGIN create_repuloter(:nev, :varos, :orszag); END;");
    oci_bind_by_name($stmt,":nev",$_POST["nev"]);
    oci_bind_by_name($stmt,":varos",$_POST["varos"]);
    oci_bind_by_name($stmt,":orszag",$_POST["orszag"]);
    if(oci_execute($stmt)){
        header("location: repuloter.php");
    }
}
if (isset($_GET["id"])) {
    $row = $repter->getRepterById($_GET["id"]);

    if (isset($_POST["edit_repter"])) {
        $response = json_decode($repter->update($_GET["id"], $_POST["nev"], $_POST["varos"], $_POST["orszag"]));
        if (empty($response->msg)) header("location: repuloter.php");
    }
}
?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Repülőtér <?php echo (isset($_GET["id"])) ? "szerkesztése" : "hozzáadása"; ?>
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <form action="edit_repter.php<?php echo (isset($_GET["id"])) ? "?id=" . $_GET["id"] : ""; ?>" method="post">
                <div class="field">
                    <label class="label">Név</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->NEV : ""; ?>" type="text" name="nev">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Város</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->VAROS : ""; ?>" type="text" name="varos">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Ország</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->ORSZAG : ""; ?>" type="text" name="orszag">
                    </div>
                </div>
                <div class="field">
                    <div><?php echo (!empty($response)) ? $response->msg : ""; ?></div>
                </div>
                <div class="field">
                    <button class="button is-success" type="submit" name="<?php echo (isset($_GET["id"])) ? "edit_repter" : "new_repter"; ?>">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php template_footer(); ?>