<?php
function formatCost($cost) {
    if ($cost == 0)
        return NULL;

    return money_format('%n', $cost);
}

function formatMileage($mileage) {
    if ($mileage == 0)
        return NULL;

    return number_format($mileage);
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