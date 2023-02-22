<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$legitarsasag = new Legitarsasag();
$jaratok = $legitarsasag->getJaratok();

if(isset($_GET["delete"])){
    $legitarsasag->deleteRepulo($_GET["delete"]);
    header("location: jaratok.php");
}

?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Járatok
            </h1>
        </div>
        <div class="column has-text-right">
            <a href="edit_jarat.php" class="button is-success">Új járat</a>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Légitársaság</th>
                        <th>Induló reptér</th>
                        <th>Érkező reptér</th>
                        <th>Indulási idő</th>
                        <th>Érkezési idő</th>
                        <th>Model</th>
                        <th>Osztály</th>
                        <th>Férőhelyek száma</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jaratok)) : ?>
                        <?php foreach ($jaratok as $jarat) : ?>
                            <tr>
                                <td><img src="<?php echo (isset($row) && !is_null($row->IMG)) ? "uploads/". $jarat["LOGO"] : "img/missing_image.png" ?>?>" width="30" alt="logo" title="A légitársaság logoja"></td>
                                <td><?php echo $jarat["LEGITARSASAG"]; ?></td>
                                <td><?php echo $jarat["INDULO_REPTER"]; ?></td>
                                <td><?php echo $jarat["ERKEZO_REPTER"]; ?></td>
                                <td><?php echo $jarat["INDULASI_DATUM"] . " " . $jarat["INDULASI_IDO"] ?></td>
                                <td><?php echo $jarat["ERKEZESI_DATUM"] . " " . $jarat["ERKEZESI_IDO"] ?></td>
                                <td><?php echo $jarat["MODEL"] ?></td>
                                <td><?php echo $jarat["OSZTALY"] ?></td>
                                <td><?php echo $jarat["MAX_FEROHELY"] ?></td>
                                <td>
                                    <a href="edit_jarat.php?id=<?= $jarat["ID"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="jaratok.php?delete=<?= $jarat["ID"] ?>"><i class="fa-solid fa-trash-arrow-up"></i></a>
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