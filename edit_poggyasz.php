<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$p = new Poggyasz();
$db = new Db();
if(isset($_POST["new_poggyasz"])){
    $response = json_decode($p->insert($_POST["elnevezes"], $_POST["suly"], $_POST["meret"], $_POST["ar"]));
    if(empty($response->msg)) header("location: poggyasz.php");
    
}
if(isset($_GET["id"])){
    $row = $p->getPoggyaszById($_GET["id"]);

    if(isset($_POST["edit_poggyasz"])){
        $response = json_decode($p->update($_GET["id"], $_POST["elnevezes"], $_POST["suly"], $_POST["meret"], $_POST["ar"]));
        if(empty($response->msg)) header("location: poggyasz.php");
    }
}
?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Poggyász <?php echo (isset($_GET["id"])) ? "szerkesztése" : "hozzáadása"; ?>
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <form action="edit_poggyasz.php<?php echo (isset($_GET["id"])) ? "?id=" . $_GET["id"] : ""; ?>" method="post">
                <div class="field">
                    <label class="label">Elnevezés</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->ELNEVEZES : ""; ?>" type="text" name="elnevezes">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Súly</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->SULY : ""; ?>" type="text" name="suly">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Méret</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->MERET : ""; ?>" type="text" name="meret">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Ár</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->AR : ""; ?>" type="text" name="ar">
                    </div>
                </div>
                <div class="field">
                    <div><?php echo (!empty($response)) ? $response->msg : ""; ?></div>
                </div>
                <div class="field">
                    <button class="button is-success" type="submit" name="<?php echo (isset($_GET["id"])) ? "edit_poggyasz" : "new_poggyasz"; ?>">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php template_footer(); ?>