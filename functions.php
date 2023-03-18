<?php
function template_header($title)
{
  echo '
  <!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- BULMA CSS -->
    <link rel="stylesheet" href="css/bulma.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <title>Air ticket booking - ' . $title . '</title>
  </head>
  <body>
    <div class="modal" id="modal-login">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Bejelentkezés</p>
          <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <div class="field">
              <label class="label">Felhasználónév</label>
              <div class="control">
                <input class="input" name="username" type="text" />
              </div>
            </div>
            <div class="field">
              <label class="label">Jelszó</label>
              <div class="control">
                <input class="input" name="password" type="password" />
              </div>
            </div>
            <div class="has-text-danger error">

            </div>
        </section>
        <footer class="modal-card-foot">
          <button id="login_btn" class="button is-success">Küldés</button>
        </footer>
      </div>
    </div>


    <div class="modal" id="modal-signup">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Regisztráció</p>
          <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <div class="field">
              <label class="label">Felhasználónév</label>
              <div class="control">
                <input class="input" name="signup_username" id="signup_username" type="text" />
              </div>
            </div>
            <div class="field">
              <label class="label">Jelszó</label>
              <div class="control">
                <input class="input" name="signup_password" id="signup_password" type="password" />
              </div>
            </div>
            <div class="has-text-danger signup_error">

            </div>
        </section>
        <footer class="modal-card-foot">
          <button id="signup_btn" class="button is-success">Regisztrálok</button>
        </footer>
      </div>
    </div>
  ';
}

function template_footer()
{
  echo '
    <script
    src="js/jquery.min.js"
    ></script>
    <script src="js/navbar.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/tab.js"></script>
    <script src="js/idopont.js"></script>
    <script src="js/booking.js"></script>
    </body>
    </html>
';
}

function searchBox()
{
  $repter = new Repuloter();
  $varosok = $repter->getVarosok();
  $szemely_szam = isset($_POST["szemely_szam"]) ? $_POST["szemely_szam"] : 1;

  $honnan_select = "<select class='is-fullwidth' name='indulasi_repuloter_id'>";
  if (empty($varosok)) {
    $honnan_select .= "<option>Nincs rögzítve a rendszerben elérhető város</option>";
  } else {
    foreach ($varosok as $varos) {
      if(isset($_POST["indulasi_repuloter_id"]) && $_POST["indulasi_repuloter_id"] == $varos["ID"]){
        $honnan_select .= "<option selected value='" . $varos["ID"] . "'>" . $varos["VAROS"] . "</option>";
      }else{
        $honnan_select .= "<option value='" . $varos["ID"] . "'>" . $varos["VAROS"] . "</option>";
      }
    }
  }
  $honnan_select .= "</select>";

  $hova_select = "<select class='is-fullwidth' name='erkezesi_repuloter_id'>";
  if (empty($varosok)) {
    $hova_select .= "<option>Nincs rögzítve a rendszerben elérhető város</option>";
  } else {
    foreach ($varosok as $varos) {
      if(isset($_POST["erkezesi_repuloter_id"]) && $_POST["erkezesi_repuloter_id"] == $varos["ID"]){
        $hova_select .= "<option selected value='" . $varos["ID"] . "'>" . $varos["VAROS"] . "</option>";
      }else{
        $hova_select .= "<option value='" . $varos["ID"] . "'>" . $varos["VAROS"] . "</option>";
      }
    }
  }
  $hova_select .= "</select>";

  $jaratok = new Legitarsasag();
  $osztalyok = $jaratok->getJaratOsztaly();

  $osztaly_select = "<select class='is-fullwidth' name='osztaly'>";
  if (empty($osztalyok)) {
    $osztaly_select .= "<option>Nincs rögzítve a rendszerben elérhető repülőjárat</option>";
  } else {
    foreach ($osztalyok as $osztaly) {
      if(isset($_POST["osztaly"]) && $_POST["osztaly"] == $osztaly["OSZTALY"]){
        $osztaly_select .= "<option selected value='" . $osztaly["OSZTALY"] . "'>" . $osztaly["OSZTALY"] . "</option>";
      }else{
        $osztaly_select .= "<option value='" . $osztaly["OSZTALY"] . "'>" . $osztaly["OSZTALY"] . "</option>";
      }
    }
  }
  $osztaly_select .= "</select>";
  $indulasi_datum_val = isset($_POST["indulasi_datum"]) ? $_POST["indulasi_datum"] : "";
  $erkezesi_datum_val = isset($_POST["erkezesi_datum"]) ? $_POST["erkezesi_datum"] : "";
  echo '<div class="search">
  <section class="section is-small">
    <h1 class="title has-text-centered has-text-white">
      Csak pár kattintás álmaid utazása
    </h1>
  </section>
  <section class="section is-small">
    <div class="tabs is-toggle">
      <div class="container">
        <ul>
          <li class="tab tab-is-active" onclick="openTab(event,egyiranyu)" >
            <a>Egyirányú</a>
          </li>
          <li class="tab" onclick="openTab(event,odaVissza)">
            <a>Oda-vissza</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="container box">
        <div id="egyiranyu" class="content-tab">
          <form action="search.php" method="post">
          <div class="field is-horizontal">
            <div class="field-body">
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                   '.$honnan_select.'
                  </div>
                </div>
              </div>
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                    '.$hova_select.'
                  </div>
                </div>
              </div>
              <div class="field">
                <input class="input" value="'.$indulasi_datum_val.'" name="indulasi_datum" type="date" placeholder="Name" />
              </div>
              <div class="field">
                <input
                  class="input"
                  type="text"
                  name="szemely_szam"
                  placeholder="Személyek száma"
                  value="' . $szemely_szam . '"
                />
              </div>
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                    '.$osztaly_select.'
                  </div>
                </div>
              </div>
              <button name="jarat_search" class="button is-info">Keresés</button>
            </div>
          </div>
          </form>
        </div>
        <div id="odaVissza" class="content-tab" style="display: none">
          <form action="search.php" method="post">
          <div class="field is-horizontal">
            <div class="field-body">
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                   '.$honnan_select.'
                  </div>
                </div>
              </div>
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                    '.$hova_select.'
                  </div>
                </div>
              </div>
              <div class="field">
                <input class="input" value="'.$indulasi_datum_val.'" name="indulasi_datum" type="date" placeholder="Name" />
              </div>
              <div class="field">
                <input class="input" type="date" value="'.$erkezesi_datum_val.'" name="erkezesi_datum" placeholder="Email" value="" />
              </div>
              <div class="field">
                <input
                  class="input"
                  type="text"
                  name="szemely_szam"
                  placeholder="Személyek száma"
                  value="1"
                />
              </div>
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                  '.$osztaly_select.'
                  </div>
                </div>
              </div>
              <button name="jarat_search" class="button is-info">Keresés</button>
            </div>
          </div>
          </form>
        </div>
    </div>
  </section>
</div>
';
}

