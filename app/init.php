<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.lib.php';
require_once __DIR__ . '/../src/autoload.php';

define ( 'BASE_URL', dirname($_SERVER['SCRIPT_NAME']) != '/' ? dirname($_SERVER['SCRIPT_NAME']) : '' );

$GLOBALS['_CONFIG'] = json_decode(file_get_contents(__DIR__.'/config.json'));

// init database

ORM::configure(array(
    'connection_string' => $_CONFIG->database->connection_string,
    'username' => $_CONFIG->database->username,
    'password' => $_CONFIG->database->password
));

ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

$GLOBALS['_LANG'] = new FixMyApp\L10n(__DIR__.'/lang');

// installer should create the following folders :
//      cache, cache/templates, cache/languages, logs

// Initialize Twig templates and register custom functions

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');

$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__.'/../cache/templates',
    'debug' => true
));

$func_l10n = new Twig_SimpleFunction('__', function ($str) {
    return __($str);
});

$twig->addFunction($func_l10n);


$func_sprintf = new Twig_SimpleFunction('sprintf', function () {
    return call_user_func_array( 'sprintf', func_get_args() );
});

$twig->addFunction($func_sprintf);

// Initialize Silex application

$app = new Silex\Application();

if ( $_CONFIG->runtime->debug )
{
    $app['debug'] = true;
}

// Register authentication controller

$app->register( new Silex\Provider\SessionServiceProvider() );

$app->get('/login', function() use ($app) {
    $username = $app['request']->server->get('PHP_AUTH_USER', false);
    $password = $app['request']->server->get('PHP__AUTH_PW');

    if ( $username )
    {
        die("{$username}:{$password}");
    }

    if ( 'igor' === $username && 'password' === $password )
    {
        $app['session']->set( 'user', array( 'username' => $username ) );
        return $app->redirect('/');
    }

    $response = new Symfony\Component\HttpFoundation\Response();
    $response->headers->set( "WWW-Authenticate", sprintf('Basic realm="%s"', 'site_login') );
    $response->setStatusCode(401, 'Please sign in');
    return $response;
});

$checkLogin = $GLOBALS['checkLogin'] = function() use ($app) {
    if ( null === $user = $app['session']->get('user') )
    {
        return $app->redirect('/login');
    }
};
