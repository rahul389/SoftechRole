<?php
use Softech\Role\Http\Controllers\RoleController;
	
	Route::resource('/roles',RoleController::class);
	Route::get('/roles-data', [RoleController::class, 'rolesData'])->name('roles.data');
	Route::post('roles-toggle-status/{id}', [RoleController::class, 'toggleStatus'])->name('role.toggle.status');