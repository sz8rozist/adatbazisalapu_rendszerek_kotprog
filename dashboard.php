<?php
require_once("init.php");
if (empty($_SESSION)) header("location: index.php");
$l = new Legitarsasag();
$j = new Jegy();
$legfiatalabbUtazok = $l->legfiatalabbUtazok();
$legidosebbUtazok = $l->legidosebbUtazok();
$fizmod_jegyar = $j->fizmod_ossz_jegyar();
$kifiz_jegyszam = $j->kifizetettJegyekSzama();
template_header("Vezérlőpult");
dashboardNavbar();
?>
<div class="columns is-variable is-0">
  <div class="column">
    <div class="p-1">
      <div class="columns is-variable is-desktop">
        <div class="column">
          <h1 class="title">
            Üdvözöllek <?php echo $_SESSION["username"]; ?>!
          </h1>
        </div>
      </div>

      <div class="columns is-variable is-desktop">
        <div class="column">
          <div class="card has-background-primary has-text-white">
            <div class="card-header">
              <div class="card-header-title has-text-white">
                Légitársaságonként a legfiatalabb utazók
              </div>
            </div>
            <div class="card-content">
              <table class="table">
                <thead>
                  <tr>
                    <th>Légitársaság</th>
                    <th>Születési idő</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($legfiatalabbUtazok as $data) : ?>
                    <tr>
                      <td><?php echo $data["NEV"] ?></td>
                      <td><?php echo date("Y-m-d", strtotime($data["SZULIDO"])) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="card has-background-warning has-text-black">
            <div class="card-header">
              <div class="card-header-title has-text-black is-uppercase">
                Légitársaságonként a legidősebb utazók
              </div>
            </div>
            <div class="card-content">
            <table class="table">
                <thead>
                  <tr>
                    <th>Légitársaság</th>
                    <th>Születési idő</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($legidosebbUtazok as $data) : ?>
                    <tr>
                      <td><?php echo $data["NEV"] ?></td>
                      <td><?php echo date("Y-m-d", strtotime($data["SZULIDO"])) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="card has-background-info has-text-white">
            <div class="card-header">
              <div class="card-header-title has-text-white is-uppercase">
                Fizetési módonkénti összes jegyár
              </div>
            </div>
            <div class="card-content">
            <table class="table">
                <thead>
                  <tr>
                    <th>Fizetési mód</th>
                    <th>Jegy ár</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($fizmod_jegyar as $data) : ?>
                    <tr>
                      <td><?php echo $data["FIZETES_MOD"] ?></td>
                      <td><?php echo $data["JEGYAR"] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="card has-background-danger has-text-white">
            <div class="card-header">
              <div class="card-header-title has-text-white">Légitársaságonkénti kifizetett jegyek darabszáma</div>
            </div>
            <div class="card-content">
            <table class="table">
                <thead>
                  <tr>
                    <th>Légitársaság</th>
                    <th>Darab</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($kifiz_jegyszam as $data) : ?>
                    <tr>
                      <td><?php echo $data["NEV"] ?></td>
                      <td><?php echo $data["COUNT"] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<?php template_footer(); ?>