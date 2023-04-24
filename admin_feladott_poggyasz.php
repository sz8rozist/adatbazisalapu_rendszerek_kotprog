<?php
require_once("init.php");
if (empty($_SESSION) || !isset($_GET["jegy_id"])) header("location: index.php");

template_header("Poggyászok");
dashboardNavbar();

$p = new Poggyasz();
$poggyaszok = $p->getPoggyaszByJegyId($_GET["jegy_id"]);

if (isset($_GET["delete"])) {
    $p->deleteFeladottPoggyaszok($_GET["delete"]);
    header("location: admin_feladott_poggyasz.php?jegy_id=" . $_GET["jegy_id"]);
}
?>
<div class="container is-fullhd mt-5">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Poggyászok
            </h1>
        </div>
        <div class="column has-text-right">
            <a href="admin_poggyasz_feladas.php?jegy_id=<?=$_GET['jegy_id']?>" class="button is-success">Poggyász feladása</a>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>ELnevezés</th>
                        <th>Súly</th>
                        <th>Méret (kg)</th>
                        <th>Ár (Ft)</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($poggyaszok)) : ?>
                        <?php foreach ($poggyaszok as $poggyasz) : ?>
                            <tr>
                                <td><?php echo $poggyasz["ELNEVEZES"]; ?></td>
                                <td><?php echo $poggyasz["SULY"]; ?></td>
                                <td><?php echo $poggyasz["MERET"]; ?></td>
                                <td><?php echo $poggyasz["AR"]; ?></td>
                                <td>
                                    <a href="admin_feladott_poggyasz.php?jegy_id=<?= $_GET["jegy_id"] ?>&delete=<?= $poggyasz["F_ID"] ?>" class="button is-danger">Törlés</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Nincs rögzítve poggyász.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php template_footer(); ?>