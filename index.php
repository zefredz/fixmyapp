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

$user = Model::factory('User')->find_one(1);

echo $twig->render( 'user.html',  array( 'title' => 'Greeting', 'user' => $user ) );
