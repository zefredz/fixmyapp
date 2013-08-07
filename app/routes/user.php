<?php

$userController = $app['controllers_factory'];

$userController->get( '/', function( Silex\Application $app ) {

    $users = $app['users.repository']->find_many();

    return $app['twig']->render( 'user.list.html',  array( 'title' => $app['translator']->trans('User list'), 'users' => $users, 'baseurl' => BASE_URL ) );

} );

$userController->match( '/new', function( Silex\Application $app ) {

    $data = array(
        'firstname' => 'Your first name',
        'lastname' => 'Your last name',
        'email' => 'Your email',
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->setAction(BASE_URL.'/user/new')
        ->add('firstname')
        ->add('lastname')
        ->add('email', 'email' )
        ->getForm();

    if ( 'POST' === $app['request']->getMethod() )
    {
        $form->bind($app['request']);

        if ($form->isValid()) 
        {
            $user = $app['users.repository']->create();
            $user->hydrate($form->getData());
            $user->save();

            return $app->redirect('/user/'.$user->id);

        }
        else
        {
            throw new Exception('Invalid data supplied to form');
        }
    }

    return $app['twig']->render('user.new.html', array( 'title' => $app['translator']->trans('New user'), 'form' => $form->createView(), 'baseurl' => BASE_URL ) );

} )->before( $checkLogin ); // adding users requires login

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

} )->assert('id', '\d+');

return $userController;
