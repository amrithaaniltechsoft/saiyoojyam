<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(true);

service('auth')->routes($routes, ['except' => ['login', 'logout', 'auth-actions']]);

$routes->get('login', '\App\Controllers\Admin\Auth::index', ['as' => 'login']);
$routes->post('login', '\App\Controllers\Admin\Auth::login');
$routes->get('logout', '\App\Controllers\Admin\Auth::logout');
$routes->get('/', static function () {
    return redirect()->to('Admin/Home');
});

$routes->match(['GET', 'POST'], 'Checkout', 'Rooms::Checkout');

$routes->get('Room/(:any)', 'Rooms::Detail/$1');

$routes->get('Mission-Vision', 'About::Mission');

$routes->get('terms-and-conditions', 'Terms::index');

$routes->get('rules-and-procedures', 'Rules::index');

$routes->get('kitchen-and-dining', 'Kitchen::index');

$routes->get('Category/(:any)', 'Rooms::Category/$1');

$routes->get('Categories/(:any)', 'Rooms::Categories/$1');

$routes->get('dashboard', static function () {
    return redirect()->to('Admin/Home');
});

$routes->get('Admin/ChangePassword', '\App\Controllers\Admin\ChangePassword::index');
$routes->post('Admin/ChangePassword/updatePassword', '\App\Controllers\Admin\ChangePassword::updatePassword');

$routes->get('Admin/WhyChoose', '\App\Controllers\Admin\WhyChoose::index');
$routes->get('Admin/WhyChoose/Add', '\App\Controllers\Admin\WhyChoose::Add');
$routes->post('Admin/WhyChoose/Add', '\App\Controllers\Admin\WhyChoose::Add');
$routes->get('Admin/WhyChoose/Edit/(:num)', '\App\Controllers\Admin\WhyChoose::Edit/$1');
$routes->post('Admin/WhyChoose/Edit/(:num)', '\App\Controllers\Admin\WhyChoose::Edit/$1');
$routes->get('Admin/WhyChoose/Delete/(:num)', '\App\Controllers\Admin\WhyChoose::Delete/$1');

$routes->get('Admin/About', '\App\Controllers\Admin\About::index');
$routes->get('Admin/About/View', '\App\Controllers\Admin\About::View');
$routes->get('Admin/About/Add', '\App\Controllers\Admin\About::Add');
$routes->post('Admin/About/Add', '\App\Controllers\Admin\About::Add');
$routes->get('Admin/About/Edit/(:num)', '\App\Controllers\Admin\About::Edit/$1');
$routes->post('Admin/About/Edit/(:num)', '\App\Controllers\Admin\About::Edit/$1');
$routes->get('Admin/About/DeleteNetworkImage', '\App\Controllers\Admin\About::DeleteNetworkImage');
$routes->get('Admin/About/DeleteNetworkImage/(:any)', '\App\Controllers\Admin\About::DeleteNetworkImage/$1');
$routes->get('Admin/About/DeleteSectionImage/(:any)', '\App\Controllers\Admin\About::DeleteSectionImage/$1');

$routes->get('Admin/FoodQuality', '\App\Controllers\Admin\FoodQuality::index');
$routes->get('Admin/FoodQuality/View', '\App\Controllers\Admin\FoodQuality::index');
$routes->get('Admin/FoodQuality/Edit', '\App\Controllers\Admin\FoodQuality::Edit');
$routes->get('Admin/FoodQuality/Edit/(:num)', '\App\Controllers\Admin\FoodQuality::Edit/$1');
$routes->post('Admin/FoodQuality/Edit/(:num)', '\App\Controllers\Admin\FoodQuality::Edit/$1');
$routes->post('Admin/FoodQuality/Edit', '\App\Controllers\Admin\FoodQuality::Edit');
$routes->get('Admin/FoodQuality/DeleteGalleryImage/(:any)', '\App\Controllers\Admin\FoodQuality::DeleteGalleryImage/$1');
$routes->get('Admin/FoodQuality/DeleteHeroImage', '\App\Controllers\Admin\FoodQuality::DeleteHeroImage');

