<?php

require '../bootstrap.php';

use Slim\App;

$slim =  new App();

$slim->get('/', function() {
    return "Primeira rota.";
});

$slim->run();