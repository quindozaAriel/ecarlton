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
$route['monthly-payment-spec']['POST'] = 'Monthly/load_payment_history_spec';
$route['monthly-due-bills']['GET'] = 'Monthly/load_due_bills';
$route['monthly-sales-per-month']['GET'] = 'Monthly/load_sales_per_month';

//NOTIFICATION
$route['notification-list']['GET'] = 'Notification/get';
$route['notification']['POST'] = 'Notification/insert';
$route['notification/(:any)']['GET'] = 'Notification/read/$1';
$route['notification/(:any)']['PATCH'] = 'Notification/update/$1';
$route['notification/(:any)']['DELETE'] = 'Notification/delete/$1';
$route['notification-all']['GET'] = 'Notification/load_all_notification';
$route['notification-per-month']['GET'] = 'Notification/load_notification_per_month';



//AMENITY
$route['amenities-list']['GET'] = 'Amenities/get';
$route['amenities']['POST'] = 'Amenities/insert';
$route['amenities/(:any)']['GET'] = 'Amenities/read/$1';
$route['amenities/(:any)']['PATCH'] = 'Amenities/update/$1';
$route['amenities/(:any)']['DELETE'] = 'Amenities/delete/$1';

//RESERVATION
$route['reservation-history']['GET'] = 'Reservation/load_reservation_history';
$route['reservation-request']['GET'] = 'Reservation/load_reservation_request';
$route['reservation-action/(:any)/(:any)']['PATCH'] = 'Reservation/request_action/$1/$2';
$route['reservation-pending']['GET'] = 'Reservation/load_pending_reservation';
$route['reservation-per-month']['GET'] = 'Reservation/load_reservation_per_month';
$route['reservation-sales-per-month']['GET'] = 'Reservation/load_sales_per_month';
$route['reservation-for-payment']['GET'] = 'Reservation/load_forpayment_reservation';
$route['reject-reservation']['POST'] = 'Reservation/reject_request';
$route['view-reason/(:any)']['GET'] = 'Reservation/view_reason/$1';
$route['approve-reservation/(:any)']['GET'] = 'Reservation/approve_request/$1';
$route['reserved-reservation']['GET'] = 'Reservation/load_reserved_reservation';
$route['cancel-request']['POST'] = 'Reservation/cancel_request';

//MOBILE

//LOGIN
$route['mobile-login']['GET'] = 'Page/mobile_login_page';
$route['mobile-login']['POST'] = 'Login/verify_mobile_login';


//PAGES
$route['mobile-home']['GET'] = 'Page/mobile_home_page';
$route['mobile-bills']['GET'] = 'Page/mobile_bills_page';
$route['mobile-bills/(:any)']['GET'] = 'Page/mobile_bills_page';
$route['mobile-reservation']['GET'] = 'Page/mobile_reservation_page';
$route['mobile-notification']['GET'] = 'Page/mobile_notification_page';
$route['mobile-messages']['GET'] = 'Page/mobile_messages_page';
$route['mobile-profile']['GET'] = 'Page/mobile_profile_page';
// $route['mobile-paymode']['GET'] = 'Page/paymode';
$route['mobile-gcash-success']['GET'] = 'Page/gcash_success';
$route['mobile-gcash-error']['GET'] = 'Page/gcash_error';
$route['mobile-gcash-hook']['GET'] = 'Page/gcash_hook';


//PROFILE
$route['mobile-profile-change-password/(:any)']['PATCH'] = 'Profile/update_password/$1';
$route['mobile-profile-change-image']['POST'] = 'Profile/update_image';

//NOTIFICATION
$route['realtime-notification']['GET'] = 'Notification/realtime_retrieving';
$route['load-numbers']['GET'] = 'Notification/load_numbers';

//RESERVATION
$route['reservation-availability/(:any)/(:any)/(:any)/(:any)']['GET'] = 'Reservation/load_availability/$1/$2/$3/$4';
$route['reservation-load-amenity/(:any)']['GET'] = 'Reservation/load_amenity_reservation/$1';
$route['reservation']['POST'] = 'Reservation/insert';
$route['my_reservation']['GET'] = 'Reservation/my_reservation';
$route['pay-reservation']['POST'] = 'Reservation/pay_reservation';
$route['check-reservation']['POST'] = 'Reservation/check_reservation';
$route['request-cancellation']['POST'] = 'Reservation/request_cancellation';



//BILLS
$route['bills']['GET'] = 'Bills/get';
$route['bills-transaction-history']['GET'] = 'Bills/transaction_history';
$route['bills']['POST'] = 'Bills/insert';


//HOME
$route['check-notification']['GET'] = 'Home/check_notification';
$route['check-bills']['GET'] = 'Home/check_bills';
$route['check-reservation']['GET'] = 'Home/check_reservation';


//CRON JOB
$route['record-occasional-due-bills']['GET'] = 'Standby/check_occasional_due_bills';
$route['record-due-bills']['GET'] = 'Standby/check_due_bills';
$route['cron-job']['GET'] = 'Standby/cronJob';

//tracker
$route['create-tracker']['POST'] = 'Bills/create_tracker';


$route['manual_payment']['POST'] = 'Monthly/manual_payment';


$route['resident-bills']['GET'] = 'Page/resident_bill';
$route['resident-bill']['GET'] = 'ResidentBill/get';
$route['resident-bill-spec/(:any)']['GET'] = 'ResidentBill/read/$1';
$route['resident-bill']['POST'] = 'ResidentBill/insert';
$route['resident-bill/(:any)']['PATCH'] = 'ResidentBill/update/$1';
$route['resident-bill/(:any)']['DELETE'] = 'ResidentBill/delete/$1';
$route['get-bill/(:any)']['GET'] = 'ResidentBill/get_bills/$1';
$route['resident_manual_payment']['POST'] = 'ResidentBill/manual_payment';