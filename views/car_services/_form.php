<input type="hidden" name="carID" id="carID" value="<?= $car->id ?>">

<div class="control-group">
    <label class="control-label" for="servicedAt">Service date/time</label>
    <div class="controls">
        <input type="text" id="servicedAt" name="servicedAt"
               placeholder="<?php echo $carService->servicedAt->mysqlDateTime(TIMEZONE) ?>"
               value="<?php echo $carService->servicedAt->mysqlDateTime(TIMEZONE) ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="mileage">Mileage</label>
    <div class="controls">
        <input type="text" id="mileage" name="mileage"
               placeholder="40000"
               value="<?php echo $carService->mileage; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="serviceDetails">Service</label>
    <div class="controls">
        <textarea rows="3" id="serviceDetails" name="serviceDetails"
                  placeholder="A short description of the service that was done"><?php echo $carService->serviceDetails; ?></textarea>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="servicedBy">Serviced by</label>
    <div class="controls">
        <input type="text" id="servicedBy" name="servicedBy"
               placeholder="Myself"
               value="<?php echo $carService->servicedBy; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="serviceCost">Service cost</label>
    <div class="controls">
        <input type="text" id="serviceCost" name="serviceCost"
               placeholder="0.00"
               value="<?php echo $carService->serviceCost; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="parts">Parts</label>
    <div class="controls">
        <textarea rows="3" id="parts" name="parts"
                  placeholder="OEM Alternator and Duralast battery"><?php echo $carService->parts; ?></textarea>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="partsFrom">Parts from</label>
    <div class="controls">
        <input type="text" id="partsFrom" name="partsFrom"
               placeholder="Ford and Autozone"
               value="<?php echo $carService->partsFrom; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="partsCost">Parts cost</label>
    <div class="controls">
        <input type="text" id="partsCost" name="partsCost"
               placeholder="434.10"
               value="<?php echo $carService->partsCost; ?>">
    </div>
</div>