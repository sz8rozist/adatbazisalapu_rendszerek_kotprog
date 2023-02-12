<?php

class Functions{
    public function printHtml($file){
        echo file_get_contents($file);
    }

    public function dashboardNavbar(){
        if(!empty($_SESSION)){
            echo '<nav class="navbar box-shadow-y">
            <div class="navbar-brand">
              <a href="#" class="navbar-item has-text-weight-bold has-text-black">
                Admin Dashboard
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
                <a href="#" class="navbar-item">
                     Home
                </a>
                <a href="#" class="navbar-item">
                  About
                </a>
                <a href="#" class="navbar-item">
                  Features
                </a>
                <a href="#" class="navbar-item">Pricing</a>
              </div>
              <div class="navbar-end">
                <a href="#" class="navbar-item">
                  Notifications
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                  <a href="#" class="navbar-link">
                    '.$_SESSION["username"].'
                  </a>
                  <div class="navbar-dropdown is-right">
                    <a href="#" class="navbar-item">
                      Profile
                    </a>
                    <a href="#" class="navbar-item">Settings</a>
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

    public function navbar(){
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
        if(!empty($_SESSION) && $_SESSION["jogosultsag"] == 0){
          echo '<div class="navbar-item has-dropdown is-hoverable">
          <a href="#" class="navbar-link">
            '.$_SESSION["username"].'
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
        }else{
          echo ' <div class="navbar-item">
          <div class="buttons">
            <a class="button is-info">
              <strong>Sign up</strong>
            </a>
            <button class="button is-primary js-modal-trigger" data-target="modal-login" aria-haspopup="true">Login</button>
          </div>
        </div>';
        }
         echo '
        </div>
      </div>
    </nav>';
    }
}