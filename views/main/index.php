<?php
require_once '../shared/header.php';
$currentCars = Car::active();
$retiredCars = Car::inactive();
?>

<div class="row">
    <div class="span12">
        <? if (!empty($currentCars)) { ?>
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
        <?php } else { ?>
            <div class="hero-unit">
                <h1><?php echo SITE_TITLE; ?></h1>
                <p>
                    An easy, mobile-friendly way to keep track of your vehicle's maintenance.<br>
                    Get started by adding a car that you own.
                </p>
                <p><a class="btn btn-primary btn-large" href="<?php echo SITE_URL; ?>/cars/new">Add a car</a></p>
            </div>
        <?php } ?>

        <?php if (!empty($retiredCars)) { ?>
            <div class="retired muted">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Old car</th>
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