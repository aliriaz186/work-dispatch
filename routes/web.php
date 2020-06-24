<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('route:cache');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    // return what you want
});
Route::get('/', 'AuthController@index');
Route::post('/admin/login', 'AuthController@login');
Route::post('/signout', 'AuthController@signout');
Route::get('dashboard', 'DashboardController@index');
Route::get('profile', 'DashboardController@profile');
Route::post('profile/update', 'DashboardController@updateLogo');
Route::get('technicians', 'TechnicianController@getView');
Route::post('technicians/all', 'TechnicianController@getAll');
Route::get('technicians/new', 'TechnicianController@newTechnicianView');
Route::post('technician/save', 'TechnicianController@saveTechnician');
Route::get('technicians/manage/{id}', 'TechnicianController@manageTechnician');
Route::post('technicians/update', 'TechnicianController@updateTechnician');
Route::get('jobs', 'JobsController@getView');
Route::post('jobs/all', 'JobsController@getAll');
Route::get('jobs/new', 'JobsController@newJobView');
Route::post('job/save', 'JobsController@saveJob');
Route::get('customers', 'CustomerController@getView');
Route::post('customers/all', 'CustomerController@getAll');
Route::get('customers/manage/{id}', 'CustomerController@manage');
Route::post('customer/update', 'CustomerController@update');
Route::get('jobs/{id}/details', 'JobsController@getJobDetails');
Route::get('technicians/{id}/details', 'TechnicianController@getTechnicianDetails');
Route::get('technicians/{id}/jobs/new', 'TechnicianController@addNewJob');
Route::get('workers', 'WorkerController@getWorkerView');
Route::post('workers/all', 'WorkerController@getAll');
Route::get('worker/new', 'WorkerController@newWorker');
Route::post('workers/save', 'WorkerController@saveWorker');
Route::get('workers/manage/{id}', 'WorkerController@editWorker');
Route::post('workers/update', 'WorkerController@updateWorker');

