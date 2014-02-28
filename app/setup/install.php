<?php

$installController = $app['controllers_factory'];

$installController->get( '/', function( \Silex\Application $app ) {

	$schema = $app['db']->getSchemaManager()->createSchema();

	$platform = $app['db']->getDatabasePlatform();
	
	$dropNeeded = false;
	
	if ( $schema->hasTable('user') )
	{
	    $schema->dropTable('user');
	    $dropNeeded = true;
	}

	$usersTable = $schema->createTable("user");

	$usersTable->addColumn("id", "integer", array("unsigned" => true,"autoincrement" => true));
	$usersTable->addColumn("firstname", "string", array("length" => 64));
	$usersTable->addColumn("lastname", "string", array("length" => 64));
	$usersTable->addColumn("email", "string", array("length" => 256));

	$usersTable->setPrimaryKey(array("id"));

	// authentication
	
	if ( $schema->hasTable('authentication') )
	{
	    $schema->dropTable('authentication');
	    $dropNeeded = true;
	}

	
	$loginTable = $schema->createTable("authentication");

	$loginTable->addColumn("user_id", "integer", array("unsigned" => true));
	$loginTable->addColumn("username", "string", array("length" => 64));
	$loginTable->addColumn("password", "string", array("length" => 64));

	$loginTable->addUniqueIndex(array("username"));

	$loginTable->setPrimaryKey(array("user_id"));

	$loginTable->addForeignKeyConstraint(
		$usersTable, 
	    array("user_id"), 
	    array("id"), 
	    array("onDelete" => "CASCADE")
	);
	
	// role
	if ( $schema->hasTable('role') )
	{
		$schema->dropTable('role');
		$dropNeeded = true;
	}

	$roleTable = $schema->createTable("role");

	$roleTable->addColumn("user_id", "integer", array("unsigned" => true));
	$roleTable->addColumn("role", "string", array("length" => 64));

	$roleTable->setPrimaryKey(array("user_id"));

	$roleTable->addForeignKeyConstraint(
		$usersTable, 
	    array("user_id"), 
	    array("id"), 
	    array("onDelete" => "CASCADE")
	);
    
    if ( $dropNeeded )
    {
	    $dropQueries = $schema->toDropSql($platform);
	
	    // var_dump($dropQueries);die();
	
	    foreach ( $dropQueries as $query ) {
		    $app['db']->executeQuery( $query );
	    }
	}

	$createQueries = $schema->toSql($platform);
	
	foreach ( $createQueries as $query ) {
		$app['db']->executeQuery( $query );
	}
	
	// $queries = array_merge($dropQueries, $createQueries);

	return $app->render( 'install.twig',  array( 'title' => $app['translator']->trans('Install'), 'queries' => $createQueries ) );
} );

return $installController;
