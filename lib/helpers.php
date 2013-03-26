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
?>