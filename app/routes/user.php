<?php

$userController = $app['controllers_factory'];

$userController->get( '/', function( Silex\Application $app ) {

    $users = $app['users.repository']->find_many();

    return $app['twig']->render( 'userlist.html',  array( 'title' => __('User list'), 'users' => $users, 'baseurl' => BASE_URL ) );

} );

$userController->get( '/{id}', function( Silex\Application $app, $id ) {

    $user = $app['users.repository']->find_one($id);

    if( $user )
    {
        return $app['twig']->render( 'user.html',  array( 'title' => __('User profile'), 'user' => $user, 'baseurl' => BASE_URL ) );
    }
    else
    {
        return $app['twig']->render( 'error.html', array('title' => __('An error occured') , 'error_message' => sprintf(__('User not found %d'), $id ), 'baseurl' => BASE_URL ) );
    }

} ); // ->before( $checkLogin );

return $userController;
