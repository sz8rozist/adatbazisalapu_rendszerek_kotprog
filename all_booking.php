<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Foglalások");
dashboardNavbar();

$jegy = new Jegy();
$foglalasok = $jegy->getFoglalasok();
if(isset($_GET["delete"])){
    $jegy->deleteJegy($_GET["delete"]);
    header("location: all_booking.php");
}

if(isset($_GET["fizetve"])){
    $jegy->fizetve($_GET["fizetve"]);
    header("location: all_booking.php");
}

?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Foglalások
            </h1>
        </div>
       <!-- <div class="column has-text-right">
            <a href="edit_jarat.php" class="button is-success">Új járat</a>
        </div>-->
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Foglalási szám</th>
                        <th>Indulási dátum</th>
                        <th>Indulási idő</th>
                        <th>Érkezési dátum</th>
                        <th>Érkezési idő</th>
                        <th>Fizetési mód</th>
                        <th>Fizetve</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($foglalasok)) : ?>
                        <?php foreach ($foglalasok as $jegy) : ?>
                            <tr>
                                <td><?php echo $jegy["ID"]; ?></td>
                                <td><?php echo $jegy["INDULASI_DATUM"]; ?></td>
                                <td><?php echo $jegy["INDULASI_IDO"]; ?></td>
                                <td><?php echo $jegy["ERKEZESI_DATUM"]; ?></td>
                                <td><?php echo $jegy["ERKEZESI_IDO"] ?></td>
                                <td><?php echo $jegy["FIZETES_MOD"] ?></td>
                                <td><?php echo ($jegy["FIZETVE"] == "0") ? '<i style="color: red; font-weight: bold;" class="fa-solid fa-square-xmark"></i>' : '<i style="color: green; font-weight: bold;" class="fa-solid fa-check"></i>'; ?></td>
                                <td>
                                    <?php if($jegy["FIZETVE"] == 0): ?><a href="all_booking.php?fizetve=<?= $jegy["ID"] ?>"><i class="fa-regular fa-credit-card"></i></a> <?php endif; ?>
                                    <a href="foglalas_adatok.php?jegy_id=<?= $jegy["ID"] ?>"><i class="fa-solid fa-circle-info"></i></a>
                                    <a href="all_booking.php?delete=<?= $jegy["ID"] ?>"><i class="fa-solid fa-trash-arrow-up"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Nincs rögzítve foglalás.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php template_footer(); ?>