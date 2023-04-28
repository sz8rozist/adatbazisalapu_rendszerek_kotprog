<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$repter = new Repuloter();
$repterek = $repter->getRepterek();


if (isset($_GET["delete"])) {
    // $repter->delete($_GET["delete"]);
    try {
        $conn = oci_connect("SYSTEM", "oracle", "localhost/xe");
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $stmt = oci_parse($conn, "BEGIN delete_repuloter(:id); END;");
    oci_bind_by_name($stmt, ":id", $_GET["delete"]);
    if (oci_execute($stmt)) {
        header("location: repuloter.php");
    }
}

?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Repülőterek
            </h1>
        </div>
        <div class="column has-text-right">
            <a href="edit_repter.php" class="button is-success">Új repülőtér</a>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th>Város</th>
                        <th>Ország</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($repterek)) : ?>
                        <?php foreach ($repterek as $repter) : ?>
                            <tr>
                                <td><?php echo $repter["NEV"]; ?></td>
                                <td><?php echo $repter["VAROS"]; ?></td>
                                <td><?php echo $repter["ORSZAG"]; ?></td>
                                <td>
                                    <a href="edit_repter.php?id=<?= $repter["ID"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="repuloter.php?delete=<?= $repter["ID"] ?>"><i class="fa-solid fa-trash-arrow-up"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Nincs rögzítve repülőtér.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php template_footer(); ?>