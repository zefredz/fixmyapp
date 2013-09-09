<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/classes/autoload.php';

// temporary code will be moved to installer

if ( ! file_exists(__DIR__.'/../cache/templates') )
{
    mkdir(__DIR__.'/../cache/templates', 0777, true );
}

if ( ! file_exists(__DIR__.'/../cache/http') )
{
    mkdir(__DIR__.'/../cache/http', 0777, true );
}

define ( 'BASE_URL', dirname($_SERVER['SCRIPT_NAME']) != '/' ? dirname($_SERVER['SCRIPT_NAME']) : '' );

$yamlParser = new Symfony\Component\Yaml\Parser();
$GLOBALS['_CONFIG'] = new FixMyApp\Config($yamlParser->parse(file_get_contents(__DIR__.'/config.yml')));

// init database

ORM::configure(array(
    'connection_string' => $_CONFIG->database->connection_string,
    'username' => $_CONFIG->database->username,
    'password' => $_CONFIG->database->password
));

ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// Initialize Silex

$app = new FixMyApp\Application();

if ( $_CONFIG->runtime->debug === true )
{
    $app['debug'] = true;
}

// Register Silex service providers

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/fixmyapp.log',
    'monolog.level' => $_CONFIG->runtime->debug === true ? Monolog\Logger::DEBUG : Monolog\Logger::ERROR,
    'monolog.name' => 'fixmyapp'
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => 'en'
));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new Symfony\Component\Translation\Loader\YamlFileLoader());

    $translator->addResource('yaml', __DIR__.'/locales/en.messages.yml', 'en');
    $translator->addResource('yaml', __DIR__.'/locales/en.errors.yml', 'en');
    $translator->addResource('yaml', __DIR__.'/locales/en.validators.yml', 'en');

    return $translator;
}));

$app->register(new Silex\Provider\HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/../cache/http',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

/* $app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
    )
)); */


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/templates',
    'twig.options' => array(
        'cache' => __DIR__.'/../cache/templates',
        'debug' => true ),
));

$app->register( new Silex\Provider\FormServiceProvider() );
$app->register( new Silex\Provider\ValidatorServiceProvider() );
$app->register( new Silex\Provider\SwiftmailerServiceProvider() );

// Register authentication controller

$app->register( new Silex\Provider\SessionServiceProvider() );

$app->get( '/login', function( Silex\Application $app ) {
    $username = $app['request']->server->get('PHP_AUTH_USER', false);
    $password = $app['request']->server->get('PHP_AUTH_PW');

    if ( 'igor' === $username && 'password' === $password )
    {
        $app['session']->set( 'user', array( 'username' => $username ) );
        $app['monolog']->addInfo(sprintf("User '%s' signed in.", $username));
        return $app->redirect('/');
    }

    $response = new Symfony\Component\HttpFoundation\Response();
    $response->headers->set( "WWW-Authenticate", sprintf('Basic realm="%s"', 'site_login') );
    $response->setStatusCode(401, 'Please sign in');
    return $response;
});

// This is useless in HTTP auth since the browser resend automatically the login/password...

$app->get( '/logout', function( Silex\Application $app ) {

    if ( $user = $app['session']->get('user') )
    {
        $app['session']->clear();
    }

    return $app->redirect('/');
});

$checkLogin = $GLOBALS['checkLogin'] = function() use ($app) {
    if ( null === $user = $app['session']->get('user') )
    {
        return $app->redirect('/login');
    }
};

// define application repositories

$app['users.repository'] = Model::factory('User');
$app['propositions.repository'] = Model::factory('Proposition');
$app['comment.repository'] = Model::factory('Comment');
