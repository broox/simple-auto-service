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
    ?>
    <div class="row">
        <div class="span12">

            <h1>Add a car</h1>

            <form class="form-horizontal" action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                <div class="control-group">
                    <label class="control-label" for="year">Year</label>
                    <div class="controls">
                        <input type="text" id="year" name="year" placeholder="1963">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="make">Make</label>
                    <div class="controls">
                        <input type="text" id="make" name="make" placeholder="Chevrolet">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="model">Model</label>
                    <div class="controls">
                        <input type="text" id="model" name="model" placeholder="Nova">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="trim">Trim</label>
                    <div class="controls">
                        <input type="text" id="trim" name="trim" placeholder="SS">
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
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