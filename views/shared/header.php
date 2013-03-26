<?php
require_once('../../config.php');
require_once(SITE_PATH.'/app.php');
$activeCars = Car::active();
?>
<!DOCTYPE html>
<html>

    <head>
        <title><?php echo SITE_TITLE; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="/assets/css/app.css" rel="stylesheet">
    </head>

    <body>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <a class="brand" href="<?php echo SITE_URL; ?>"><?php echo SITE_TITLE; ?></a>

                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cars</a>
                            <ul class="dropdown-menu">
                                <?php foreach ($activeCars as $navCar) { ?>
                                    <li><a href="<?php echo $navCar->url() ?>"><?php echo $navCar->title() ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li><a href="<?php echo SITE_URL; ?>/cars/new">New car</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top:100px">
