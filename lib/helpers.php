<?php

/*
 * Make dollar bills look like dollar, dollar bills, y'all
 */
function formatCost($cost) {
    if ($cost == 0)
        return NULL;

    return money_format('%n', $cost);
}

/*
 * Add some commas to that mileage
 */
function formatMileage($mileage) {
    if ($mileage == 0)
        return NULL;

    return number_format($mileage);
}

/*
 * Combine some of the parts fields of a service log to be displayed responsively
 */
function formatParts($serviceLog) {
    $html = array();
    if (!empty($serviceLog->parts))
        $html[] = '<p>'.$serviceLog->parts.'</p>';

    if (!empty($serviceLog->partsFrom))
        $html[] = '<p class="parts-from">From: '.$serviceLog->partsFrom.'</p>';

    if ($serviceLog->partsCost > 0)
        $html[] = '<p class="parts-cost">Cost: '.formatCost($serviceLog->partsCost).'</p>';

    return implode('', $html);
}

/*
 * Combine some of the service fields of a service log to be displayed responsively
 */
function formatService($serviceLog) {
    $html = array();

    if (!empty($serviceLog->serviceDetails))
        $html[] = '<p>'.$serviceLog->serviceDetails.'</p>';

    if (!empty($serviceLog->servicedBy))
        $html[] = '<p class="serviced-by">Serviced by: '.$serviceLog->servicedBy.'</p>';

    if ($serviceLog->serviceCost > 0)
        $html[] = '<p class="service-cost">Cost: '.formatCost($serviceLog->serviceCost).'</p>';

    return implode('', $html);
}

/*
 * Combine the parts and services fields of a service log to be displayed responsively
 */
function formatDetails($serviceLog) {
    $parts = formatParts($serviceLog);
    $service = formatService($serviceLog);

    $html = array();

    if (!empty($parts) && !empty($service))
        $html[] = '<p><strong>Parts</strong></p>';

    if (!empty($parts))
        $html[] = $parts;

    if (!empty($parts) && !empty($service))
        $html[] = '<p><strong>Service</strong></p>';

    if (!empty($service))
        $html[] = $service;

    return implode('', $html);
}

/*
 * Format a car's last service date
 */
function formatLastServiced($car) {
    $lastService = $car->lastService();

    if (empty($lastService))
        return NULL;

    if (empty($lastService->servicedAt))
        return NULL;

    if (!is_a($lastService->servicedAt,'Date'))
        return NULL;

    return $lastService->servicedAt->format('m/d/y');
}

/*
 * Takes a hash and converts any datetimes in it to UTC
 * Assumes all date/times in it are local time!
 */
function datesToUTC($hash) {
    foreach ($hash as $key => $value) {
        if (substr($key,-2) != 'At' or empty($value))
            continue;

        $date = new Date($value);
        $hash[$key] = $date->mysqlDateTime('UTC');
    }
    return $hash;
}
?>
