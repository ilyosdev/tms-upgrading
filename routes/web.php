<?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\View;

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


    Route::get('/', ['uses' => 'App\Http\Controllers\HomeController@index', 'as' => 'home']);

    Route::group(['middleware' => 'auth'], function () {

        Route::get('user', function () {
            return View::make('admin.user.profile');
        });

        //Clients
        Route::get('clients', ['uses' => 'App\Http\Controllers\ClientController@index', 'as' => 'getClients']);
        Route::get('vehicles', ['uses' => 'App\Http\Controllers\VehicleController@index', 'as' => 'getVehicles']);
        Route::get('transport', ['uses' => 'App\Http\Controllers\TransportController@index', 'as' => 'getTransport']);
        Route::get('payments', ['uses' => 'App\Http\Controllers\PaymentController@index', 'as' => 'getPayments']);
        Route::get('expenses', ['uses' => 'App\Http\Controllers\ExpenseController@index', 'as' => 'getExpenses']);

        Route::get('client/{id}/report', ['uses' => 'App\Http\Controllers\ClientController@showReport', 'as' => 'showClientReport']);
        Route::get('vehicle/{id}/report', ['uses' => 'App\Http\Controllers\VehicleController@showReport', 'as' => 'showVehicleReport']);

        Route::get('client/{id}/delete', ['uses' => 'App\Http\Controllers\ClientController@destroy', 'as' => 'deleteClient']);
        Route::get('client/{id}/edit', ['uses' => 'App\Http\Controllers\ClientController@edit', 'as' => 'getEditClient']);
        Route::get('client/add', ['uses' => 'App\Http\Controllers\ClientController@create', 'as' => 'getAddClient']);

        Route::get('payment/{id}/delete', ['uses' => 'App\Http\Controllers\PaymentController@destroy', 'as' => 'deletePayment']);
        Route::get('payment/{id}/edit', ['uses' => 'App\Http\Controllers\PaymentController@edit', 'as' => 'getEditPayment']);
        Route::get('payment/add', ['uses' => 'App\Http\Controllers\PaymentController@create', 'as' => 'getAddPayment']);

        Route::get('expense/{id}/delete', ['uses' => 'App\Http\Controllers\ExpenseController@destroy', 'as' => 'deleteExpense']);
        Route::get('expense/{id}/edit', ['uses' => 'App\Http\Controllers\ExpenseController@edit', 'as' => 'getEditExpense']);
        Route::get('expense/add', ['uses' => 'App\Http\Controllers\ExpenseController@create', 'as' => 'getAddExpense']);

        Route::get('vehicle/{id}/delete', ['uses' => 'App\Http\Controllers\VehicleController@destroy', 'as' => 'deleteVehicle']);
        Route::get('vehicle/{id}/edit', ['uses' => 'App\Http\Controllers\VehicleController@edit', 'as' => 'getEditVehicle']);
        Route::get('vehicle/add', ['uses' => 'App\Http\Controllers\VehicleController@create', 'as' => 'getAddVehicle']);

        Route::get('transport/{id}/delete', ['uses' => 'App\Http\Controllers\TransportController@destroy', 'as' => 'deleteTransport']);
        Route::get('transport/{id}/edit', ['uses' => 'App\Http\Controllers\TransportController@edit', 'as' => 'getEdit']);
        Route::get('newTransport', ['uses' => 'App\Http\Controllers\TransportController@create', 'as' => 'getAddTransport']);
        Route::get('editTransport/{id}', ['uses' => 'App\Http\Controllers\TransportController@edit', 'as' => 'getEditTransport']);


        // LOGOUT
        Route::get('logout', ['uses' => 'App\Http\Controllers\UserController@logout', 'as' => 'signout']);

        Route::group(['before' => 'csrf'], function () {
            Route::post('client/update', ['uses' => 'App\Http\Controllers\ClientController@update', 'as' => 'postUpdateClient']);
            Route::post('clients', ['uses' => 'App\Http\Controllers\ClientController@store', 'as' => 'postCreateClient']);

            Route::post('payment/update', ['uses' => 'App\Http\Controllers\PaymentController@update', 'as' => 'postUpdatePayment']);
            Route::post('payments', ['uses' => 'App\Http\Controllers\PaymentController@store', 'as' => 'postCreatePayment']);

            Route::post('expense/update', ['uses' => 'App\Http\Controllers\ExpenseController@update', 'as' => 'postUpdateExpense']);
            Route::post('expenses', ['uses' => 'App\Http\Controllers\ExpenseController@store', 'as' => 'postCreateExpense']);


            Route::post('transport/update', ['uses' => 'App\Http\Controllers\TransportController@update', 'as' => 'postUpdateTransport']);
            Route::post('transport/create', ['uses' => 'App\Http\Controllers\TransportController@store', 'as' => 'postCreateTransport']);

            Route::post('vehicle/update', ['uses' => 'App\Http\Controllers\VehicleController@update', 'as' => 'postUpdateVehicle']);
            Route::post('vehicle/create', ['uses' => 'App\Http\Controllers\VehicleController@store', 'as' => 'postCreateVehicle']);
        });
    });


    Route::group(['middleware' => 'guest'], function () {

        Route::get('user/create', ['uses' => 'App\Http\Controllers\UserController@create', 'as' => 'getCreate']);
        Route::get('user/signin', ['uses' => 'App\Http\Controllers\UserController@getSignIn', 'as' => 'getSignIn']);

        Route::post('user/postsignin', ['uses' => 'App\Http\Controllers\UserController@signIn', 'as' => 'postsignin']);
        Route::post('user/create', ['uses' => 'App\Http\Controllers\UserController@store', 'as' => 'postRegister']);

    });
