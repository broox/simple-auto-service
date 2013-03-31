<div class="control-group">
    <label class="control-label" for="year">Year</label>
    <div class="controls">
        <input type="text" id="year" name="year" placeholder="1963" value="<?php echo $car->year; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="make">Make</label>
    <div class="controls">
        <input type="text" id="make" name="make" placeholder="Chevrolet" value="<?php echo $car->make; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="model">Model</label>
    <div class="controls">
        <input type="text" id="model" name="model" placeholder="Nova" value="<?php echo $car->model; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="trim">Trim</label>
    <div class="controls">
        <input type="text" id="trim" name="trim" placeholder="SS" value="<?php echo $car->trim; ?>">
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="trim">VIN</label>
    <div class="controls">
        <input type="text" id="vin" name="vin" placeholder="<?php echo $car->vin; ?>" value="<?php echo $car->vin; ?>">
    </div>
</div>