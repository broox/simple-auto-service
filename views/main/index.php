<?php
require_once '../shared/header.php';
$currentCars = Car::active();
$retiredCars = Car::inactive();
?>

<div class="row">
    <div class="span12">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Car</th>
                    <th class="text-right">Last Serviced</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($currentCars as $car) { ?>
                    <tr>
                        <td><a href="<?php echo $car->url(); ?>"><?php echo $car->title(); ?></a></td>
                        <td class="text-right"><?php echo formatLastServiced($car); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (!empty($retiredCars)) { ?>
            <div class="retired muted">
                <h3>Retired cars</h3>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th class="text-right">Retired</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($retiredCars as $car) { ?>
                            <tr>
                                <td><a href="<?php echo $car->url(); ?>"><?php echo $car->title(); ?></a></td>
                                <td class="text-right"><?php echo $car->retiredAt->format('m/d/Y'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>
<?php require '../shared/footer.php'; ?>