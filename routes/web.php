<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

//Route::get('/test', 'ForgotPasswordController@our_backup_database')->name('test');
// Route::get('/test', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'our_backup_database']);
Route::get('/test', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'testing']);

Route::get('/', function () {
    return view('auth.login');
})->name('login.page');


Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/lang/{locale}', 'HomeController@lang');


// DICOM Patients
Route::get('/dicom/patient/all', 'DICOMPatientController@all')->name('dicom.patient.all');
Route::post('/search/dicom/patient', 'DICOMPatientController@search')->name('search.dicom.patient');
//**********************************ORGANIZE STUDY FEATURE***************************************
    Route::get('/dicom/patient/all/list', 'DICOMPatientController@all_patient_list')->name('dicom.patient.all.list');
    Route::get('/dicom/patient/studies/{id}', 'DICOMPatientController@patient_studies')->name('dicom.patient.studies');
    Route::get('/search/patient', 'DICOMPatientController@search_patient')->name('search.patient');
//**********************************ORGANIZE STUDY FEATURE***************************************

Route::get('/view/dicom/patient/{id}/{study_insta?}/{reportId?}', 'DICOMPatientController@view_patient')->name('dicom.patient.view');

// Route::get('/patient/studies/view/{id}', 'DICOMPatientController@patient_studies')->name('dicom.patient.studies');
Route::get('/patient/print/report/{id}', 'DICOMPatientController@patient_print_report')->name('dicom.report.print');
// Route::get('/view/dicom/patient/{id}', 'DICOMPatientController@enter_result')->name('dicom.patient.view');
Route::post('/patient/generate/findings', 'DICOMPatientController@generate_findings')->name('generate.findings');
Route::post('/dicom/patient/enter_result','DICOMPatientController@enter_result')->name('enter.result');
Route::post('/dicom/patient/getExam/{id)','DICOMPatientController@getExam')->name('dicom.getexam');
Route::get('/download/dicom/folder/{id}','DICOMPatientController@download_dicom_folder')->name('dicom.download.folder');
Route::get('/view/dcm/file/{id}/{studyIns}','DICOMPatientController@view_dcm_file')->name('dicom.dcm.file');

Route::get('/view/report/popup/{id}/{studyIns}','DICOMPatientController@view_report_popup')->name('report.popup');


//Patients
Route::get('/patient/create/{id?}', 'PatientController@create')->name('patient.create')->middleware(['role_or_permission:Admin|add patient']);
Route::post('/patient/create', 'PatientController@store')->name('patient.store');


// REsults
Route::get('/result/all/', 'ResultController@all_reports')->name('reports.all');

Route::post('/result/create',[
    'as' => 'patient.result.store',
    'uses' => 'ResultController@store'
]);
Route::get('/result/view/{id}', 'ResultController@view')->name('dicom.result.view');
Route::get('/result/update_result/{id}', 'DICOMPatientController@update_result')->name('dicom.view_modality');



Route::get('/patient/all', 'PatientController@all')->name('patient.all')->middleware(['role_or_permission:Admin|view all patients']);

Route::get('/patient/view/{id}', 'PatientController@view')->where('id', '[0-9]+')->name('patient.view')->middleware(['role_or_permission:Admin|view patient']);
Route::get('/patient/edit/{id}', 'PatientController@edit')->where('id', '[0-9]+')->name('patient.edit')->middleware(['role_or_permission:Admin|edit patient']);
Route::post('/patient/edit', 'PatientController@store_edit')->name('patient.store_edit');

Route::get('/patient/delete/{id}', 'PatientController@destroy')->where('id', '[0-9]+')->name('patient.destroy')->middleware(['role_or_permission:Admin|delete patient']);

Route::post('/patient/search', 'PatientController@search')->name('patient.search');

//Documents
Route::get('/document/all', 'DocumentController@all')->name('document.all')->middleware(['role_or_permission:Admin|edit patient']);
Route::post('/document/create', 'DocumentController@store')->name('document.store')->middleware(['role_or_permission:Admin|edit patient']);
Route::get('/document/delete/{id}','DocumentController@destroy')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|edit patient']);

//Documents
Route::post('/history/create', 'HistoryController@store')->name('history.store')->middleware(['role_or_permission:Admin|edit patient']);
Route::get('/history/delete/{id}','HistoryController@destroy')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|edit patient']);

//Appointments
Route::get('/appointment/create', 'AppointmentController@create')->name('appointment.create')->middleware(['role_or_permission:Admin|create appointment']);
Route::post('/appointment/create', 'AppointmentController@store')->name('appointment.store');
Route::get('/appointment/all', 'AppointmentController@all')->name('appointment.all')->middleware(['role_or_permission:Admin|view all appointments']);
Route::get('/appointment/calendar', 'AppointmentController@calendar')->name('appointment.calendar')->middleware(['role_or_permission:Admin|view all appointments']);
Route::get('/appointment/pending', 'AppointmentController@pending')->name('appointment.pending')->middleware(['role_or_permission:Admin|view all appointments']);
Route::get('/appointment/checkslots/{id}','AppointmentController@checkslots');
Route::get('/appointment/delete/{id}','AppointmentController@destroy')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|delete appointment']);
Route::post('/appointment/edit', 'AppointmentController@store_edit')->name('appointment.store_edit')->middleware(['role_or_permission:Admin|edit appointment']);

