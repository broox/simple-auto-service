<?php
require_once '../../config.php';
require_once SITE_PATH.'/app.php';

$carService = new CarService($_GET['id']);
if ($carService->doesntExist()) {
    error_log('[WARN] Could not find car service');
    require_once('../main/404.php'); die();
}

$car = $carService->car();
if ($car->doesntExist()) {
    error_log('[WARN] Could not find car');
    require_once('../main/404.php'); die();
}

if (!empty($_POST)) {
    $attributes = $carService->updateAttributes(datesToUTC($_POST));
    // print_r($attributes);
    // die();

    if(!$carService->update()) {
        error_log('[WARN] failed to update car service');
    }
    header('Location:'.$car->url());
} else {
    require_once '../shared/header.php';
    ?>
    <div class="row">
        <div class="span12">

            <h1>Edit service on the <?= $car->title() ?></h1>

            <form class="form-horizontal" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php require_once './_form.php'; ?>

                <div class="control-group">
                    <div class="controls">
                        <a href="<?php echo $car->url(); ?>" class="btn">Cancel</a>
                        <input type="submit" class="btn btn-primary" name="submit" value="Update car service">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    require '../shared/footer.php';
}
?>