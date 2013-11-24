<?php

$installController = $app['controllers_factory'];

$installController->get( '/', function( \Silex\Application $app ) {

	$schema = $app['db']->getSchemaManager()->createSchema();

	$platform = $app['db']->getDatabasePlatform();

	if ( ! $schema->hasTable('user') )
	{
		$usersTable = $schema->createTable("user");

		$usersTable->addColumn("id", "integer", array("unsigned" => true));
		$usersTable->addColumn("firstname", "string", array("length" => 64));
		$usersTable->addColumn("lastname", "string", array("length" => 64));
		$usersTable->addColumn("email", "string", array("length" => 256));

		$usersTable->setPrimaryKey(array("id"));
	}
	else
	{
		$schema->dropTable('user');
	}

	// authentication

	if ( ! $schema->hasTable('authentication') )
	{
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
	}
	else
	{
		$schema->dropTable('authentication');
	}

	// role

	if ( ! $schema->hasTable('role') )
	{

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
	}
	else
	{
		$schema->dropTable('role');
	}

	$queries = $schema->toSql($platform);
	
	foreach ( $queries as $query ) {
		$app['db']->executeQuery( $query );
	}

	return $app->render( 'install.twig',  array( 'title' => $app['translator']->trans('Install'), 'queries' => $queries ) );
} );

return $installController;
