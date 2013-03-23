<?php
/*
 * Convert an underscored string to camelCase
 */
function camelCase($str, $capitalizeFirstChar = false) {
    //error_log($str);
    if ($capitalizeFirstChar) { $str[0] = strtoupper($str[0]); }
    $func = create_function('$c', 'return strtoupper($c[1]);');
    return preg_replace_callback('/_([a-z])/', $func, $str);
}

/* 
 * Convert a camelCased word to underscores
 */
function underscore($str) {
    $str[0] = strtolower($str[0]);
    $func = create_function('$c', 'return "_" . strtolower($c[1]);');
    return preg_replace_callback('/([A-Z])/', $func, $str);
}

/*
 * Remove all empty array variables
 */
function rejectEmptyArrayValues($array) {
    foreach ($array as $k => $v) {
        if (empty($array[$k])) {
            unset($array[$k]);
        }
    }
    return $array;
}
?>