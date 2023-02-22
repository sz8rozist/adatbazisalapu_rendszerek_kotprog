<?php
require_once("init.php");

if (isset($_POST["booking"])) {
} else {
    header("location: index.php");
}
template_header("Járat keresés");
navbar();
searchBox();
?>
<div class="container section">
    <form action="ulohely.php" method="post">
        <div class="columns">
            <div class="column is-8">
                <?php for ($i = 1; $i <= $_POST["szemely_szam"]; $i++) : ?>
                    <nav class="panel">
                        <p class="panel-heading">
                            <?php echo $i . ". utas adatai"; ?>
                        </p>
                        <div class="section">
                            <div class="field">
                                <div class="control">
                                    <input class="input" placeholder="Vezetéknév" type="text" name="utas_veznev[]">
                                </div>

                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" placeholder="Keresztnév" type="text" name="utas_kernev[]">
                                </div>

                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Születési idő (1999-02-02)" name="utas_szulido[]">
                                </div>
                            </div>
                        </div>
                    </nav>
                <?php endfor; ?>
            </div>
            <div class="column is-4">
                <nav class="panel">
                    <p class="panel-heading">
                        Összegzés
                    </p>
                    <?php for($i = 1; $i <= $_POST["szemely_szam"]; $i ++): ?>
                    <p class="panel-block">
                        <span class="panel-icon">
                            <i class="fa-solid fa-ticket"></i>
                        </span>
                        <?php echo $i . " - " . $_POST["ar"]; ?> Ft
                    </p>
                    <?php endfor; ?>
                    <p class="panel-block">
                        <span class="panel-icon"><i class="fa-solid fa-money-check"></i></span>
                        Összesen: <?php echo $_POST["szemely_szam"] * $_POST["ar"]; ?> Ft
                    </p>
                    <div class="panel-block">
                        <button class="button is-info is-outlined is-fullwidth">
                            Fizetés
                        </button>
                    </div>
                </nav>
            </div>

        </div>
    </form>
</div>

<?php
template_footer();
?>