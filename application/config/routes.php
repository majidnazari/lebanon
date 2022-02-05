<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "dashboard";
//$route['scaffolding_trigger'] = "";


// BEGIN AUTHENTICATION LIBRARY ROUTES
$route['p403'] = "home/p403";
$route['parameters/industrial-room'] = "parameters/industrial_room";
$route['parameters/company-types'] = "parameters/company_types";
$route['parameters/economical-union'] = "parameters/economical_union";
$route['parameters/industrial-group'] = "parameters/industrial_group";
$route['parameters/economical-assembly'] = "parameters/economical_assembly";
$route['parameters/license-sources'] = "parameters/license_sources";
$route['parameters/insurance-activities'] = "parameters/insurance_activities";
$route['parameters/importer-activities'] = "parameters/importer_activities";
$route['parameters/company-markets'] = "parameters/company_markets";

$route['products'] = "home/products";
$route['login'] = "home/login";
$route['lostpassword'] = "home/lostpassword";
$route['services'] = "home/services";
$route['aboutus'] = "home/aboutus";
$route['contact'] = "home/contact";
$route['guides'] = "home/guides";
$route['conditions'] = "home/conditions";
$route['logout'] = "home/logout";
$route['register'] = "home/register";

$route['users/change-password/(:any)'] = "users/change_password/$1";
$route['users/group-edit/(:any)'] = "users/group_edit/$1";
$route['users/group-create'] = "users/group_create";
$route['banks/branch-create/(:any)'] = "banks/branch_create/$1";
$route['banks/branch-edit/(:any)'] = "banks/branch_edit/$1";
$route['banks/branch-details/(:any)'] = "banks/branch_details/$1";

$route['insurances/branch-create/(:any)'] = "insurances/branch_create/$1";
$route['insurances/branch-edit/(:any)'] = "insurances/branch_edit/$1";
$route['insurances/branch-details/(:any)'] = "insurances/branch_details/$1";
$route['importers/foreign-companies/(:any)'] = "importers/foreign_companies/$1";
$route['transportations/branch-create/(:any)'] = "transportations/branch_create/$1";
$route['transportations/branch-edit/(:any)'] = "transportations/branch_edit/$1";

$route['reports/index_production'] = "reports/index-production";
$route['reports/updated-companies-ar'] = "reports/updated_companies_ar";
$route['reports/updated-companies-en'] = "reports/updated_companies_en";
$route['companies/app-details/(:any)'] = "companies/app_details/$1";

$route['companies/reset-advertisment'] = "companies/reset_advertisment";
$route['companies/reset-reservations'] = "companies/reset_reservations";
$route['companies/put-online'] = "companies/put_online";
$route['companies/put-offline'] = "companies/put_offline";
$route['companies/branch-create/(:any)'] = "companies/branch_create/$1";
$route['companies/branch-edit/(:any)'] = "companies/branch_edit/$1";
$route['companies/branch-details/(:any)'] = "companies/branch_details/$1";

$route['logs/company-details/(:any)'] = "logs/company_details/$1";
$route['logs/bank-details/(:any)'] = "logs/bank_details/$1";
$route['logs/insurance-details/(:any)'] = "logs/insurance_details/$1";
$route['logs/importer-details/(:any)'] = "logs/importer_details/$1";
$route['logs/transportation-details/(:any)'] = "logs/transportation_details/$1";

$route['tasks/district-view/(:any)'] = "tasks/district_view/$1";
$route['tasks/area-grid'] = "tasks/area_grid";
$route['tasks/print-list'] = "tasks/print_list";
$route['tasks/print-details'] = "tasks/print_details";
$route['tasks/print-list-acc'] = "tasks/print_list_acc";
$route['tasks/print-details-acc'] = "tasks/print_details_acc";

$route['tasks/area-list'] = "tasks/area_list";
$route['tasks/area-list-acc'] = "tasks/area_list_acc";
$route['tasks/district-list'] = "tasks/district_list";
$route['tasks/district-list-acc'] = "tasks/district_list_acc";







//$route['admin'] = "admin/index";
//$route['admin/careers'] = "admin/admin/careers";
//$route['admin/edit_status'] = "admin/admin/edit_status";
// END AUTHENTICATION LIBRARY ROUTESs

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */