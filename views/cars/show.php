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
<h1>
    <?php echo $car->title() ?>
    <small><a href="<?php echo $car->editURL() ?>">edit</a></small>
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
    <tbody>
        <?php foreach ($serviceLogs as $serviceLog) { ?>
            <tr>
                <td><?php echo $serviceLog->servicedAt->format('m/d/y'); ?></td>
                <td><?php echo formatMileage($serviceLog->mileage); ?></td>
                <td class="parts"><?php echo $serviceLog->parts; ?></td>
                <td class="parts-from"><?php echo $serviceLog->partsFrom; ?></td>
                <td class="service"><?php echo $serviceLog->serviceDetails; ?></td>
                <td class="serviced-by"><?php echo $serviceLog->servicedBy; ?></td>
                <td class="text-right parts-cost cost"><?php echo formatCost($serviceLog->partsCost); ?></td>
                <td class="text-right service-cost cost"><?php echo formatCost($serviceLog->serviceCost); ?></td>
                <td class="text-right cost"><?php echo formatCost($serviceLog->totalCost()); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td class="total-pad" colspan="8">&nbsp;</td>
            <td class="text-right total-cost cost"><strong><?php echo formatCost($car->totalCost()); ?></strong></td>
        </tr>
    </tbody>
</table>

<?php require '../shared/footer.php'; ?>