$routes->get('Admin/TermsConditions', '\App\Controllers\Admin\TermsConditions::index');
$routes->get('Admin/TermsConditions/View', '\App\Controllers\Admin\TermsConditions::View');
$routes->get('Admin/TermsConditions/Add', '\App\Controllers\Admin\TermsConditions::Add');
$routes->post('Admin/TermsConditions/Add', '\App\Controllers\Admin\TermsConditions::Add');
$routes->get('Admin/TermsConditions/Edit/(:num)', '\App\Controllers\Admin\TermsConditions::Edit/$1');
$routes->post('Admin/TermsConditions/Edit/(:num)', '\App\Controllers\Admin\TermsConditions::Edit/$1');
$routes->get('Admin/TermsConditions/Delete/(:num)', '\App\Controllers\Admin\TermsConditions::Delete/$1');
$routes->get('Admin/TermsConditions/DeletePdf/(:num)', '\App\Controllers\Admin\TermsConditions::DeletePdf/$1');
$routes->get('Admin/TermsConditions/DeletePdf', '\App\Controllers\Admin\TermsConditions::DeletePdf');

$routes->get('Admin/Terms', '\App\Controllers\Admin\TermsConditions::index');
$routes->get('Admin/Terms/Add', '\App\Controllers\Admin\TermsConditions::Add');
$routes->post('Admin/Terms/Add', '\App\Controllers\Admin\TermsConditions::Add');
$routes->get('Admin/Terms/Edit/(:num)', '\App\Controllers\Admin\TermsConditions::Edit/$1');
$routes->post('Admin/Terms/Edit/(:num)', '\App\Controllers\Admin\TermsConditions::Edit/$1');
$routes->get('Admin/Terms/Delete/(:num)', '\App\Controllers\Admin\TermsConditions::Delete/$1');
$routes->get('Admin/Terms/DeletePdf/(:num)', '\App\Controllers\Admin\TermsConditions::DeletePdf/$1');
$routes->get('Admin/Terms/DeletePdf', '\App\Controllers\Admin\TermsConditions::DeletePdf');

$routes->get('Admin/Cms', '\App\Controllers\Admin\Cms::index');
$routes->get('Admin/Cms/Add', '\App\Controllers\Admin\Cms::Add');
$routes->post('Admin/Cms/Add', '\App\Controllers\Admin\Cms::Add');
$routes->get('Admin/Cms/Edit/(:num)', '\App\Controllers\Admin\Cms::Edit/$1');
$routes->post('Admin/Cms/Edit/(:num)', '\App\Controllers\Admin\Cms::Edit/$1');
$routes->get('Admin/Cms/Delete/(:num)', '\App\Controllers\Admin\Cms::Delete/$1');

$routes->get('api/about', '\App\Controllers\Api\About::index');
$routes->get('api/contact', '\App\Controllers\Api\Contact::index');
$routes->get('api/food-quality', '\App\Controllers\Api\FoodQuality::index');
$routes->get('api/why-choose', '\App\Controllers\Api\WhyChoose::index');
$routes->get('api/terms', '\App\Controllers\Api\Terms::index');
$routes->get('api/terms-and-conditions', '\App\Controllers\Api\Terms::index');
$routes->get('api/terms/download/(:num)', '\App\Controllers\Api\Terms::download/$1');
$routes->get('api/terms/download', '\App\Controllers\Api\Terms::download');
$routes->get('api/cms/proprietor', '\App\Controllers\Api\Cms::proprietor');
$routes->get('api/cms', '\App\Controllers\Api\Cms::index');
$routes->get('api/seo', '\App\Controllers\Api\Seo::index');
$routes->get('api/seo/(:any)', '\App\Controllers\Api\Seo::page/$1');
$routes->get('api/building', '\App\Controllers\Api\Building::index');
$routes->get('api/building/(:any)', '\App\Controllers\Api\Building::detail/$1');
$routes->match(['GET', 'POST', 'OPTIONS'], 'api/rooms/check-availability', '\App\Controllers\Api\Rooms::checkAvailability');
$routes->get('api/rooms/room-types', '\App\Controllers\Api\Rooms::roomTypes');
$routes->get('api/rooms', '\App\Controllers\Api\Rooms::index');
$routes->get('api/rooms/(:any)', '\App\Controllers\Api\Rooms::index');
$routes->get('api/room-types', '\App\Controllers\Api\Rooms::roomTypes');
$routes->get('api/room_types', '\App\Controllers\Api\Rooms::roomTypes');

