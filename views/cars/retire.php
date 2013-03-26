<?php
require_once '../../config.php';
require_once SITE_PATH.'/app.php';

$car = new Car($_GET['slug']);
if ($car->doesntExist()) {
    require_once('../main/404.php'); die();
}

$car->retire();
header('Location:'.$car->url());
?>