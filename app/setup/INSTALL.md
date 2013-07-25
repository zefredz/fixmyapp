# How to install

There is no automatic install yet.

To install do the following :

* Install composer (go to [getcomposer.org](http://getcomposer.org) for more details)
* Run 'composer install' from the fixmyapp folder
* Create the following folder : cache/templates and give php the right to write in it
* Execute the install.sql script in your favorite mysql administration tool
* Create a database user for the database and GRANT ALL PRIVILEGES on the fixmyapp tables
* Edit the database configuration in app/config.json
* __test only__ Create some data by executing the test_data.sql script

