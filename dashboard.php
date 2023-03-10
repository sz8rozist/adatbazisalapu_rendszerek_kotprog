<?php
require_once("init.php");
if(empty($_SESSION)) header("location: index.php");

template_header("Vezérlőpult");
dashboardNavbar();
?>
<div class="columns is-variable is-0">
    <div
      class="column"
    >
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
                  Top Seller Total
                </div>
              </div>
              <div class="card-content">
                <p class="is-size-3">56,590</p>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="card has-background-warning has-text-black">
              <div class="card-header">
                <div class="card-header-title has-text-black is-uppercase">
                  Revenue
                </div>
              </div>
              <div class="card-content">
                <p class="is-size-3">55%</p>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="card has-background-info has-text-white">
              <div class="card-header">
                <div class="card-header-title has-text-white is-uppercase">
                  Feedback
                </div>
              </div>
              <div class="card-content">
                <p class="is-size-3">78 %</p>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="card has-background-danger has-text-white">
              <div class="card-header">
                <div class="card-header-title has-text-white">Orders</div>
              </div>
              <div class="card-content">
                <p class="is-size-3">425k</p>
              </div>
            </div>
          </div>
        </div>
        <div class="columns is-variable">
          <div class="column is-4-desktop is-6-tablet">
            <article class="message is-info">
              <div class="message-header">
                <p>Info</p>
                <button class="delete" aria-label="delete"></button>
              </div>
              <div class="message-body">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                <strong>Pellentesque risus mi</strong>, tempus quis placerat
                ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet
                fringilla. Nullam gravida purus diam, et dictum
                <a>felis venenatis</a> efficitur. Aenean ac
                <em>eleifend lacus</em>, in mollis lectus. Donec sodales, arcu
                et sollicitudin porttitor, tortor urna tempor ligula, id
                porttitor mi magna a neque. Donec dui urna, vehicula et sem
                eget, facilisis sodales sem.
              </div>
            </article>
          </div>
          <div class="column is-4-desktop is-6-tablet">
            <article class="message is-success">
              <div class="message-header">
                <p>Info</p>
                <button class="delete" aria-label="delete"></button>
              </div>
              <div class="message-body">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                <strong>Pellentesque risus mi</strong>, tempus quis placerat
                ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet
                fringilla. Nullam gravida purus diam, et dictum
                <a>felis venenatis</a> efficitur. Aenean ac
                <em>eleifend lacus</em>, in mollis lectus. Donec sodales, arcu
                et sollicitudin porttitor, tortor urna tempor ligula, id
                porttitor mi magna a neque. Donec dui urna, vehicula et sem
                eget, facilisis sodales sem.
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php template_footer(); ?>
