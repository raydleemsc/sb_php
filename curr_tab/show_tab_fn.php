<?php

function field_compare($array_a, $array_b, $field_name){
    return $array_a[$field_name] > $array_b[$field_name];
}

function comparatortext($a, $b){
    return field_compare($a, $b, 'text');
}

function comparatorloc($a, $b){
    return field_compare($a, $b, 'loc');
}



?>