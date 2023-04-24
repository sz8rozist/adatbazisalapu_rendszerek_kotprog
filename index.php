<?php
require_once("init.php");

template_header("Kezdőlap");
navbar();
searchBox();

$j = new Jegy();
$legolcsobbJegyOrszagonkent = $j->legolcsobbJegyOrszagonkent();

$l = new Legitarsasag();

$legnepszerubbL = $l->legnepszerubbLegitarsasag();

?>
<section class="container mt-3">
    <div class="columns">
        <div class="column">
            <table class="table">
                <thead>
                    <tr>
                        <td>Ország</td>
                        <td>Jegy ár</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($legolcsobbJegyOrszagonkent as $data) : ?>
                        <tr>
                            <td><?php echo $data["ORSZAG"]; ?></td>
                            <td><?php echo $data["JEGY_AR"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table class="table">
                <thead>
                    <tr>
                        <th>Légitársaság neve</th>
                        <th>Értékelés</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($legnepszerubbL as $data) : ?>
                        <tr>
                            <td><?php echo $data["NEV"]; ?></td>
                            <td>
                                <?php for ($i = 1; $i <= $data["CSILLAG"]; $i++) : ?>
                                    <i style="color: #ffc700;" class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>



</section>


<?= template_footer(); ?>