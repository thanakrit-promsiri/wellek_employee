<?php
Route::get('/', function() {
  if(!empty($credential = Session::get('authenticate'))) {
    if($credential -> emp_role == 2) {
      return redirect('/quality-control');
    } else if($credential -> emp_role == 4) {
      return redirect('/transfer-to-container');
    } else if($credential -> emp_role == 6) {
      return redirect('/export-bill');
    } else if($credential -> emp_role == 9) {
      return redirect('/customers-management');
    } else if($credential -> emp_role == 10) {
      return redirect('/quality-control-reject');
    } else {
      return redirect('/main-menu');
    }
  } else {
    return view('login');
  }
});
Route::post('/checklogin', 'CredentialController@checklogin');
Route::get('/logout', 'CredentialController@logout');

Route::middleware('checklogin') -> group(function() {
  Route::get('/main-menu', 'MainMenuController@main');
  Route::middleware('openbill') -> group(function() {
    Route::resource('open-bill', 'OpenBillController');
    Route::get('/open-bill/create/report', 'OpenBillController@index');
    Route::get('/open-bill/create/insert', 'OpenBillController@insert');
    Route::get('/open-bill/create/edit', 'OpenBillController@edit');
  });
  Route::middleware('qualitycontrol') -> group(function() {
    Route::resource('quality-control', 'QualityControlControler');
    Route::resource('quality-control-wait-to-pack', 'QualityControlWaittopackController');
    // Route::resource('quality-control-end-to-pack', 'QualityControlFinishtopackController');
    Route::resource('quality-control-finish', 'QualityControlFinishtosendController');
    Route::get('quality-control-rejects', 'QualityControlRejectController@index_qc');
    Route::post('quality-control-rejects-update', 'QualityControlRejectController@update_reject');
  });
  Route::middleware('reject') -> group(function() {
    Route::resource('quality-control-reject', 'QualityControlRejectController');
  });
  Route::middleware('saleadmin') -> group(function() {
    Route::get('/export-bill', 'SaleAdminController@exportBill');
    Route::get('/confirm-to-transport', 'SaleAdminController@confirmTrans');
    Route::get('/report-bill', 'SaleAdminController@reportBill');
    // Route::get('/update-bill', 'SaleAdminController@updateBill');
    // Route::get('/update-bill-send-item', 'SaleAdminController@updateBillSendItem');
    // Route::get('/transport-bill', 'SaleAdminController@transportBill');
  });
  Route::middleware('administrator') -> group(function() {
    Route::get('/customers-management', 'AdminController@customerIndex');
    Route::post('/customers-insert-data', 'AdminController@customerInsertData');
    Route::get('/employee-management', 'AdminController@employeeIndex');
    Route::post('/employee-insert-data', 'AdminController@employeeInsertData');
    Route::post('/change-pass-data', 'AdminController@changePassData');
  });
  Route::middleware('transport') -> group(function() {
    Route::get('/transfer-to-container', 'TransportController@transferToCon');
    Route::get('/update-bill', 'TransportController@updateBill');
    Route::get('/update-bill-send-item', 'TransportController@updateBillSendItem');
    Route::get('/transport-bill', 'TransportController@transportBill');
    Route::post('/save-transport-bill', 'TransportController@saveTransportBill');
  });
});

// Export PDF
Route::get('/open-bill-report', 'ExportPDFController@openBillReport');
Route::get('/qc-label', 'ExportPDFController@QcLabel');
Route::get('/qc-label-get-one-page', 'ExportPDFController@QcLabelGetOnePage');
Route::get('/export-bill-preparation', 'ExportPDFController@ExportBillPreparation');
Route::get('/export-bill-workorder', 'ExportPDFController@ExportBillWorkOrder');

// Ajax Request //
Route::get('/ajax/autocomplete-get-route', 'AjaxRequestController@autocompleteGetRoute');
Route::get('/ajax/autocomplete-get-customer', 'AjaxRequestController@autocompleteGetCustomer');
Route::get('/ajax/autocomplete-get-new-route', 'AjaxRequestController@autocompleteGetNewRoute');
Route::get('/ajax/autocomplete-get-new-customer', 'AjaxRequestController@autocompleteGetNewCustomer');
Route::get('/ajax/request-from-route', 'AjaxRequestController@requestFromRoute');
// Route::get('/ajax/request-from-customer', 'AjaxRequestController@requestFromCustomer');
Route::get('/ajax/validate-packer-id', 'AjaxRequestController@ValidatePackerId');
Route::get('/ajax/validate-driver-code', 'AjaxRequestController@ValidateDriverCode');
Route::get('/ajax/validate-driver-lift-code', 'AjaxRequestController@ValidateDriverLiftCode');
Route::get('/ajax/request-bill-detail-edit', 'AjaxRequestController@requestEditBillDetail');
Route::get('/ajax/validate-final-bill-code', 'AjaxRequestController@validateFinalBillCode');
Route::post('/ajax/save-final-bill-data', 'AjaxRequestController@saveFinalBillData');
Route::post('/ajax/update-final-bill-data', 'AjaxRequestController@updateFinalBillData');
Route::post('/ajax/request-bill-detail-edit-bill_description', 'AjaxRequestController@EditBillDescription');
Route::post('/ajax/request-reject', 'AjaxRequestController@saveReject');
Route::post('/ajax/update-transfer-to-container', 'AjaxRequestController@updateTransferToCon');
Route::get('/ajax/get-role-short-code', 'AjaxRequestController@getRoleShortCode');
Route::get('/ajax/check-emp-code', 'AjaxRequestController@checkEmpCode');
Route::get('/ajax/old-pass-check', 'AjaxRequestController@oldPassCheck');
// Route::post('/ajax/request-bill-detail-edit-form', 'AjaxRequestController@requestEditBillDetailForm');
// Route::post('/ajax/request-bill-detail-zoom', 'AjaxRequestController@requestZoomBillDetail');
// Route::post('/ajax/request-final-bill-code', 'AjaxRequestController@requestFinalBillCode');
// Route::post('/ajax/request-bill-detail-edit-qc', 'AjaxRequestController@EditQCBillDetail');
