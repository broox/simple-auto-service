<?php
require_once '../../config.php';
require_once SITE_PATH.'/app.php';

$car = new Car($_GET['slug']);
if ($car->doesntExist()) {
    require_once('../main/404.php'); die();
}

if (!empty($_POST)) {
    $car->updateAttributes($_POST);

    if(!$car->update()) {
        error_log('[WARN] failed to update car');
    }
    header('Location:'.$car->url());
} else {
    require_once '../shared/header.php';
    ?>
    <div class="row">
        <div class="span12">

            <h1>Edit <?= $car->title() ?></h1>

            <form class="form-horizontal" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php require_once './_form.php'; ?>

                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-primary" name="submit" value="Update car">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    require '../shared/footer.php';
}
?>