<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Foglalások");
navbar();
$f = new Jegy();
$foglalasok = $f->getFoglalasokByUserId($_SESSION["id"]);

if(isset($_GET["delete"])){
    $f->deleteJegy($_GET["delete"]);
    header("location: foglalasaim.php");
}
?>
<div class="container is-fullhd mt-5">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Foglalásaim
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Légitársaság</th>
                        <th>Induló reptér</th>
                        <th>Érkező reptér</th>
                        <th>Indulási idő</th>
                        <th>Érkezési idő</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($foglalasok)) : ?>
                        <?php foreach ($foglalasok as $jarat) : ?>
                            <tr>
                                <td><?php echo $jarat["LEGITARSASAG"]; ?></td>
                                <td><?php echo $jarat["INDULASI_REPTER"]; ?></td>
                                <td><?php echo $jarat["ERKEZO_REPTER"]; ?></td>
                                <td><?php echo $jarat["INDULASI_DATUM"] . " " . $jarat["INDULASI_IDO"] ?></td>
                                <td><?php echo $jarat["ERKEZESI_DATUM"] . " " . $jarat["ERKEZESI_IDO"] ?></td>
                                <td>
                                    <a href="jegyek.php?foglalas_id=<?= $jarat["ID"] ?>" class="button is-success">Jegy adatok</a>
                                    <a href="foglalasaim.php?delete=<?= $jarat["ID"] ?>" class="button is-danger">Törlés</a>
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