<?php

$userController = $app['controllers_factory'];

$userController->get( '/', function( Silex\Application $app ) {

    $users = $app['users.repository']->find_many();

    return $app->render( 'user.list.html',  array( 'title' => $app['translator']->trans('User list'), 'users' => $users ) );

} );

$userController->match( '/new', function( Silex\Application $app ) {

    $data = array(
        'firstname' => 'Your first name',
        'lastname' => 'Your last name',
        'email' => 'Your email',
    );

    $form = $app->form($data)
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

    return $app->render('user.new.html', array( 'title' => $app->trans('New user'), 'form' => $form->createView() ) );

} ); //->before( $checkLogin ); // adding users requires login

$userController->get( '/{id}', function( Silex\Application $app, $id ) {

    $user = $app['users.repository']->find_one($id);

    if( $user )
    {
        return $app->render( 'user.html',  array( 'title' => $app->trans('User profile'), 'user' => $user ) );
    }
    else
    {
        return $app->render( 'error.html', array('title' => $app->trans('An error occured') , 'error_message' => $app->trans('User not found %user_id%', array( '%user_id%' => $id ) ) ) );
    }

} )->assert('id', '\d+');

return $userController;
