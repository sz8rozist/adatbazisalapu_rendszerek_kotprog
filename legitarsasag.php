<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$legitarsasag = new Legitarsasag();
$tarsasagok = $legitarsasag->getLegitarsasagok();


if(isset($_GET["delete"])){
    $legitarsasag->delete($_GET["delete"]);
    header("location: legitarsasag.php");
}

?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Légitársaságok
            </h1>
        </div>
        <div class="column has-text-right">
            <a href="edit_legitarsasag.php" class="button is-success">Új légitársaság</a>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Név</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tarsasagok)) : ?>
                        <?php foreach ($tarsasagok as $tarsasag) : ?>
                            <tr>
                                <td><img width="50" alt="logo" src="<?php echo (empty($tarsasag["IMG"])) ? "./img/missing_image.png" : "./uploads/" . $tarsasag["IMG"]; ?>"></td>
                                <td><?php echo $tarsasag["NEV"]; ?></td>
                                <td>
                                    <a href="edit_legitarsasag.php?id=<?= $tarsasag["ID"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="legitarsasag.php?delete=<?= $tarsasag["ID"] ?>"><i class="fa-solid fa-trash-arrow-up"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Nincs rögzítve légitársaság.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php template_footer(); ?>