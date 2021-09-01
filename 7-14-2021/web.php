<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Role;


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

Route::impersonate();

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(["auth:sanctum",'web','can:manage users','has.team'])
    ->get('/clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('clients');

Route::middleware(["auth:sanctum",'web','can:manage users','has.team'])
    ->get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::middleware(["auth:sanctum",'web','can:manage users','has.team'])
    ->get('/admin/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');

Route::middleware(["auth:sanctum",'web','can:manage users','has.team'])
    ->get('/teams/create', [\App\Http\Controllers\ClientController::class, 'create'])->name('clients.create');

Route::middleware(["auth:sanctum",'web','has.team'])
    ->get('/analyze', [\App\Http\Controllers\AnalyzeController::class, 'index'])->name('analyze');

Route::middleware(["auth:sanctum",'web','has.team'])
    ->get('/predict', [\App\Http\Controllers\PredictController::class, 'index'])->name('predict');

Route::middleware(["auth:sanctum",'web','has.team'])
    ->get('/hcp', [\App\Http\Controllers\HcpController::class, 'index'])->name('hcp');

Route::middleware(['auth:sanctum', 'web', 'verified','has.team'])->get('/welcome', function () {
    return view('welcome');
})->name('welcome');

/*Route::middleware(['auth:sanctum', 'web', 'verified','has.team'])->get('/dashboard', function () {
    return redirect()->route('welcome');
    //return view('dashboard');

})->name('dashboard');*/

//////////////////////////
// TESTING ROUTES
//////////////////////////
Route::middleware(['auth:sanctum', 'verified','has.team'])->get('/email-invite', function () {
    $user = User::find(19);
    $user->sendAdminInvitedNotification(md5(time()));

})->name('email.invite');

Route::middleware(['auth:sanctum', 'verified','has.team'])->get('/activity-build', function () {

    $user = User::find(1);
    $log_items = $user->authentications()->get();

    //$user->sendAdminInvitedNotification(md5(time()));
    return view('profile.activity',[
        'user' => $user
    ]);


})->name('profile.activity');


/***********************************************************************************************************************
    NEW ROUTES
************************************************************************************************************************/

/*
*   NPIs Routes
*/

Route::get('/npis',[\App\Http\Controllers\NpisController::class, 'index'])->name('npis.index');

Route::get('/import_npis',[\App\Http\Controllers\NpisController::class, 'import_npis'])->name('npis.import_npis');

Route::post('/processImport',[\App\Http\Controllers\NpisController::class, 'processImport'])->name('processImport');

//Route::get('/searchNPIs',[\App\Http\Controllers\NpisController::class, 'searchNPIs'])->name('searchNPIs');

Route::get('/importNPIs',[\App\Http\Controllers\NpisController::class, 'importNPIs'])->name('importNPIs');

Route::post('/mapNPIs', [\App\Http\Controllers\NpisController::class, 'mapNPIs'])->name('mapNPIs');


/*
*   Media Partners Routes
*/
//Route::get('/media_partners/create',[\App\Http\Controllers\MediaPartnersController::class, 'create'])->name('media_partners.create');



