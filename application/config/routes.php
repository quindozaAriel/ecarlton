<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Page';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['migrate']['GET'] = 'Migrate/do_migration';

//PAGES
$route['login']['GET'] = 'Page/login';
$route['dashboard']['GET'] = 'Page/dashboard';
$route['resident']['GET'] = 'Page/resident';
$route['reservation']['GET'] = 'Page/reservation';
$route['monthly-due']['GET'] = 'Page/monthly_due';
$route['notification']['GET'] = 'Page/notification';
$route['masterlist']['GET'] = 'Page/masterlist';
$route['admin']['GET'] = 'Page/admin';

//ADMIN LOGIN
$route['login']['POST'] = 'Login/verify';
$route['logout']['GET'] = 'Login/logout';

//ADMIN
$route['admin-list']['GET'] = 'Admin/get';
$route['admin/(:any)']['GET'] = 'Admin/read/$1';
$route['admin']['POST'] = 'Admin/insert';
$route['admin/(:any)']['PATCH'] = 'Admin/update/$1';
$route['admin/(:any)']['DELETE'] = 'Admin/delete/$1';
$route['admin-residence']['POST'] = 'Admin/add_residence';
$route['admin-residence']['GET'] = 'Admin/load_residence';

//RESIDENT
$route['resident-list']['GET'] = 'Resident/get';
$route['resident/(:any)']['GET'] = 'Resident/read/$1';
$route['resident']['POST'] = 'Resident/insert';
$route['resident/(:any)']['PATCH'] = 'Resident/update/$1';
$route['resident/(:any)']['DELETE'] = 'Resident/delete/$1';
$route['load-phase']['GET'] = 'Resident/load_phase';
$route['load-lot/(:any)']['GET'] = 'Resident/load_lot/$1';
$route['load-block/(:any)']['GET'] = 'Resident/load_block/$1';

//MONTHLY
$route['monthly']['GET'] = 'Monthly/get';
$route['monthly/(:any)']['GET'] = 'Monthly/read/$1';
$route['monthly']['POST'] = 'Monthly/insert';
$route['monthly/(:any)']['PATCH'] = 'Monthly/update/$1';
$route['monthly/(:any)']['DELETE'] = 'Monthly/delete/$1';
$route['monthly-payment']['POST'] = 'Monthly/load_payment_history';
$route['monthly-due-bills']['GET'] = 'Monthly/load_due_bills';

//NOTIFICATION
$route['notification-list']['GET'] = 'Notification/get';
$route['notification']['POST'] = 'Notification/insert';
$route['notification/(:any)']['GET'] = 'Notification/read/$1';
$route['notification/(:any)']['PATCH'] = 'Notification/update/$1';
$route['notification/(:any)']['DELETE'] = 'Notification/delete/$1';
$route['notification-all']['GET'] = 'Notification/load_all_notification';

//AMENITY
$route['amenities-list']['GET'] = 'Amenities/get';
$route['amenities']['POST'] = 'Amenities/insert';
$route['amenities/(:any)']['GET'] = 'Amenities/read/$1';
$route['amenities/(:any)']['PATCH'] = 'Amenities/update/$1';
$route['amenities/(:any)']['DELETE'] = 'Amenities/delete/$1';

//RESERVATION
$route['reservation-history']['GET'] = 'Reservation/load_reservation_history';

//MOBILE

//LOGIN
$route['mobile-login']['GET'] = 'Page/mobile_login_page';
$route['mobile-login']['POST'] = 'Login/verify_mobile_login';


//PAGES
$route['mobile-home']['GET'] = 'Page/mobile_home_page';
$route['mobile-bills']['GET'] = 'Page/mobile_bills_page';
$route['mobile-reservation']['GET'] = 'Page/mobile_reservation_page';
$route['mobile-notification']['GET'] = 'Page/mobile_notification_page';
$route['mobile-messages']['GET'] = 'Page/mobile_messages_page';
$route['mobile-profile']['GET'] = 'Page/mobile_profile_page';

//PROFILE
$route['mobile-profile-change-password/(:any)']['PATCH'] = 'Profile/update_password/$1';
$route['mobile-profile-change-image']['POST'] = 'Profile/update_image';

//NOTIFICATION
$route['realtime-notification']['GET'] = 'Notification/realtime_retrieving';

//RESERVATION
$route['reservation-availability/(:any)/(:any)/(:any)/(:any)']['GET'] = 'Reservation/load_availability/$1/$2/$3/$4';
$route['reservation-load-amenity/(:any)']['GET'] = 'Reservation/load_amenity_reservation/$1';
$route['reservation']['POST'] = 'Reservation/insert';
$route['my_reservation']['GET'] = 'Reservation/my_reservation';

//BILLS
$route['bills']['GET'] = 'Bills/get';
$route['bills-transaction-history']['GET'] = 'Bills/transaction_history';
$route['bills']['POST'] = 'Bills/insert';


//HOME
$route['check-notification']['GET'] = 'Home/check_notification';
