<?php

require_once __DIR__ . '/../vendor/autoload.php';

$_CONFIG = $_GLOBALS['_CONFIG'] = json_decode(file_get_contents(__DIR__.'/config.json'));

ORM::configure(array(
    'connection_string' => $_CONFIG->database->connection_string,
    'username' => $_CONFIG->database->username,
    'password' => $_CONFIG->database->password
));

ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// installer should create the following folders :
//      cache, cache/templates, cache/languages, logs

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__.'/../cache/templates',
    'debug' => true
));
