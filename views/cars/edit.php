<?php
require_once '../../config.php';
require_once SITE_PATH.'/app.php';

$car = new Car($_GET['slug']);
if ($car->doesntExist()) {
    require_once('../main/404.php'); die();
}

if (!empty($_POST)) {
    $car->updateAttributes(datesToUTC($_POST));

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

                <?php if ($car->retired()) { ?>
                    <div class="control-group">
                        <label class="control-label" for="retiredAt">Retired</label>
                        <div class="controls">
                            <input type="text" id="retiredAt" name="retiredAt"
                                   placeholder="<?php echo $car->retiredAt->mysqlDate(TIMEZONE); ?>"
                                   value="<?php echo $car->retiredAt->mysqlDate(TIMEZONE); ?>">
                        </div>
                    </div>
                <?php } ?>

                <div class="control-group">
                    <div class="controls">
                        <a href="<?php echo $car->url(); ?>" class="btn">Cancel</a>
                        <input type="submit" class="btn btn-primary" name="submit" value="Update car">
                        <?php if (!$car->retired()) { ?>
                            <a href="<?php echo $car->retireURL() ?>" class="btn btn-danger btn-retire pull-right"
                               data-confirmation="Are you sure you want to retire this car?">Retire car</a>
                        <?php } else { ?>
                            <a href="<?php echo $car->resurrectURL() ?>" class="btn btn-warning pull-right">Resurrect car</a>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    require '../shared/footer.php';
}
?>