<?php
if (!empty($_POST)) {
    require_once '../../config.php';
    require_once SITE_PATH.'/app.php';

    $car = new Car($_POST);
    if(!$car->create()) {
        error_log('[WARN] failed to create Car');
        echo 'error adding car'; // TODO: church this up.
    } else {
        header('Location:'.$car->url());
    }
} else {
    require_once '../shared/header.php';
    $car = new Car;
    ?>
    <div class="row">
        <div class="span12">

            <h1>Add a car</h1>

            <form class="form-horizontal" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php require_once './_form.php'; ?>

                <div class="control-group">
                    <div class="controls">
                        <a href="<?php echo SITE_URL; ?>" class="btn">Cancel</a>
                        <input type="submit" class="btn btn-primary" name="submit" value="Add car">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    require '../shared/footer.php';
}
?>