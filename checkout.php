<?php
require_once("init.php");

if (isset($_POST["booking"])) {
} else {
    header("location: index.php");
}
var_dump($_POST);
template_header("Checkout");
navbar();
?>
<div class="container section">
    <form action="checkout.php" method="post">
        <div class="columns is-centered">
            <div class="column is-8">
                <nav class="panel">
                    <p class="panel-heading">
                        Összegzés
                    </p>
                    <div class="section">
                        <div class="columns">
                            <div class="column">
                                <?php  ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </form>
</div>

<?php
template_footer();
?>