function dashboardNavbar()
{
  if (!empty($_SESSION)) {
    echo '<nav class="navbar box-shadow-y">
            <div class="navbar-brand">
              <a href="#" class="navbar-item has-text-weight-bold has-text-black">
                Admin vezérlőpult
              </a>
              <a
                role="button"
                class="navbar-burger nav-toggler"
                aria-label="menu"
                aria-expanded="false"
              >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
              </a>
            </div>
            <div class="navbar-menu has-background-white">
              <div class="navbar-start">
                <a href="dashboard.php" class="navbar-item">
                     Kezdőlap
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                <a href="legitarsasag.php" class="navbar-link">
                Légitársaság
              </a>
                <div class="navbar-dropdown is-right">
                  <a href="legitarsasag.php" class="navbar-item">
                    Légitársaságok
                  </a>
                  <a href="jaratok.php" class="navbar-item">Járatok</a>
                </div>
              </div>
                <a href="repuloter.php" class="navbar-item">
                Repülőterek
              </a>
                <a href="all_booking.php" class="navbar-item">
                  Foglalások
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                <a href="#" class="navbar-link">
                  Poggyász
                </a>
                <div class="navbar-dropdown is-right">
                  <a href="poggyasz.php" class="navbar-item">
                    Poggyászok
                  </a>
                  <a href="logout.php" class="navbar-item">Feladott poggyászok</a>
                </div>
              </div>
              </div>
              <div class="navbar-end">
                <a href="#" class="navbar-item">
                  Notifications
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                  <a href="#" class="navbar-link">
                    ' . $_SESSION["username"] . '
                  </a>
                  <div class="navbar-dropdown is-right">
                    <a href="profile.php" class="navbar-item">
                      Profile
                    </a>
                    <a href="#" class="navbar-item">Felhasználók</a>
                    <hr class="navbar-divider" />
                    <a href="logout.php" class="navbar-item">Kilépés</a>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        ';
  }
}

function navbar()
{
  echo '<nav class="navbar is-info" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
          <img src="img/logo.png" >
        </a>
    
        <a role="button" class="navbar-burger nav-toggler" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>
    
      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item">
            Home
          </a>
    
          <a class="navbar-item">
            Documentation
          </a>
    
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              More
            </a>
    
            <div class="navbar-dropdown">
              <a class="navbar-item">
                About
              </a>
              <a class="navbar-item">
                Jobs
              </a>
              <a class="navbar-item">
                Contact
              </a>
              <hr class="navbar-divider">
              <a class="navbar-item">
                Report an issue
              </a>
            </div>
          </div>
        </div>
    
        <div class="navbar-end">';
  if (!empty($_SESSION) && isset($_SESSION["jogosultsag"]) && $_SESSION["jogosultsag"] == 0) {
    echo '<div class="navbar-item has-dropdown is-hoverable">
          <a href="#" class="navbar-link">
            ' . $_SESSION["username"] . '
          </a>
          <div class="navbar-dropdown is-right">
            <a href="#" class="navbar-item">
              Profile
            </a>
            <a href="#" class="navbar-item">Settings</a>
            <hr class="navbar-divider" />
            <a href="logout.php" class="navbar-item">Kilépés</a>
          </div>
        </div>';
  } else {
    echo ' <div class="navbar-item">
          <div class="buttons">
            <button class="button is-info js-modal-trigger" data-target="modal-signup" aria-haspopup="true">
              <strong>Sign up</strong>
            </button>
            <button class="button is-primary js-modal-trigger" data-target="modal-login" aria-haspopup="true">Login</button>
          </div>
        </div>';
  }
  echo '
        </div>
      </div>
    </nav>';
}
