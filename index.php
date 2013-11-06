<?php

require_once __DIR__ . '/app/init.php';

// test 
/*
    $user = Model::factory('User')->create();
    $user->firstname = 'Paris';
    $user->lastname = 'Carlton';
    $user->email = 'paris.carlton@example.com';
    $user->save();
*/
    
$app->get( '/', function( \Silex\Application $app ) {

    return $app->render( 'index.twig', array('title' => $app->trans('FixMyApp') ) );

} )->bind('homepage');

$app->mount( '/user', include __DIR__ . '/app/routes/user.php' );

$app->run();
