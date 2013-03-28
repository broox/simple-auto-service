<?php
require_once '../../config.php';
require_once SITE_PATH.'/app.php';

$car = new Car($_GET['slug']);
if ($car->doesntExist()) {
    require_once('../main/404.php'); die();
}

$serviceLogs = $car->serviceLogs();
require_once '../shared/header.php';
?>

<?php if (!empty($serviceLogs)) { ?>
    <h1>
        <?php echo $car->title() ?>
        <?php if ($car->retired()) { ?>
            <small class="text-error">Retired on <?php echo $car->retiredAt->format('m/d/y'); ?></small>
        <?php } ?>
    </h1>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th>Date</th>
                <th>Mileage</th>
                <th class="parts">Parts</th>
                <th class="parts-from">Parts from</th>
                <th class="service">Service</th>
                <th class="serviced-by">Serviced by</th>
                <th class="parts-cost">Parts cost</th>
                <th class="service-cost">Service cost</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody id="serviceLogs">
            <?php foreach ($serviceLogs as $serviceLog) { ?>
                <tr class="editable" data-service-url="<?php echo $serviceLog->editURL() ?>">
                    <td><?php echo $serviceLog->servicedAt->format('m/d/y'); ?></td>
                    <td><?php echo formatMileage($serviceLog->mileage); ?></td>

                    <td class="parts"><?php echo formatParts($serviceLog); ?></td>
                    <td class="parts-from"><?php echo $serviceLog->partsFrom; ?></td>

                    <td class="service"><?php echo formatService($serviceLog);?></td>
                    <td class="serviced-by"><?php echo $serviceLog->servicedBy; ?></td>

                    <td class="text-right parts-cost cost"><?php echo formatCost($serviceLog->partsCost); ?></td>
                    <td class="text-right service-cost cost"><?php echo formatCost($serviceLog->serviceCost); ?></td>
                    <td class="text-right cost"><?php echo formatCost($serviceLog->totalCost()); ?></td>
                </tr>
                <tr class="details editable" data-service-url="<?php echo $serviceLog->editURL() ?>">
                    <td colspan="3"><?php echo formatDetails($serviceLog) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="total-pad-768" colspan="2">&nbsp;</td>
                <td class="total-pad-1024" colspan="6">&nbsp;</td>
                <td class="total-pad-full" colspan="8">&nbsp;</td>

                <td class="text-right total-cost cost"><strong><?php echo formatCost($car->totalCost()); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="control-group">
        <div class="controls">
            <a href="<?php echo $car->editURL() ?>" class="btn">Edit car</a>
            <a href="<?php echo $car->serviceURL() ?>" class="btn btn-primary pull-right">Add service log</a>
        </div>
    </div>
<?php } else { ?>
    <div class="hero-unit">
        <h1>
            <?php echo $car->title() ?>
            <?php if ($car->retired()) { ?>
                <small class="text-error">Retired on <?php echo $car->retiredAt->format('m/d/y'); ?></small>
            <?php } ?>
        </h1>

        <p>
            <a href="<?php echo $car->editURL() ?>" class="btn">Edit car</a>
            <a href="<?php echo $car->serviceURL() ?>" class="btn btn-primary">Add service log</a>
        </p>
    </div>
<?php } ?>

<?php require '../shared/footer.php'; ?>
