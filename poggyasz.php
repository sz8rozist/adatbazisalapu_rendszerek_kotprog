<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$p = new Poggyasz();
$poggyaszok = $p->getPoggyaszok();


if(isset($_GET["delete"])){
    $p->delete($_GET["delete"]);
    header("location: poggyasz.php");
}

?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Poggyászok
            </h1>
        </div>
        <div class="column has-text-right">
            <a href="edit_poggyasz.php" class="button is-success">Új poggyász</a>
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
                                    <a href="edit_poggyasz.php?id=<?= $poggyasz["ID"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="poggyasz.php?delete=<?= $poggyasz["ID"] ?>"><i class="fa-solid fa-trash-arrow-up"></i></a>
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