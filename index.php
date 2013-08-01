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
    
$app->get( '/', function() use ($twig) {

    return $twig->render( 'index.html', array('title' => __('FixMyApp') , 'baseurl' => BASE_URL ) );

} );

$app->mount( '/user', include __DIR__ . '/app/controllers/user.php' );

$app->run();
