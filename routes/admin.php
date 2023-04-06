<?php


Route::group(['namespace' => 'Admin', 'as' => 'admin.'], function () {

//    Route::auth();

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
    //Auth Routes

//    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
//    $this->post('login', 'Auth\LoginController@login');
//    $this->post('logout', 'Auth\LoginController@logout')->name('logout');
//
//    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//    $this->post('register', 'Auth\RegisterController@register');
//
//    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//    $this->post('password/reset', 'Auth\ResetPasswordController@reset');






// password
Route::post('/password/forgot','PasswordResetController@forgotpassword');
Route::get('passwords/reset/{token}/{email}','PasswordResetController@geturl');
Route::post('/passwordchange', 'PasswordResetController@passwordnew');



//Dashboard

Route::get('/dashboard', ['middleware'=>'auth','uses'=>'HomeController@dashboard'])->name('dashboard');


Route::get('/dashboard/openservice', ['as'=>'/dashboard/openservice','uses'=>'HomeController@openservice']);
Route::get('/dashboard/closeservice', ['as'=>'/dashboard/closeservice','uses'=>'HomeController@closeservice']);
Route::get('/dashboard/upservice', ['as'=>'/dashboard/upservice','uses'=>'HomeController@upservice']);
Route::get('/dashboard/open-modal', ['as'=>'/dashboard/open-modal','uses'=>'HomeController@openmodel']);
Route::get('/dashboard/view/com-modal', ['as'=>'/dashboard/view/com-modal','uses'=>'HomeController@closemodel']);
Route::get('/dashboard/view/up-modal', ['as'=>'/dashboard/view/up-modal','uses'=>'HomeController@upmodel']);





//profile

Route::get('setting/profile','Profilecontroller@index');
Route::post('/setting/profile/update/{id}','Profilecontroller@update');
//Purchase
Route::group(['prefix'=>'purchase','middleware'=>'auth'],function(){

Route::get('/add',['as'=>'purchase/add','uses'=>'Purchasecontroller@index']);
Route::post('/store',['as'=>'purchase/store','uses'=>'Purchasecontroller@store']);
Route::get('/list',['as'=>'purchase/list','uses'=>'Purchasecontroller@listview']);
Route::get('/list/pview/{id}',['as'=>'purchase/list','uses'=>'Purchasecontroller@listview1']);
Route::get('/list/edit/{id}',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@editview']);
Route::get('/add/getrecord',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@getrecord']);
Route::get('/producttype/name',['as'=>'purchase/producttype/name','uses'=>'Purchasecontroller@productitem']);
Route::get('/add/getproduct',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@getproduct']);
Route::get('/add/getqty',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@getqty']);
Route::get('/list/delete/{id}',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@destory']);
Route::post('/list/edit/update/{id}',['as'=>'list/edit/update/{id}','uses'=>'Purchasecontroller@update']);
Route::get('/add/getproductname',['as'=>'add/getproductname','uses'=>'Purchasecontroller@getproductname']);
Route::get('deleteproduct',['as'=>'purchase/deleteproduct','uses'=>'Purchasecontroller@deleteproduct']);
Route::get('sale_part/deleteproduct','Purchasecontroller@sale_part_destroy');
Route::get('/list/modalview',['as'=>'/purchase/list/modalview','uses'=>'Purchasecontroller@purchaseview']);

});

//Stoke
Route::group(['prefix'=>'stoke','middleware'=>'auth'],function(){

Route::get('/list',['as'=>'stoke/list','uses'=>'Stockcontroller@index']);
Route::get('/list/edit/{id}',['as'=>'stoke/list/edit','uses'=>'Stockcontroller@edit']);
Route::post('/list/edit/update/{id}',['as'=>'stoke/list/edit/update/{id}','uses'=>'Stockcontroller@update']);
Route::get('/list/stockview',['as'=>'stoke/list/stockview','uses'=>'Stockcontroller@stockview']);
});

// Customer
Route::group(['prefix'=>'customer','middleware'=>'auth'],function(){


Route::get('/add',['as'=>'customer/add','uses'=>'Customercontroller@customeradd']);
Route::post('/store',['as'=>'customer/store','uses'=>'Customercontroller@storecustomer']);
Route::get('/list',['as'=>'customer/list','uses'=>'Customercontroller@index']);
Route::get('/list/{id}',['as'=>'customer/list/{id}','uses'=>'Customercontroller@customershow']);
Route::get('/list/delete/{id}',['as'=>'customer/list/delete/{id}','uses'=>'Customercontroller@destory']);
Route::get('/list/edit/{id}',['as'=>'customer/list/edit/{id}','uses'=>'Customercontroller@customeredit']);
Route::post('/list/edit/update/{id}',['as'=>'customer/list/edit/update/{id}','uses'=>'Customercontroller@customerupdate']);
Route::get('/free-open',['as'=>'customer/free-open','uses'=>'Customercontroller@free_open_model']);
Route::get('/paid-open',['as'=>'/customer/paid-open','uses'=>'Customercontroller@paid_open_model']);
Route::get('/Repeatjob-modal',['as'=>'/customer/Repeatjob-modal','uses'=>'Customercontroller@repeat_job_model']);


// Route::get('/view/modal',['as'=>'/customer/view/modal','uses'=>'Customercontroller@view']);
// Route::get('/view/salesmodal',['as'=>'/customer/view/salesmodal','uses'=>'Customercontroller@salesview']);
// Route::get('/view/com-modal',['as'=>'/customer/view/com-modal','uses'=>'Customercontroller@commodal']);
// Route::get('/view/completedservice',['as'=>'/customer/view/completedservice','uses'=>'Customercontroller@servicecompleted']);
// Route::get('/view/upservice',['as'=>'/customer/view/upservice','uses'=>'Customercontroller@upservice']);
// Route::get('/view/upcomingservice',['as'=>'/customer/view/upcomingservice','uses'=>'Customercontroller@upcomingservice']);

});


Route::group(['prefix'=>'company','middleware'=>'auth'],function(){


    Route::get('/add',['as'=>'company/add','uses'=>'CompanyController@companyadd']);
    Route::post('/store',['as'=>'company/store','uses'=>'CompanyController@storecompany']);
    Route::get('/list',['as'=>'company/list','uses'=>'CompanyController@index']);
    Route::get('/list/{id}',['as'=>'company/list/{id}','uses'=>'CompanyController@customershow']);
    Route::get('/list/delete/{id}',['as'=>'company/list/delete/{id}','uses'=>'CompanyController@destory']);
    Route::get('/list/edit/{id}',['as'=>'company/list/edit/{id}','uses'=>'CompanyController@customeredit']);
    Route::post('/list/edit/update/{id}',['as'=>'company/list/edit/update/{id}','uses'=>'CompanyController@customerupdate']);
    Route::get('/free-open',['as'=>'company/free-open','uses'=>'CompanyController@free_open_model']);
    Route::get('/paid-open',['as'=>'/company/paid-open','uses'=>'CompanyController@paid_open_model']);
    Route::get('/Repeatjob-modal',['as'=>'/company/Repeatjob-modal','uses'=>'CompanyController@repeat_job_model']);


// Route::get('/view/modal',['as'=>'/customer/view/modal','uses'=>'Customercontroller@view']);
// Route::get('/view/salesmodal',['as'=>'/customer/view/salesmodal','uses'=>'Customercontroller@salesview']);
// Route::get('/view/com-modal',['as'=>'/customer/view/com-modal','uses'=>'Customercontroller@commodal']);
// Route::get('/view/completedservice',['as'=>'/customer/view/completedservice','uses'=>'Customercontroller@servicecompleted']);
// Route::get('/view/upservice',['as'=>'/customer/view/upservice','uses'=>'Customercontroller@upservice']);
// Route::get('/view/upcomingservice',['as'=>'/customer/view/upcomingservice','uses'=>'Customercontroller@upcomingservice']);

});

//Accountant
Route::group(['prefix'=>'accountant','middleware'=>'auth'],function(){
Route::get('/add',['as'=>'accountant/add','uses'=>'Accountantcontroller@accountantadd']);
Route::post('/store',['as'=>'accountant/store','uses'=>'Accountantcontroller@storeaccountant']);
Route::get('/list',['as'=>'accountant/list','uses'=>'Accountantcontroller@index']);
Route::get('/list/{id}',['as'=>'accountant/list/{id}','uses'=>'Accountantcontroller@accountantshow']);
Route::get('/list/delete/{id}',['as'=>'accountant/list/delete/{id}','uses'=>'Accountantcontroller@destory']);
Route::get('/list/edit/{id}',['as'=>'accountant/list/edit/{id}','uses'=>'Accountantcontroller@accountantedit']);
Route::post('/list/edit/update/{id}',['as'=>'accountant/list/edit/update/{id}','uses'=>'Accountantcontroller@accountantupdate']);
});


//Sections
Route::group(['prefix'=>'section','middleware'=>'auth'],function(){
    Route::get('/add',['as'=>'section/add','uses'=>'SectionController@sectionadd']);
    Route::post('/store',['as'=>'section/store','uses'=>'SectionController@storesection']);
    Route::get('/list',['as'=>'section/list','uses'=>'SectionController@index']);
    Route::get('/list/delete/{id}',['as'=>'section/list/delete/{id}','uses'=>'SectionController@destory']);
});


//Services
Route::group(['prefix'=>'services','middleware'=>'auth'],function(){
    Route::get('/add',['as'=>'services/add','uses'=>'ServicesController@serviceadd']);
    Route::post('/store',['as'=>'services/store','uses'=>'ServicesController@storeservice']);
    Route::get('/list',['as'=>'services/list','uses'=>'ServicesController@index']);
    Route::get('/list/delete/{id}',['as'=>'services/list/delete/{id}','uses'=>'ServicesController@destory']);
});

//insurance
Route::group(['prefix'=>'insurance','middleware'=>'auth'],function(){
    Route::get('/add',['as'=>'insurance/add','uses'=>'InsuranceController@insuranceadd']);
    Route::post('/store',['as'=>'insurance/store','uses'=>'InsuranceController@storeinsurance']);
    Route::get('/list',['as'=>'insurance/list','uses'=>'InsuranceController@index']);
    Route::get('/list/delete/{id}',['as'=>'insurance/list/delete/{id}','uses'=>'InsuranceController@destory']);
});

//Vehical

Route::group(['prefix'=>'vehicle','middleware'=>'auth'],function(){


	Route::get('/decription',['as'=>'vehical/decription','uses'=>'VehicalControler@decription']);

	Route::get('/add',['as'=>'vehicle/add','uses'=>'VehicalControler@index']);
	Route::post('/store',['as'=>'vehical/store','uses'=>'VehicalControler@vehicalstore']);
	Route::get('/list',['as'=>'vehicle/list','uses'=>'VehicalControler@vehicallist']);
	Route::get('/list/delete/{id}',['as'=>'vehical/list/delete/{id}','uses'=>'VehicalControler@destory']);
	Route::get('list/edit/{id}',['as'=>'vehical/list/edit/{id}','uses'=>'VehicalControler@editvehical']);
	Route::post('list/edit/update/{id}',['as'=>'/vehical/list/edit/update/{id}','uses'=>'VehicalControler@updatevehical']);
	Route::get('/list/view/{id}',['as'=>'vehical/list/view/{id}','uses'=>'VehicalControler@vehicalshow']);
    Route::get('/vehicaltypefrombrand','VehicalControler@vehicaltype');

   //vihical type,brand,fuel,model

	Route::get('vehicle_type_add',['as'=>'vehical/vehicle_type_add','uses'=>'VehicalControler@vehicaltypeadd']);
	Route::get('/vehicaltypedelete',['as'=>'vehical/vehicaltypedelete','uses'=>'VehicalControler@deletevehicaltype']);


	Route::get('vehicle_brand_add',['as'=>'vehical/vehicle_brand_add','uses'=>'VehicalControler@vehicalbrandadd']);
	Route::get('/vehicalbranddelete',['as'=>'/vehical/vehicalbranddelete','uses'=>'VehicalControler@deletevehicalbrand']);


	Route::get('vehicle_fuel_add',['as'=>'vehical/vehicle_fuel_add','uses'=>'VehicalControler@fueladd']);
	Route::get('fueltypedelete',['as'=>'vehical/fueltypedelete','uses'=>'VehicalControler@fueltypedelete']);


	Route::get('add/getDescription','VehicalControler@getDescription');
	Route::get('delete/getDescription','VehicalControler@deleteDescription');
	Route::get('add/getImages','VehicalControler@getImages');
	Route::get('delete/getImages','VehicalControler@deleteImages');
	Route::get('add/getcolor','VehicalControler@getcolor');
	Route::get('delete/getcolor','VehicalControler@deletecolor');

	Route::get('vehicle_model_add','VehicalControler@add_vehicle_model');
	Route::get('vehicle_model_delete','VehicalControler@delete_vehi_model');



});

// vehical type

 Route::group(['prefix'=>'vehicletype','middleware'=>'auth'],function(){

    Route::get('/vehicletypeadd',['as'=>'/vehicletype/add' ,'uses'=>'VehicaltypesControler@index']);
    Route::post('/vehicaltystore',['as'=>'/vehicletype/vehicletystore' ,'uses'=>'VehicaltypesControler@storevehicaltypes']);
    Route::get('/list',['as'=>'/vehical/list' ,'uses'=>'VehicaltypesControler@vehicaltypelist']);
    Route::get('/list/delete/{id}',['as'=>'/vehical/list/delete/{id}' ,'uses'=>'VehicaltypesControler@destory']);
    Route::get('/list/edit/{id}',['as'=>'/vehical/list/edit/{id}' ,'uses'=>'VehicaltypesControler@editvehicaltype']);
    Route::post('/list/edit/update/{id}',['as'=>'/vehical/list/edit/update/{id}' ,'uses'=>'VehicaltypesControler@updatevehicaltype']);


  });

 //vehical brand

  Route::group(['prefix'=>'vehiclebrand','middleware'=>'auth'],function(){

       Route::get('/add',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@index']);
       Route::get('/list',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@listvehicalbrand']);
       Route::post('/store',['as'=>'/vehicalbrand/store','uses'=>'VehicalbransControler@store']);
       Route::get('/list/delete/{id}',['as'=>'/vehicalbrand/list/delete','uses'=>'VehicalbransControler@destory']);
       Route::get('/list/edit/{id}',['as'=>'/vehicalbrand/list/edit/{id}','uses'=>'VehicalbransControler@editbrand']);
       Route::post('/list/edit/update/{id}',['as'=>'/vehicalbrand/list/edit/update{id}','uses'=>'VehicalbransControler@brandupdate']);


  });

// Vehical Discriptions

 Route::group(['prefix'=>'vehicaldiscriptions','middleware'=>'auth'],function(){

 	Route::get('/add',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@index']);
  Route::post('/store',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@vehicalstore']);
  Route::get('/list',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@vehicaldeslist']);
  Route::get('/list/delete/{id}',['as'=>'/vehicaldiscriptions/list/delete/{id}','uses'=>'VehicalDiscriptionsControler@destory']);
   Route::get('/list/edit/{id}',['as'=>'/vehicaldiscriptions/list/edit/{id}','uses'=>'VehicalDiscriptionsControler@editdescription']);
  Route::post('/list/edit/update/{id}',['as'=>'/vehicaldiscriptions/list/edit/update/{id}','uses'=>'VehicalDiscriptionsControler@updatedescription']);
 });


// Payment type

Route::group(['prefix'=>'payment','middleware'=>'auth'],function(){

 Route::get('add',['as'=>'/payment/add','uses'=>'PaymentControler@index']);
 Route::post('store',['as'=>'/payment/store','uses'=>'PaymentControler@paymentstore']);
 Route::get('list',['as'=>'/payment/list','uses'=>'PaymentControler@paymentlist']);
 Route::get('list/delete/{id}',['as'=>'/payment/list/delete/{id}','uses'=>'PaymentControler@destory']);
 Route::get('list/edit/{id}',['as'=>'/payment/list/edit/{id}','uses'=>'PaymentControler@editpayment']);
 Route::post('list/edit/update/{id}',['as'=>'/payment/list/edit/update/{id}','uses'=>'PaymentControler@updatepayment']);

});


//Tax Rates

Route::group(['prefix'=>'taxrates','middleware'=>'auth'],function(){

   Route::get('add',['as'=>'taxrates/add','uses'=>'AccounttaxControler@index']);
   Route::post('store',['as'=>'taxrates/store','uses'=>'AccounttaxControler@store']);
   Route::get('list',['as'=>'taxrates/list','uses'=>'AccounttaxControler@taxlist']);
   Route::get('list/delete/{id}',['as'=>'taxrates/list/delete/{id}','uses'=>'AccounttaxControler@destory']);
   Route::get('list/edit/{id}',['as'=>'taxrates/list/edit/{id}','uses'=>'AccounttaxControler@accountedit']);
   Route::post('list/edit/update/{id}',['as'=>'taxrates/list/edit/update/{id}','uses'=>'AccounttaxControler@updateaccount']);
});


//Services
Route::group(['prefix'=>'service','middleware'=>'auth'],function(){

  Route::get('add',['as'=>'service/add','uses'=>'ServicesControler@index']);
  Route::get('get_vehi_name',['as'=>'service/add','uses'=>'ServicesControler@get_vehicle_name']);
  Route::post('store',['as'=>'service/store','uses'=>'ServicesControler@store']);
  Route::get('list',['as'=>'service/list','uses'=>'ServicesControler@servicelist']);
  Route::get('list/delete/{id}',['as'=>'service/list/delete/{id}','uses'=>'ServicesControler@destory']);
  Route::get('list/edit/{id}',['as'=>'service/list/edit/{id}','uses'=>'ServicesControler@serviceedit']);
  Route::post('list/edit/update/{id}',['as'=>'service/list/edit/update/{id}','uses'=>'ServicesControler@serviceupdate']);
  Route::get('list/view',['as'=>'service/list/view','uses'=>'ServicesControler@serviceview']);
  Route::post('add_jobcard','ServicesControler@add_jobcard');
  Route::get('select_checkpt','ServicesControler@select_checkpt');
  Route::get('get_obs','ServicesControler@Get_Observation_Pts');
  Route::get('used_coupon_data','ServicesControler@Used_Coupon_Data');
  Route::get('getregistrationno','ServicesControler@getregistrationno');

  Route::POST('/customeradd','ServicesControler@customeradd');
  Route::get('/vehicleadd','ServicesControler@vehicleadd');
});

//Invoice

Route::group(['prefix'=>'invoice','middleware'=>'auth'],function(){

	Route::get('/list','InvoiceController@showall');
	Route::get('/add','InvoiceController@index');
	Route::get('/add/{id}','InvoiceController@index');
	Route::get('/sale_part_invoice/add','InvoiceController@sale_part_index');
	Route::get('/sale_part_invoice/add/{id}','InvoiceController@sale_part_index');
	Route::post('/store','InvoiceController@store');
	Route::post('/sale_part_invoice/store','InvoiceController@store');
	Route::get('/get_jobcard_no','InvoiceController@get_jobcard_no');
	Route::get('/get_service_no','InvoiceController@get_service_no');
	Route::get('/get_invoice','InvoiceController@get_invoice');
	Route::get('/list/edit/{id}','InvoiceController@edit');
	Route::post('/list/edit/update/{id}','InvoiceController@update');
	Route::get('/list/delete/{id}','InvoiceController@destroy');
	Route::get('/sales_customer','InvoiceController@sales_customer');
	Route::get('/get_vehicle','InvoiceController@get_vehicle');
	Route::get('/get_part','InvoiceController@get_part');
	Route::get('/get_vehicle_total','InvoiceController@get_vehicle_total');
	Route::get('/pay/{id}','InvoiceController@pay');
	Route::post('/pay/update/{id}','InvoiceController@payupdate');
	Route::get('/payment/paymentview','InvoiceController@paymentview');
	Route::get('/sale_part','InvoiceController@viewSalePart');

});
Route::get('/invoice/servicepdf/{id}','InvoiceController@servicepdf');
Route::get('/invoice/salespdf/{id}','InvoiceController@salespdf');
Route::post('/invoice/stripe','InvoicePaymentController@stripe');
Route::post('/invoice/stripe','InvoicePaymentController@stripe');

//Supllier
Route::group(['prefix'=>'supplier','middleware'=>'auth'],function(){

Route::get('/list','Suppliercontroller@supplierlist');
Route::get('/add','Suppliercontroller@supplieradd');
Route::post('/store','Suppliercontroller@storesupplier');
Route::get('/list/{id}','Suppliercontroller@showsupplier');
Route::get('/list/delete/{id}','Suppliercontroller@destroy');
Route::get('/list/edit/{id}','Suppliercontroller@edit');
Route::post('/list/edit/update/{id}','Suppliercontroller@update');
Route::get('/add_data','Suppliercontroller@adddata');

});

//Change language and timezone and language direction

Route::group(['prefix'=>'setting','middleware'=>'auth'],function(){

Route::get('/list',['as'=>'listlanguage','uses'=>'Languagecontroller@index']);
Route::post('/language/store',['as'=>'storelanguage','uses'=>'Languagecontroller@store']);
Route::get('/timezone/list',['as'=>'timezonelist','uses'=>'Timezonecontroller@index']);
Route::post('/timezone/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@store']);
Route::post('/date/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@datestore']);
//language
Route::get('language/direction/list',['as'=>'listlanguagedirection','uses'=>'Languagecontroller@index1']);
Route::post('language/direction/store',['as'=>'storelanguagedirection','uses'=>'Languagecontroller@store1']);
//accessrights
Route::get('accessrights/list',['as'=>'accessrights/list','uses'=>'Accessrightscontroller@index']);
Route::GET('/accessrights/store',['as'=>'/accessrights/store','uses'=>'Accessrightscontroller@store']);
Route::GET('/accessrights/Employeestore',['as'=>'/accessrights/Employeestore','uses'=>'Accessrightscontroller@Employeestore']);
Route::GET('/accessrights/staffstore',['as'=>'/accessrights/staffstore','uses'=>'Accessrightscontroller@staffstore']);
Route::GET('/accessrights/Accountantstore',['as'=>'/accessrights/Accountantstore','uses'=>'Accessrightscontroller@Accountantstore']);

//general_setting
Route::get('general_setting/list','GeneralController@index');
Route::post('general_setting/store','GeneralController@store');
//hours
Route::get('hours/list','HoursController@index');
Route::post('hours/store','HoursController@hours');
Route::post('holiday/store','HoursController@holiday');
Route::get('deleteholiday/{id}','HoursController@deleteholiday');
Route::get('/deletehours/{id}','HoursController@deletehours');
//currancy
Route::post('currancy/store','Timezonecontroller@currancy');
//custom field
Route::get('/custom/list','Customcontroller@index');
Route::get('custom/add','Customcontroller@add');
Route::post('custom/store','Customcontroller@store');
Route::get('custom/list/edit/{id}','Customcontroller@edit');
Route::post('custom/list/edit/update/{id}','Customcontroller@update');
Route::get('custom/list/delete/{id}','Customcontroller@delete');


});

//Country City State ajax
Route::get('/getstatefromcountry','CountryAjaxcontroller@getstate');
Route::get('/getcityfromstate','CountryAjaxcontroller@getcity');

//employee module
Route::group(['prefix'=>'employee'],function(){
Route::get('/list',['as'=>'listemployeee','uses'=>'employeecontroller@employeelist']);
Route::get('/add',['as'=>'addemployeee','uses'=>'employeecontroller@addemployee']);
Route::post('/store',['as'=>'storeemployeee','uses'=>'employeecontroller@store']);
Route::get('/edit/{id}',['as'=>'editemployeee','uses'=>'employeecontroller@edit']);
Route::patch('/edit/update/{id}','employeecontroller@update');
Route::get('/view/{id}','employeecontroller@showemployer');
Route::get('/list/delete/{id}',['as'=>'/employee/list/delete/{id}','uses'=>'employeecontroller@destory']);
Route::get('/free_service',['as'=>'/employee/free_service','uses'=>'employeecontroller@free_service']);
Route::get('/paid_service',['as'=>'/employee/paid_service','uses'=>'employeecontroller@paid_service']);
Route::get('/repeat_service',['as'=>'/employee/repeat_service','uses'=>'employeecontroller@repeat_service']);
});


//Support Staff Module
Route::group(['prefix'=>'supportstaff'],function(){
Route::get('/list',['as'=>'listsupportstaff','uses'=>'Supportstaffcontroller@index']);
Route::get('/add',['as'=>'supportstaff','uses'=>'Supportstaffcontroller@supportstaffadd']);
Route::post('/store',['as'=>'supportstaff','uses'=>'Supportstaffcontroller@store_supportstaff']);
Route::get('list/edit/{id}',['as'=>'supportstaff','uses'=>'Supportstaffcontroller@edit']);
Route::post('/list/edit/update/{id}',['as'=>'supportstaff/list/edit/update/{id}','uses'=>'Supportstaffcontroller@update']);
Route::get('/list/delete/{id}',['as'=>'/supportstaff/list/delete/{id}','uses'=>'Supportstaffcontroller@destory']);
Route::get('/list/{id}',['as'=>'supportstaff/list/{id}','uses'=>'Supportstaffcontroller@supportstaff_show']);

});

//Product List Module

Route::group(['prefix'=>'product'],function(){
Route::get('/list',['as'=>'listproduct','uses'=>'Productcontroller@index']);
Route::get('/list/{id}',['as'=>'listproduct','uses'=>'Productcontroller@indexid']);
Route::get('/add',['as'=>'addproduct','uses'=>'Productcontroller@addproduct']);
Route::post('/store',['as'=>'storeproduct','uses'=>'Productcontroller@store']);
Route::get('/list/edit/{id}',['as'=>'editproduct','uses'=>'Productcontroller@edit']);
Route::post('/list/edit/update/{id}',['as'=>'updateproduct','uses'=>'Productcontroller@update']);
Route::get('/list/delete/{id}',['as'=>'deleteproduct','uses'=>'Productcontroller@destroy']);
Route::get('/unit',['as'=>'product/unit','uses'=>'Productcontroller@unitadd']);
Route::get('/unitdelete',['as'=>'product/unitdelete','uses'=>'Productcontroller@unitdelete']);
});

Route::get('/product_type_add','Productcontroller@addproducttype');
Route::get('/prodcttypedelete','Productcontroller@deleteproducttype');
Route::get('/color_name_add','Productcontroller@coloradd');
Route::get('/colortypedelete','Productcontroller@colordelete');
Route::get('/supplier/product/{id}', ['middleware'=>'auth','uses'=>'Suppliercontroller@data']);


//Color List Module

Route::group(['prefix'=>'color'],function(){
Route::get('/list',['as'=>'listcolor','uses'=>'Colorcontroller@index']);
Route::get('/add',['as'=>'addcolor','uses'=>'Colorcontroller@addcolor']);
Route::post('/store',['as'=>'storecolor','uses'=>'Colorcontroller@store']);
Route::get('/list/delete/{id}','Colorcontroller@destroy');
Route::get('/list/edit/{id}','Colorcontroller@edit');
Route::post('/list/edit/update/{id}','Colorcontroller@update');
});

//RTO List Module

Route::group(['prefix'=>'rto'],function(){
Route::get('/list',['as'=>'listrto','uses'=>'Rtocontroller@index']);
Route::get('/add',['as'=>'addrto','uses'=>'Rtocontroller@addrto']);
Route::post('/store',['as'=>'storerto','uses'=>'Rtocontroller@store']);
Route::get('/list/delete/{id}','Rtocontroller@destroy');
Route::get('/list/edit/{id}','Rtocontroller@edit');
Route::post('/list/edit/update/{id}','Rtocontroller@update');
});

//Mail Formate Module

Route::group(['prefix'=>'mail'],function(){
Route::get('/mail',['as'=>'usermail','uses'=>'Mailcontroller@index']);
Route::post('/mail/emailformat/{id}',['as'=>'/emailformat/{id}','uses'=>'Mailcontroller@emailupadte']);

Route::get('/user',['as'=>'usermail','uses'=>'Mailcontroller@user']);
Route::get('/sales',['as'=>'salesmail','uses'=>'Mailcontroller@sales']);
Route::get('/services',['as'=>'servicessmail','uses'=>'Mailcontroller@services']);
});

//Sales formate module

Route::group(['prefix'=>'sales'],function(){
Route::get('/list',['as'=>'listsales','uses'=>'Salescontroller@index']);
Route::get('/add',['as'=>'addsales','uses'=>'Salescontroller@addsales']);
Route::post('/store',['as'=>'storesales','uses'=>'Salescontroller@store']);
Route::get('/list/modal',['as'=>'salesview','uses'=>'Salescontroller@view']);
Route::get('/list/delete/{id}','Salescontroller@destroy');
Route::get('/list/edit/{id}','Salescontroller@edit');
Route::post('/list/edit/update/{id}','Salescontroller@update');
Route::get('/add/getrecord','Salescontroller@getrecord');

Route::get('/add/getchasis','Salescontroller@getchasis');
Route::get('/add/getmodel_name','Salescontroller@getmodel_name');

Route::get('/edit/getrecord','Salescontroller@getrecord');
Route::get('/edit/getchasis','Salescontroller@getchasis');
Route::get('/edit/getmodel_name','Salescontroller@getmodel_name');

Route::get('/add/getqty','Salescontroller@getqty');
Route::get('/add/getservices','Salescontroller@getservices');
Route::get('/add/gettaxes','Salescontroller@gettaxes');
Route::get('/add/gettaxespercentage','Salescontroller@gettaxespercentage');

Route::get('/color_name_add','Salescontroller@coloradd');
Route::get('/colortypedelete','Salescontroller@colordelete');
});


//Job Card Module

Route::group(['prefix'=>'jobcard'],function(){
Route::get('/list',['as'=>'list/jobcard','uses'=>'JobCardcontroller@index']);
Route::get('/list/jview/{id}',['as'=>'list/jview','uses'=>'JobCardcontroller@indexid']);
Route::get('/list/{id}',['as'=>'viewjobcard','uses'=>'JobCardcontroller@view']);
Route::get('/add',['as'=>'addjobcard','uses'=>'JobCardcontroller@jobcard_add']);

Route::post('/store',['as'=>'jobcard/store','uses'=>'JobCardcontroller@store']);
Route::get('/gatepass',['as'=>'jobcard/gatepass','uses'=>'JobCardcontroller@gatepass']);
Route::post('/insert_gatedata',['as'=>'jobcard/insert','uses'=>'JobCardcontroller@insert_gatepass_data']);
Route::get('/list/add_invoice/{id}','JobCardcontroller@add_invoice');

});
Route::get('/observation','JobCardcontroller@addobservation');
Route::get('/jobcard/addproducts','JobCardcontroller@addproducts');
Route::get('/jobcard/getprice','JobCardcontroller@getprice');
Route::get('/jobcard/gettotalprice','JobCardcontroller@gettotalprice');
Route::get('/jobcard/modalview','JobCardcontroller@modalview');
Route::get('/jobcard/gatepass/autofill_data','JobCardcontroller@getrecord');
Route::get('/jobcard/gatepass/{id}','JobCardcontroller@gatedata');
Route::get('/jobcard/add/getrecord','JobCardcontroller@getpoint');

Route::get('/jobcard/addcheckpoint','JobCardcontroller@pointadd');
Route::get('/jobcard/addcheckresult','JobCardcontroller@addcheckresult');
Route::get('/jobcard/commentpoint','JobCardcontroller@commentpoint');
Route::get('/jobcard/list/modalget','JobCardcontroller@getview');
Route::get('/getpassdetail','JobCardcontroller@getpassinvoice');
Route::get('/jobcard/select_checkpt','JobCardcontroller@select_checkpt');
Route::get('/jobcard/get_obs','JobCardcontroller@Get_Observation_Pts');
Route::get('/jobcard/delete_on_reprocess','JobCardcontroller@delete_on_reprocess');
Route::get('/jobcard/oth_pro_delete','JobCardcontroller@oth_pro_delete');
Route::get('//jobcard/stocktotal','JobCardcontroller@stocktotal');

//getpass
Route::group(['prefix'=>'gatepass'],function(){

Route::get('/list',['as'=>'gatepass/list','uses'=>'Getpasscontroller@index']);
Route::get('/add',['as'=>'gatepass/list','uses'=>'Getpasscontroller@addgatepass']);
Route::get('/list/delete/{id}',['as'=>'/gatepass/list/delete/{id}','uses'=>'Getpasscontroller@delete']);
Route::post('/store',['as'=>'gatepass/list','uses'=>'Getpasscontroller@store']);
Route::get('/list/edit/{id}',['as'=>'/gatepass/list/edit/','uses'=>'Getpasscontroller@edit']);
Route::post('/list/edit/upadte/{id}',['as'=>'/gatepass/list/edit/update','uses'=>'Getpasscontroller@upadte']);
Route::get('/gatepassview',['as'=>'/gatepass//gatepassview','uses'=>'Getpasscontroller@gatepassview']);
Route::get('/gatedata',['as'=>'/gatepass/gatedata','uses'=>'Getpasscontroller@gatedata']);
});

//Observation Type  Module

Route::group(['prefix'=>'observation_type'],function(){
Route::get('/list',['as'=>'listobservationtype','uses'=>'ObservationTypecontroller@index']);
Route::get('/add',['as'=>'addobservationtype','uses'=>'ObservationTypecontroller@addobservation']);
Route::post('/store',['as'=>'storerto','uses'=>'ObservationTypecontroller@store']);
Route::get('/list/delete/{id}','ObservationTypecontroller@destroy');
Route::get('/list/edit/{id}','ObservationTypecontroller@edit');
Route::post('/list/edit/update/{id}','ObservationTypecontroller@update');
});

//Observation Point  Module

Route::group(['prefix'=>'observation_point'],function(){
Route::get('/list',['as'=>'listobservation','uses'=>'ObservationPointcontroller@index']);
Route::get('/add',['as'=>'addobservation','uses'=>'ObservationPointcontroller@addobservation']);
Route::post('/store',['as'=>'storerto','uses'=>'ObservationPointcontroller@store']);
Route::get('/list/delete/{id}','ObservationPointcontroller@destroy');
Route::get('/list/edit/{id}','ObservationPointcontroller@edit');
Route::post('/list/edit/update/{id}','ObservationPointcontroller@update');
});

//Checkpoint Module

Route::get('/observation/list','CheckpointController@showall');
Route::get('/observation/add','CheckpointController@index');
Route::post('/observation/store','CheckpointController@store');
Route::get("/deleteuser","CheckpointController@destroy");
Route::get("/editcheckpoin","CheckpointController@edit");
Route::get("/submitnewname","CheckpointController@updatedata");
Route::get("/newcategory","CheckpointController@add_category");

//Income Module

Route::group(['prefix'=>'income'],function(){

Route::get('/list','IncomeController@showall');
Route::get('/add','IncomeController@index');
Route::post('/store','IncomeController@store');
Route::get('/edit/{id}','IncomeController@edit');
Route::post('/update/{id}','IncomeController@update');
Route::get('/delete/{id}','IncomeController@destroy');
Route::get('/month_income','IncomeController@monthly_income');
Route::post('/income_report','IncomeController@get_month_income');
});

//Expenses Module
Route::group(['prefix'=>'expense'],function(){

Route::get('/list','ExpenseController@showall');
Route::get('/add','ExpenseController@index');
Route::post('/store','ExpenseController@store');
Route::get('/edit/{id}','ExpenseController@edit');
Route::post('/update/{id}','ExpenseController@update');
Route::get('/delete/{id}','ExpenseController@destroy');
Route::get('/month_expense','ExpenseController@monthly_expense');
Route::post('/expense_report','ExpenseController@get_month_expense');
});

//Report Module

Route::group(['prefix'=>'report'],function(){

Route::get('/salesreport','Reportcontroller@sales');
Route::post('/record_sales','Reportcontroller@record_sales');
Route::get('/servicereport','Reportcontroller@service');
Route::post('/record_service','Reportcontroller@record_service');
Route::get('/productreport','Reportcontroller@product');
Route::get('/producttype/name','Reportcontroller@producttype');
Route::post('/record_product','Reportcontroller@record_product');
Route::get('/productuses','Reportcontroller@productuses');
Route::post('/uses_product','Reportcontroller@uses_product');
Route::get('/stock/modalview','Reportcontroller@modalview');
Route::get('/stock/modalviewPart','Reportcontroller@modalviewPart');
Route::get('/servicebyemployee','Reportcontroller@servicebyemployee');
Route::post('/employeeservice','Reportcontroller@employeeservice');

});

//Sales Part
Route::get('/sales_part/list','SalesPartcontroller@index');
Route::get('/sales_part/add','SalesPartcontroller@addsales');
Route::get('/sales_part/edit/{id}','SalesPartcontroller@edit');
Route::get('/sales_part/delete/{id}','SalesPartcontroller@destroy');
Route::post('/sales_part/edit/update/{id}','SalesPartcontroller@update');
Route::post('/sales_part/store','SalesPartcontroller@store');
Route::get('/sales_part/getprice','SalesPartcontroller@getmodel_name');
Route::get('/sales_part/list/modal','SalesPartcontroller@view');
Route::get('/sales_part/add/getproductname','SalesPartcontroller@getproductname');
Route::get('/sale_part/deleteproduct','SalesPartcontroller@sale_part_destroy');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Clear Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
});
