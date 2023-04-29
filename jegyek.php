<?php
require_once("init.php");
if (empty($_SESSION) || !isset($_GET["foglalas_id"])) header("location: index.php");

template_header("Foglalási adatok");
navbar();
$f = new Jegy();
$p = new Poggyasz();
$adatok = $f->getFoglalasAdatok($_GET["foglalas_id"]);

foreach ($adatok as $key => $value) {
    $adatok[$key]["poggyaszok"] = $p->getPoggyaszByJegyId($adatok[$key]["ID"]);
    if (!empty($adatok[$key]["poggyaszok"])) {
        foreach ($adatok[$key]["poggyaszok"] as $k => $v) {
            $adatok[$key]["AR"] += $adatok[$key]["poggyaszok"][$k]["AR"];
        }
    }
}
if (isset($_GET["delete"])) {
    $f->deleteJegyAdat($_GET["delete"]);
    header("location: jegyek.php?foglalas_id=" . $_GET["foglalas_id"]);
}

if(isset($_GET["csekk"])){
    $f->csekkolas($_GET["csekk"]);
    header("location: jegyek.php?foglalas_id=" . $_GET["foglalas_id"]);
}
?>
<div class="container is-fullhd mt-5">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Foglalás adatok
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Utas vezetékneve</th>
                        <th>Utas keresztneve</th>
                        <th>Utas születési ideje</th>
                        <th>Lefoglalt ülőhely</th>
                        <th>Jegy ár</th>
                        <th>Becsekkolva</th>
                        <th>Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($adatok)) : ?>
                        <?php foreach ($adatok as $jarat) : ?>
                            <tr>
                                <td><?php echo $jarat["UTAS_VEZNEV"]; ?></td>
                                <td><?php echo $jarat["UTAS_KERNEV"]; ?></td>
                                <td><?php echo $jarat["UTAS_SZULIDO"]; ?></td>
                                <td><?php echo $jarat["ULES"]; ?></td>
                                <td><?php echo $jarat["AR"]; ?></td>
                                <td><?php echo ($jarat["BECSEKKOLAS"] == "0") ? '<i style="color: red; font-weight: bold;" class="fa-solid fa-square-xmark"></i>' : '<i style="color: green; font-weight: bold;" class="fa-solid fa-check"></i>'; ?></td>
                                <td>
                                    <a href="jegy_poggyasz.php?jegy_id=<?= $jarat["ID"] ?>" class="button is-success">Poggyászok</a>
                                    <a href="jegyek.php?foglalas_id=<?= $_GET["foglalas_id"] ?>&csekk=<?=$jarat["ID"]?>" class="button is-warning">Becsekkolás</a>
                                    <a href="jegyek.php?foglalas_id=<?= $_GET["foglalas_id"] ?>&delete=<?= $jarat["ID"] ?>" class="button is-danger">Törlés</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Nincs rögzítve járat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php template_footer(); ?>