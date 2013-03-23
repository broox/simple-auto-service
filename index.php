<?php require_once './app.php'; ?>
<!DOCTYPE html>
<html>

  <head>
    <title><?php echo SITE_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="<?php echo SITE_URL; ?>"><?php echo SITE_TITLE; ?></a>

          <ul class="nav">
            <li class="active"><a href="<?php echo SITE_URL; ?>">Home</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container" style="margin-top:100px">
      <?php
      $currentCars = Car::current();
      ?>

      <h1>There are <?= Car::count() ?> cars</h1>
      <div class="row">
        <div class="span3">
          <ul class="nav nav-list">
            <?php foreach ($currentCars as $car) { ?>
              <li>
                <a href="<?php echo $car->url(); ?>"><?php echo $car->title(); ?></a>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="span9">
          <pre>
          <?php
          print_r(Car::index());
          ?>
          </pre>
        </div>
      </div>
      <br>bye
    </div>

    <div id="footer">
      <div class="container">
        <p class="muted credit">Built by <a href="http://www.broox.com">Derek Brooks</a>.</p>
      </div>
    </div>

    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
  </body>

</html>