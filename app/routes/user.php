<?php

$userController = $app['controllers_factory'];

$userController->get( '/', function( Silex\Application $app ) {

    $users = $app['users.repository']->find_many();

    return $app['twig']->render( 'userlist.html',  array( 'title' => $app['translator']->trans('User list'), 'users' => $users, 'baseurl' => BASE_URL ) );

} );

$userController->get( '/{id}', function( Silex\Application $app, $id ) {

    $user = $app['users.repository']->find_one($id);

    if( $user )
    {
        return $app['twig']->render( 'user.html',  array( 'title' => $app['translator']->trans('User profile'), 'user' => $user, 'baseurl' => BASE_URL ) );
    }
    else
    {
        return $app['twig']->render( 'error.html', array('title' => $app['translator']->trans('An error occured') , 'error_message' => $app['translator']->trans('User not found %user_id%', array( '%user_id%' => $id ) ), 'baseurl' => BASE_URL ) );
    }

} ); // ->before( $checkLogin );

return $userController;
