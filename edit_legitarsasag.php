<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();

$legitarsasag = new Legitarsasag();
if(isset($_POST["new_tarsasag"])){
      $response = json_decode($legitarsasag->insert($_POST["nev"], $_FILES));
      if(empty($response->msg)) header("location: legitarsasag.php");
}
if(isset($_GET["id"])){
    $row = $legitarsasag->legitarsasagById($_GET["id"]);

    if(isset($_POST["edit_tarsasag"])){
        $response = json_decode($legitarsasag->update($row,$_POST["nev"], $_FILES));
        if(empty($response->msg)) header("location: legitarsasag.php");
    }
}
?>
<div class="container is-fullhd">
    <div class="columns is-variable is-desktop">
        <div class="column">
            <h1 class="title">
                Légitársaságok <?php echo (isset($_GET["id"])) ? "szerkesztése" : "hozzáadása"; ?>
            </h1>
        </div>
    </div>
    <div class="columns is-variable is-desktop">
        <div class="column">
            <form action="edit_legitarsasag.php<?php echo (isset($_GET["id"])) ? "?id=" . $_GET["id"] : ""; ?>" method="post" enctype="multipart/form-data">
                <div class="field">
                    <label class="label">Név</label>
                    <div class="control">
                        <input class="input" value="<?php echo (isset($row)) ? $row->NEV : ""; ?>" type="text" name="nev">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Logo</label>
                    <div id="logo_img">
                    <img src="<?php echo (isset($row) && !is_null($row->IMG)) ? "uploads/". $row->IMG : "img/missing_image.png" ?>?>" width="100" alt="logo" title="A légitársaság logoja">
                    </div>
                    <div class="control">
                        <input type="file" name="img">
                    </div>
                </div>
                <div class="field">
                    <div><?php echo (!empty($response)) ? $response->msg : ""; ?></div>
                </div>
                <div class="field">
                    <button class="button is-success" type="submit" name="<?php echo (isset($_GET["id"])) ? "edit_tarsasag" : "new_tarsasag"; ?>">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php template_footer(); ?>