$routes->post('api/auth/send-otp', '\App\Controllers\Api\Auth::sendOtp');
$routes->post('api/auth/verify-otp', '\App\Controllers\Api\Auth::verifyOtp');
$routes->post('api/auth/register-customer', '\App\Controllers\Api\Auth::registerCustomer');
$routes->post('api/auth/login', '\App\Controllers\Api\Auth::login');
$routes->post('api/auth/update-profile', '\App\Controllers\Api\Auth::updateProfile');
$routes->post('api/auth/update-password', '\App\Controllers\Api\Auth::updatePassword');
$routes->options('api/auth/(:any)', '\App\Controllers\Api\Auth::options');
$routes->options('api/auth', '\App\Controllers\Api\Auth::options');
$routes->options('api/(:any)', '\App\Controllers\Api\Auth::options');

$routes->post('Admin/Inmates/ApproveBooking', '\App\Controllers\Admin\Inmates::ApproveBooking');
$routes->post('Admin/Inmates/RejectBooking', '\App\Controllers\Admin\Inmates::RejectBooking');
$routes->match(['GET', 'POST'], 'Admin/Inmates/RegeneratePassword', '\App\Controllers\Admin\Inmates::RegeneratePassword');
$routes->get('Admin/Inmates/Pending', '\App\Controllers\Admin\Inmates::Pending');
$routes->match(['GET', 'POST'], 'Admin/Payments', '\App\Controllers\Admin\Payments::index');
$routes->match(['GET', 'POST'], 'Admin/Payments/View', '\App\Controllers\Admin\Payments::View');
$routes->post('Admin/Payments/PayBalance', '\App\Controllers\Admin\Payments::PayBalance');
$routes->match(['GET', 'POST'], 'Admin/Inmates/CheckOut', '\App\Controllers\Admin\Inmates::CheckOut');
$routes->match(['GET', 'POST'], 'Admin/Inmates/CheckOut/(:num)', '\App\Controllers\Admin\Inmates::CheckOut/$1');
$routes->post('api/checkout', '\App\Controllers\Api\Inmates::create');
$routes->post('api/inmates', '\App\Controllers\Api\Inmates::create');
$routes->get('api/inmates/dashboard', '\App\Controllers\Api\Inmates::dashboard');
$routes->get('api/inmates/dashboard/(:num)', '\App\Controllers\Api\Inmates::dashboard/$1');
$routes->post('api/inmates/pay-rent', '\App\Controllers\Api\Inmates::payRent');
$routes->get('api/inmates/receipt/(:num)', '\App\Controllers\Api\Inmates::receipt/$1');
$routes->get('api/inmates/print/(:num)', '\App\Controllers\Api\Inmates::printReceipt/$1');

$routes->get('Admin/Building/EditWeb/(:num)', '\App\Controllers\Admin\Building::EditWeb/$1');
$routes->post('Admin/Building/EditWeb/(:num)', '\App\Controllers\Admin\Building::EditWeb/$1');
$routes->get('Admin/Building/Deletemore/(:num)', '\App\Controllers\Admin\Building::Deletemore/$1');

$routes->options('api/(:any)', static function () {
    return response()
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setStatusCode(200);
});