//Drugs
Route::get('/drug/create', 'DrugController@create')->name('drug.create')->middleware(['role_or_permission:Admin|create drug']);
Route::post('/drug/create', 'DrugController@store')->name('drug.store');
Route::get('/drug/edit/{id}', 'DrugController@edit')->where('id', '[0-9]+')->name('drug.edit')->middleware(['role_or_permission:Admin|edit drug']);
Route::post('/drug/edit', 'DrugController@store_edit')->name('drug.store_edit');
Route::get('/drug/all', 'DrugController@all')->name('drug.all')->middleware(['role_or_permission:Admin|view all drugs']);
Route::get('/drug/delete/{id}','DrugController@destroy')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|delete drug']);


//Tests
Route::get('/test/create', 'TestController@create')->name('test.create')->middleware(['role_or_permission:Admin|create diagnostic test']);
Route::post('/test/create', 'TestController@store')->name('test.store');
Route::get('/test/edit/{id}', 'TestController@edit')->name('test.edit')->middleware(['role_or_permission:Admin|edit diagnostic test']);
Route::post('/test/edit', 'TestController@store_edit')->name('test.store_edit');
Route::get('/test/all', 'TestController@all')->name('test.all')->middleware(['role_or_permission:Admin|view all diagnostic tests']);
Route::get('/test/delete/{id}', 'TestController@destroy')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|delete diagnostic test']);

//Prescriptions
Route::get('/prescription/create', 'PrescriptionController@create')->name('prescription.create')->middleware(['role_or_permission:Admin|create prescription']);
Route::post('/prescription/create', 'PrescriptionController@store')->name('prescription.store');
Route::get('/prescription/all', 'PrescriptionController@all')->name('prescription.all')->middleware(['role_or_permission:Admin|view all prescriptions']);
Route::get('/prescription/view/{id}', 'PrescriptionController@view')->where('id', '[0-9]+')->name('prescription.view')->middleware(['role_or_permission:Admin|view prescription']);
Route::get('/prescription/pdf/{id}','PrescriptionController@pdf')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|print prescription']);
Route::get('/prescription/delete/{id}','PrescriptionController@destroy')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|delete prescription']);
Route::get('/prescription/user/{id}', 'PrescriptionController@view_for_user')->where('id', '[0-9]+')->name('prescription.view_for_user')->middleware(['role_or_permission:Admin|view patient']);

Route::get('/prescription/edit/{id}','PrescriptionController@edit')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|edit prescription']);
Route::post('/prescription/update', 'PrescriptionController@update')->name('prescription.update');

//Billing
Route::get('/billing/create', 'BillingController@create')->name('billing.create')->middleware(['role_or_permission:Admin|create invoice']);
Route::post('/billing/create', 'BillingController@store')->name('billing.store');
Route::get('/billing/all', 'BillingController@all')->name('billing.all')->middleware(['role_or_permission:Admin|view all invoices']);
Route::get('/billing/view/{id}', 'BillingController@view')->where('id', '[0-9]+')->name('billing.view')->middleware(['role_or_permission:Admin|view invoice']);
Route::get('/billing/pdf/{id}','BillingController@pdf')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|print invoice']);
Route::get('/billing/delete/{id}','BillingController@destroy')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|delete invoice']);
Route::get('/billing/edit/{id}','BillingController@edit')->where('id', '[0-9]+')->middleware(['role_or_permission:Admin|edit invoice']);
Route::post('/billing/update', 'BillingController@update')->name('billing.update');

//Settings
/* Doctorino Settings */
Route::get('/settings/doctorino_settings', 'SettingController@doctorino_settings')->name('doctorino_settings.edit');
Route::post('/settings/doctorino_settings', 'SettingController@doctorino_settings_store')->name('doctorino_settings.store');
/* Prescription Settings */
Route::get('/settings/prescription_settings', 'SettingController@prescription_settings')->name('prescription_settings.edit');
Route::post('/settings/prescription_settings', 'SettingController@prescription_settings_store')->name('prescription_settings.store');

/* SMS Settings */
Route::get('/settings/sms_settings', 'SettingController@sms_settings')->name('sms_settings.edit');
Route::post('/settings/sms_settings', 'SettingController@sms_settings_store')->name('sms_settings.store');

/* Users */
Route::get('/users/all', 'UsersController@all')->name('user.all');
Route::get('/users/create', 'UsersController@create')->name('user.create');
Route::post('/users/create', 'UsersController@store')->name('user.store');
Route::get('/users/edit/{id}', 'UsersController@edit')->where('id', '[0-9]+')->name('user.edit');
Route::get('/users/edit', 'UsersController@edit_profile')->name('user.edit_profile');
Route::post('/users/edit', 'UsersController@store_edit')->name('user.store_edit');
/* Roles */
Route::get('/roles/all', 'RolesController@all_roles')->name('roles.all')->middleware(['role_or_permission:Admin']);
Route::get('/role/create', 'RolesController@create')->name('role.create')->middleware(['role_or_permission:Admin']);
Route::post('/role/create', 'RolesController@store')->name('role.store');
Route::get('/role/edit/{id}', 'RolesController@edit_role')->where('id', '[0-9]+')->name('role.edit_role')->middleware(['role_or_permission:Admin']);
Route::post('/role/edit', 'RolesController@store_edit_role')->name('role.store_edit_role');
Route::get('/role/delete/{id}','RolesController@destroy')->where('id', '[0-9]+')->name('role.destroy')->middleware(['role_or_permission:Admin']);
