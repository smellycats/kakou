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
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7.
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

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = 'root';
$db['default']['database'] = 'kakou';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_bin';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['test_db']['hostname'] = 'localhost';
$db['test_db']['username'] = 'root';
$db['test_db']['password'] = '';
$db['test_db']['database'] = 'cgs';
$db['test_db']['dbdriver'] = 'mysql';
$db['test_db']['dbprefix'] = '';
$db['test_db']['pconnect'] = TRUE;
$db['test_db']['db_debug'] = TRUE;
$db['test_db']['cache_on'] = FALSE;
$db['test_db']['cachedir'] = '';
$db['test_db']['char_set'] = 'utf8';
$db['test_db']['dbcollat'] = 'utf8_bin';
$db['test_db']['swap_pre'] = '';
$db['test_db']['autoinit'] = TRUE;
$db['test_db']['stricton'] = FALSE;

/*
//$db['oracle_db']['hostname'] = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.1.15)(PORT=1521))(CONNECT_DATA=(SID=orcl)))';
$db['oracle_db']['hostname'] = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521))(CONNECT_DATA=(SID=kakou)))';
$db['oracle_db']['username'] = 'kakou';
$db['oracle_db']['password'] = 'kakou';
$db['oracle_db']['database'] = '';
$db['oracle_db']['dbdriver'] = 'oci8';
//$db['oracle_db']['port'] = '1521';
$db['oracle_db']['dbprefix'] = '';
$db['oracle_db']['pconnect'] = TRUE;
$db['oracle_db']['db_debug'] = FALSE;
$db['oracle_db']['cache_on'] = FALSE;
$db['oracle_db']['cachedir'] = '';
$db['oracle_db']['char_set'] = 'ZHS16GBK';
$db['oracle_db']['dbcollat'] = 'gbk_chinese_ci';
$db['oracle_db']['swap_pre'] = '';
$db['oracle_db']['autoinit'] = TRUE;
$db['oracle_db']['stricton'] = FALSE;
*/

$db['logo_db']['hostname'] = '127.0.0.1';
$db['logo_db']['username'] = 'root';
$db['logo_db']['password'] = 'root';
$db['logo_db']['database'] = 'vehicle_logo';
$db['logo_db']['dbdriver'] = 'mysql';
$db['logo_db']['dbprefix'] = '';
$db['logo_db']['pconnect'] = TRUE;
$db['logo_db']['db_debug'] = TRUE;
$db['logo_db']['cache_on'] = FALSE;
$db['logo_db']['cachedir'] = '';
$db['logo_db']['char_set'] = 'utf8';
$db['logo_db']['dbcollat'] = 'utf8_bin';
$db['logo_db']['swap_pre'] = '';
$db['logo_db']['autoinit'] = TRUE;
$db['logo_db']['stricton'] = FALSE;

$db['cgs_db']['hostname'] = '127.0.0.1';
$db['cgs_db']['username'] = 'kakou';
$db['cgs_db']['password'] = 'kakou';
$db['cgs_db']['database'] = 'cgs';
$db['cgs_db']['dbdriver'] = 'mysql';
$db['cgs_db']['dbprefix'] = '';
$db['cgs_db']['pconnect'] = TRUE;
$db['cgs_db']['db_debug'] = TRUE;
$db['cgs_db']['cache_on'] = FALSE;
$db['cgs_db']['cachedir'] = '';
$db['cgs_db']['char_set'] = 'utf8';
$db['cgs_db']['dbcollat'] = 'utf8_bin';
$db['cgs_db']['swap_pre'] = '';
$db['cgs_db']['autoinit'] = TRUE;
$db['cgs_db']['stricton'] = FALSE;

$db['sms_db']['hostname'] = 'localhost';
$db['sms_db']['username'] = 'root';
$db['sms_db']['password'] = '';
$db['sms_db']['database'] = 'sms';
$db['sms_db']['dbdriver'] = 'mysql';
$db['sms_db']['dbprefix'] = '';
$db['sms_db']['pconnect'] = TRUE;
$db['sms_db']['db_debug'] = TRUE;
$db['sms_db']['cache_on'] = FALSE;
$db['sms_db']['cachedir'] = '';
$db['sms_db']['char_set'] = 'gbk';
$db['sms_db']['dbcollat'] = 'gbk_bin';
$db['sms_db']['swap_pre'] = '';
$db['sms_db']['autoinit'] = TRUE;
$db['sms_db']['stricton'] = FALSE;
/* End of file database.php */
/* Location: ./application/config/database.php */