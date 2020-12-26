<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = _DB_HOSTNAME;
$db['default']['username'] = _DB_USERNAME;
$db['default']['password'] = _DB_PASSWORD;
$db['default']['database'] = 'test';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
$db['default']['port']     = 3306;

$db['core']['hostname'] = _DB_HOSTNAME;
$db['core']['username'] = _DB_USERNAME;
$db['core']['password'] = _DB_PASSWORD;
$db['core']['database'] = 'test_1';
$db['core']['dbdriver'] = 'mysqli';
$db['core']['dbprefix'] = '';
$db['core']['pconnect'] = FALSE;
$db['core']['db_debug'] = TRUE;
$db['core']['cache_on'] = FALSE;
$db['core']['cachedir'] = '';
$db['core']['char_set'] = 'utf8';
$db['core']['dbcollat'] = 'utf8_general_ci';
$db['core']['swap_pre'] = '';
$db['core']['autoinit'] = TRUE;
$db['core']['stricton'] = FALSE;
$db['core']['port']     = 3306;

$db['utility_1']['hostname'] = _DB_HOSTNAME;
$db['utility_1']['username'] = _DB_USERNAME;
$db['utility_1']['password'] = _DB_PASSWORD;
$db['utility_1']['database'] = 'test_1';
$db['utility_1']['dbdriver'] = 'mysqli';
$db['utility_1']['dbprefix'] = '';
$db['utility_1']['pconnect'] = FALSE;
$db['utility_1']['db_debug'] = TRUE;
$db['utility_1']['cache_on'] = FALSE;
$db['utility_1']['cachedir'] = '';
$db['utility_1']['char_set'] = 'utf8';
$db['utility_1']['dbcollat'] = 'utf8_general_ci';
$db['utility_1']['swap_pre'] = '';
$db['utility_1']['autoinit'] = TRUE;
$db['utility_1']['stricton'] = FALSE;
$db['utility_1']['port']     = 3306;

$db['utility_2']['hostname'] = _DB_HOSTNAME;
$db['utility_2']['username'] = _DB_USERNAME;
$db['utility_2']['password'] = _DB_PASSWORD;
$db['utility_2']['database'] = 'test_1';
$db['utility_2']['dbdriver'] = 'mysqli';
$db['utility_2']['dbprefix'] = '';
$db['utility_2']['pconnect'] = FALSE;
$db['utility_2']['db_debug'] = TRUE;
$db['utility_2']['cache_on'] = FALSE;
$db['utility_2']['cachedir'] = '';
$db['utility_2']['char_set'] = 'utf8';
$db['utility_2']['dbcollat'] = 'utf8_general_ci';
$db['utility_2']['swap_pre'] = '';
$db['utility_2']['autoinit'] = TRUE;
$db['utility_2']['stricton'] = FALSE;
$db['utility_2']['port']     = 3306;

$db['share_1']['hostname'] = _DB_HOSTNAME;
$db['share_1']['username'] = _DB_USERNAME;
$db['share_1']['password'] = _DB_PASSWORD;
$db['share_1']['database'] = 'test_1';
$db['share_1']['dbdriver'] = 'mysqli';
$db['share_1']['dbprefix'] = '';
$db['share_1']['pconnect'] = FALSE;
$db['share_1']['db_debug'] = TRUE;
$db['share_1']['cache_on'] = FALSE;
$db['share_1']['cachedir'] = '';
$db['share_1']['char_set'] = 'utf8';
$db['share_1']['dbcollat'] = 'utf8_general_ci';
$db['share_1']['swap_pre'] = '';
$db['share_1']['autoinit'] = TRUE;
$db['share_1']['stricton'] = FALSE;
$db['share_1']['port']     = 3306;

$db['admissions']['hostname'] = _DB_HOSTNAME;
$db['admissions']['username'] = _DB_USERNAME;
$db['admissions']['password'] = _DB_PASSWORD;
$db['admissions']['database'] = 'test_1';
$db['admissions']['dbdriver'] = 'mysqli';
$db['admissions']['dbprefix'] = '';
$db['admissions']['pconnect'] = FALSE;
$db['admissions']['db_debug'] = TRUE;
$db['admissions']['cache_on'] = FALSE;
$db['admissions']['cachedir'] = '';
$db['admissions']['char_set'] = 'utf8';
$db['admissions']['dbcollat'] = 'utf8_general_ci';
$db['admissions']['swap_pre'] = '';
$db['admissions']['autoinit'] = TRUE;
$db['admissions']['stricton'] = FALSE;
$db['admissions']['port']     = 3306;

$db['general']['hostname'] = _DB_HOSTNAME;
$db['general']['username'] = _DB_USERNAME;
$db['general']['password'] = _DB_PASSWORD;
$db['general']['database'] = 'test_1';
$db['general']['dbdriver'] = 'mysqli';
$db['general']['dbprefix'] = '';
$db['general']['pconnect'] = FALSE;
$db['general']['db_debug'] = TRUE;
$db['general']['cache_on'] = FALSE;
$db['general']['cachedir'] = '';
$db['general']['char_set'] = 'utf8';
$db['general']['dbcollat'] = 'utf8_general_ci';
$db['general']['swap_pre'] = '';
$db['general']['autoinit'] = TRUE;
$db['general']['stricton'] = FALSE;
$db['general']['port']     = 3306;

/* End of file database.php */
/* Location: ./application/config/database.php */
