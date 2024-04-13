<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        ['roles']
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('cost-center', 'CostCenterCrudController');
    Route::crud('service-type', 'ServiceTypeCrudController');

    // Custom Routes

    // Requester Routes
    Route::get('requests', [ServiceController::class, 'index'])->name('requests');
    Route::post('services/store', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/rate-service', [ServiceController::class, 'rateService'])->name('rate.service');
    Route::get('/serviceDetails/{id}', [ServiceController::class, 'showDetails'])->name('service.details');

    // Manager Routes
    Route::get('services', [ServiceController::class, 'services'])->name('services');
    Route::get('/services/search', [ServiceController::class, 'services'])->name('services.search');
    Route::put('/services/approve/{id}', [ServiceController::class, 'approve'])->name('services.approve');
    Route::put('/services/decline/{id}', [ServiceController::class, 'decline'])->name('services.decline');
    Route::get('services/{id}', [ServiceController::class, 'show'])->name('services.show');

    // Manager Approved Requests List
    Route::get('approvedRequests', [ServiceController::class, 'approvedRequests'])->name('approvedRequests');
    Route::put('/assign-personnel', [ServiceController::class, 'assignPersonnel'])->name('assign.personnel');

    // Personnel Tasks
    Route::get('personnelTask', [ServiceController::class, 'task'])->name('personnelTask');
    Route::put('/services/done/{id}', [ServiceController::class, 'serviceDone'])->name('service.done');

}); // this should be the absolute last line of this file