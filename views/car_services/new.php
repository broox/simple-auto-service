<?php
require_once '../../config.php';
require_once SITE_PATH.'/app.php';

$car = new Car($_GET['slug']);
if ($car->doesntExist()) {
    require_once('../main/404.php'); die();
}

if (!empty($_POST)) {
    $carService = new CarService(datesToUTC($_POST));
    if(!$carService->create()) {
        error_log('[WARN] failed to create CarService');
        echo 'error adding car service'; // TODO: church this up.
    } else {
        header('Location:'.$car->url());
    }
} else {
    require_once '../shared/header.php';
    $carService = new CarService;
    $carService->servicedAt = new Date();
    ?>
    <div class="row">
        <div class="span12">

            <h1>Add a service log for the <?= $car->title() ?></h1>

            <form class="form-horizontal" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php require_once './_form.php'; ?>

                <div class="control-group">
                    <div class="controls">
                        <a href="<?php echo $car->url(); ?>" class="btn">Cancel</a>
                        <input type="submit" class="btn btn-primary" name="submit" value="Add service log">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    require '../shared/footer.php';
}
?>