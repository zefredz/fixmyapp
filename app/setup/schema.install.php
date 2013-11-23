<?php

require_once __DIR__ . '/../init.php';

$schema = $app['db']->getSchemaManager()->createSchema();

// user table

$usersTable = $schema->createTable("user");

$usersTable->addColumn("id", "integer", array("unsigned" => true));
$usersTable->addColumn("firstname", "string", array("length" => 64));
$usersTable->addColumn("lastname", "string", array("length" => 64));
$usersTable->addColumn("email", "string", array("length" => 256));

$usersTable->setPrimaryKey(array("id"));

// authentication

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

$platform = $app['db']->getDatabasePlatform();

$queries = $schema->toSql($platform);

foreach ( $queries as $query ) {
	$app['db']->executeQuery( $query );
}
