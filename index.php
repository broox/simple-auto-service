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

    <div class="container">
    </div>

    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
  </body>

</html>