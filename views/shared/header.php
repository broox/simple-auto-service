<?php
require_once('../../config.php');
require_once(SITE_PATH.'/app.php');
?>
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
                    <li><a href="<?php echo SITE_URL; ?>/cars/new">New car</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top:100px">