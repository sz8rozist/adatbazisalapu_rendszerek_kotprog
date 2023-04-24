<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Értékelések");
navbar();
$l = new Legitarsasag();
$ltarsasag = $l->getLegitarsasagok();
$ertekelesek = $l->getErtekelesekByUserId($_SESSION["id"]);
$msg = "";
if (isset($_POST["ertekeles"])) {
    echo "<pre>" . print_r($_POST, true) . "</pre>";
    if (!isset($_POST["csillag"]) || !isset($_POST["szoveg"]) || !isset($_POST["legitarsasag_id"])) {
        $msg = "Minden mező kitöltése kötelező!";
    } else {
        $l->insertErtekeles($_POST["legitarsasag_id"], $_SESSION["id"], date("Y-m-d"), $_POST["szoveg"], $_POST["csillag"]);
        header("location: ertekeles.php");
    }
}

if (isset($_GET["delete"])) {
    $l->deleteErtekeles($_GET["delete"]);
    header("location: ertekeles.php");
}
?>
<div class="container is-fullhd mt-5">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Légitársaság értékelése
            </h1>
        </div>
    </div>
    <?php if (!empty($ltarsasag)) : ?>
        <div class="columns is-variable is-desktop">
            <div class="column">
                <form action="ertekeles.php" method="post">
                    <div class="field">
                        <label class="label">Légitársaság</label>
                        <div class="control">
                            <select name="legitarsasag_id" class="input">
                                <?php foreach ($ltarsasag as $p) : ?>
                                    <option value="<?php echo $p["ID"] ?>"><?php echo $p["NEV"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="rate">
                            <input type="radio" id="star5" name="csillag" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="csillag" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="csillag" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="csillag" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="csillag" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>
                    </div>
                    <div class="field">
                        <textarea class="textarea" name="szoveg" style="resize: none;" placeholder="Ide írd az értékelésed...."></textarea>
                    </div>
                    <div class="field">
                        <button type="submit" name="ertekeles" class="button is-success">Küldés</button>
                    </div>
                    <?php if (!empty($msg)) : ?>
                        <div class="field">
                            <strong><?php echo $msg ?></strong>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="column">
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>Légitársaság</th>
                            <th>Szöveg</th>
                            <th>Dátum</th>
                            <th>Csillag</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ertekelesek)) : ?>
                            <?php foreach ($ertekelesek as $ert) : ?>
                                <tr>
                                    <td><?php echo $ert["NEV"]; ?></td>
                                    <td><?php echo $ert["SZOVEG"]; ?></td>
                                    <td><?php echo $ert["IDOPONT"]; ?></td>
                                    <td>
                                        <?php for ($i = 1; $i <= $ert["CSILLAG"]; $i++) : ?>
                                            <i style="color: #ffc700;" class="fa-solid fa-star"></i>
                                        <?php endfor; ?>
                                        <?php if ($ert["CSILLAG"] < 5) : for($i = 1; $i <= 5 - $ert["CSILLAG"]; $i++): ?>
                                            <i class="fa-solid fa-star"></i>
                                        <?php endfor; endif; ?>
                                    </td>
                                    <td>
                                        <a href="ertekeles.php?delete=<?= $ert["ID"] ?>" class="button is-danger">Törlés</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td>Nincs rögzítve értékelés.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else : ?>
        <div>
            <strong>Nincs légitársaság rögzítve a rendszerben.</strong>
        </div>
    <?php endif; ?>
</div>



<?php template_footer(); ?>