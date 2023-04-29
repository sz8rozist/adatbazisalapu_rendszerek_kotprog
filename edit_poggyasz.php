<?php
error_reporting(E_ALL & ~E_WARNING);
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$p = new Poggyasz();
$db = new Db();
try {
    $conn = oci_connect("SYSTEM", "oracle", "localhost/xe");
} catch (Exception $e) {
    echo $e->getMessage();
}
$err = "";
if (isset($_POST["new_poggyasz"])) {
    if (empty($_POST["elnevezes"]) || empty($_POST["suly"]) || empty($_POST["ar"]) || empty($_POST["meret"])) {
        $err = "Minden mező kitöltése kötelező!";
    } else {
        //$response = json_decode($p->insert($_POST["elnevezes"], $_POST["suly"], $_POST["meret"], $_POST["ar"]));
        // if(empty($response->msg)) header("location: poggyasz.php");
        if (!is_numeric($_POST["ar"])) {
            $err = "Az árnak számnak kell lennie!";
        } else {
            $stmt = oci_parse($conn, "INSERT INTO poggyasz(elnevezes, suly, ar, meret) VALUES(:elnevezes, :suly, :ar, :meret)");
            oci_bind_by_name($stmt, ":elnevezes", $_POST["elnevezes"]);
            oci_bind_by_name($stmt, ":suly", $_POST["suly"]);
            oci_bind_by_name($stmt, ":ar", $_POST["ar"]);
            oci_bind_by_name($stmt, ":meret", $_POST["meret"]);
            if (oci_execute($stmt)) {
                header("location: repuloter.php");
            } else {
                $error = oci_error($stmt);
                $errorMessage = $error["message"];
                $errorMessageParts = explode("ORA-", $errorMessage);
                $err = $errorMessageParts[1];
            }
        }
    }
}
if (isset($_GET["id"])) {
    $row = $p->getPoggyaszById($_GET["id"]);

    if (isset($_POST["edit_poggyasz"])) {
        // $response = json_decode($p->update($_GET["id"], $_POST["elnevezes"], $_POST["suly"], $_POST["meret"], $_POST["ar"]));
        // if(empty($response->msg)) header("location: poggyasz.php");
    }
}

$err = explode(":", $err);
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
                    <div><?php echo (!empty($err) && isset($err[1])) ? $err[1] : ""; ?></div>
                </div>
                <div class="field">
                    <button class="button is-success" type="submit" name="<?php echo (isset($_GET["id"])) ? "edit_poggyasz" : "new_poggyasz"; ?>">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php template_footer(); ?>