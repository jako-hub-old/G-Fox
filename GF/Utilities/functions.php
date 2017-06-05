<?php
/**
 * This file contains the available function for entire application.
 * @package GF\Utilities
 * @author Jorge Alejandro Quiroz Serna <alejo.jko@gmail.com>
 * @version 1.0
 * @copyright (c) 2017, Jakolab
 */

/**
 * This function gets the element from an array and removes that element.
 * @param array $array
 * @param $key
 * @return mixed|null
 */
function arrayPop(array &$array, $key){
    $element = $array[$key]?? null;
    unset($array[$key]);
    return $element;
}