<?php
require_once("init.php");
if (empty($_SESSION) || !isset($_GET["jegy_id"])) header("location: index.php");

template_header("Poggyász feladás");
navbar();

$p = new Poggyasz();
$poggyaszok = $p->getPoggyaszok();

if(isset($_POST["feladas"])){
    $p->poggyaszFeladas($_GET["jegy_id"], $_POST["poggyasz_id"]);
    header("location: jegy_poggyasz.php?jegy_id=". $_GET["jegy_id"]);
}

?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Poggyász feladás
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <?php if (!empty($poggyaszok)) : ?>
                <form action="poggyasz_feladas.php?jegy_id=<?php echo $_GET["jegy_id"] ?>" method="post">
                    <div class="field">
                        <label class="label">Poggyász</label>
                        <div class="control">
                            <select name="poggyasz_id" class="input">
                                <?php foreach ($poggyaszok as $p) : ?>
                                    <option value="<?php echo $p["ID"] ?>"><?php echo $p["ELNEVEZES"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <button class="button is-success" type="submit" name="feladas">Mentés</button>
                    </div>
                </form>
            <?php else : ?>
                <div>
                    <strong>Nincs rögzítve poggyász a rendszerben.</strong>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php template_footer(); ?>