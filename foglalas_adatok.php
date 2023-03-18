<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");
if (!isset($_GET["jegy_id"])) header("location: all_booking.php");
template_header("Vezérlőpult");
dashboardNavbar();

$jegy = new Jegy();
$foglalas_adatok = $jegy->getFoglalasAdatok($_GET["jegy_id"]);

if (isset($_GET["delete"])) {
    $jegy->deleteJegyAdat($_GET["delete"]);
    header("location: foglalas_adatok.php?jegy_id=" . $_GET["jegy_id"]);
}
?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Foglalások adatok
            </h1>
        </div>
        <div class="column has-text-right">
            <a href="edit_booking_data.php?jegy_id=<?=$_GET['jegy_id']?>" class="button is-success">Új utas</a>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Utas vezetéknév</th>
                        <th>Utas keresztnév</th>
                        <th>Utas születési idő</th>
                        <th>Ülés</th>
                        <th>Jegyár</th>
                        <th>Becsekkolva</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($foglalas_adatok)) : ?>
                        <?php foreach ($foglalas_adatok as $foglalas) : ?>
                            <tr>
                                <td><?php echo $foglalas["UTAS_VEZNEV"]; ?></td>
                                <td><?php echo $foglalas["UTAS_KERNEV"]; ?></td>
                                <td><?php echo $foglalas["UTAS_SZULIDO"]; ?></td>
                                <td><?php echo $foglalas["ULES"]; ?></td>
                                <td><?php echo $foglalas["AR"] ?></td>
                                <td><?php echo ($foglalas["BECSEKKOLAS"] == "0") ? '<i style="color: red; font-weight: bold;" class="fa-solid fa-square-xmark"></i>' : '<i style="color: green; font-weight: bold;" class="fa-solid fa-check"></i>'; ?></td>
                                <td>
                                    <a href="edit_booking_data.php?jegy_id=<?= $_GET["jegy_id"] ?>&jegy_adatok_id=<?= $foglalas["ID"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="foglalas_adatok.php?jegy_id=<?= $_GET["jegy_id"] ?>&delete=<?= $foglalas["ID"] ?>"><i class="fa-solid fa-trash-arrow-up"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Nincs rögzítve a foglaláshoz adat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php template_footer(); ?>