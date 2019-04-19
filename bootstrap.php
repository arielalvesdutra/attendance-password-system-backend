<?php

require 'vendor/autoload.php';


function debugd()
{
    $arguments = func_get_args();
    echo '<pre>';
    foreach($arguments as &$argument){
        if (is_object($argument) || is_array($argument)) {
            print_r($argument);
        } elseif (empty($argument) || is_resource($argument)) {
            var_dump($argument);
        } else {
            echo (string)$argument;
        }
    }
    echo '</pre>';
    die();
}
