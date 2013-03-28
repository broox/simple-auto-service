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

    <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="<?php echo SITE_URL; ?>"><?php echo SITE_TITLE; ?></a>

                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cars <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if (!empty($activeCars)) { ?>
                                <?php foreach ($activeCars as $navCar) { ?>
                                    <li><a href="<?php echo $navCar->url() ?>"><?php echo $navCar->title() ?></a></li>
                                <?php } ?>
                                <li class="divider"></li>
                            <?php } ?>
                            <li><a href="<?php echo SITE_URL; ?>/cars/new">New car</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container" id="mainContent">
