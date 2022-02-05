<?php
/**
* Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://adamgriffiths.co.uk
* @version 1.0.6
* @copyright Adam Griffiths 2009
*
* Auth provides a powerful, lightweight and simple interface for user authentication 
*/


/**
* The array which holds your user groups and their ID.
* If you have a database table for groups, these ID's must be the same as in the database.
*/
$config['auth_groups'] = array(
							'dashboard' => '1',
							'companies' => '2',
							'banks' => '6',
							'insurances' => '9',
							'imports' => '13',
							'transportations' => '17',
							'employees' => '13',
							'clients' => '14',
							'registrations' => '15',
							'users' => '16',
							'settings' => '17',
							'invoices' => '18',
							'reports' => '19',	
							'parameters' => '38',
							'items' => '48',
							'logs' => '71',	
							'news' => '95',
    'magazines'=>'107',
    'delivery'=>'113',
    'sales'=>'111',
							);

/**
* The default URI string to redirect to after a successful login.
*/
$config['auth_login'] = 'dashboard';

/**
* The default URI string to redirect to after a successful logout.
*/
$config['auth_logout'] = 'login';

/**
* The URI string to redirect to when a user entered incorrect login details or is not authenticated
*/
$config['auth_incorrect_login'] = 'login';


/**
* bool TRUE / FALSE
* Determines whether or not users will be remembered by the auth library
*/
$config['auth_remember'] = TRUE;

/**
* The following options provide the ability to easily rename the directories
* for your auth views, models, and controllers.
*
* Remember to also update your routes file if you change the controller directory
* MUST HAVE A TRAILING SLASH!
*/
$config['auth_controllers_root'] = 'admin/';
$config['auth_models_root'] = '';
$config['auth_views_root'] = 'auth/';
 
/**
* Set the names for your user tables below (sans prefix, which will be automatically added)
* ex.: your table is named `ci_users` with 'ci_' defined as your dbprefix in config/database.php, so set it to 'users' below
*/
$config['auth_user_table'] = 'users';
$config['auth_group_table'] = 'groups';

?>