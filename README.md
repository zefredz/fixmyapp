fixmyapp
========

__WORK IN PROGRESS__ At this time this application is mainly a test of the involved technologies...

Web application to submit and vote for feature requests. 

## Requirements

* PHP 5.3+, PDO and Mysql driver for PDO
* [Composer](http://getcomposer.org)
* MySQL 5+ (or MariaDB) with InnoDB support

## Install

There is no install script yet...

To install FixMyApp :

* Run 'composer install' from the fixmyapp folder
* Create the following folder : cache/templates and give php the right to write in it
* Execute the install.sql script in your favorite mysql administration tool
* Create a database user for the database and GRANT ALL PRIVILEGES on the fixmyapp tables
* Edit the database configuration in app/config.json

## Proposition worflow

1. Feature request/suggest submission and vote by the users
2. Choice of feature to be implemented based on the votes of the users
3. Roadmap and development progress display

## Main goals

* Create a community of users
* Empower users by giving them the power to influence the developement and evolution of an application
* Enhance transparency in the decision making about the evolution of an application

