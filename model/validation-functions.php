<?php
/**
 * Created by PhpStorm.
 * User: Brandon Skar
 * Date: 1/25/2019
 * Time: 10:50 AM
 */

function validColor($color) {
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validString($str) {
    return ctype_alpha($str) && ($str != "");
}