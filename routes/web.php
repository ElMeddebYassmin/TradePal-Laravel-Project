<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\ParticipationController;
use App\Http\Controllers\FrontEnd\ProfileUserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\FrontEnd\BaremeController;
use App\Http\Controllers\FrontEnd\WorkController;
use App\Http\Controllers\FrontEnd\GameController;
use App\Http\Controllers\FrontEnd\TrocController;
use App\Http\Controllers\FrontEnd\SearchController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});



Route::get('/home',  [IndexController::class, 'index']);
Route::get('/show2',  [EventController::class, 'show2']);
Route::get('/',  [IndexController::class, 'index']);
Route::get('/updateProfile', [ProfileUserController::class, 'updateProfile'])->name('profile.updateProfile');
Route::get('/updatePassword', [ProfileUserController::class, 'updatePassword'])->name('profile.updateProfile');

Route::get('/login',  [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->middleware('guest');

Route::post('/login',  [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login');

Route::post('/register',  [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');


Route::get('/profile',  [ProfileController::class, 'edit']);

Route::get('/bareme',  [BaremeController::class, 'index']);
Route::get('/work',  [WorkController::class, 'index']);
Route::get('/game',  [UserController::class, 'gamePage']);
Route::get('/add-troc',  [trocController::class, 'index']);
Route::get('/search',  [searchController::class, 'index']);
Route::get('/read', [BlogController::class, 'listing']);
Route::get('/new-blog',  [BlogController::class, 'UserBlogForm']);
Route::post('/storeBlog', [BlogController::class, 'userSaveBlog']);
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs/author/{username}', [BlogController::class, 'filterByAuthor']);
Route::get('/blog/tag/{tag}', [BlogController::class, 'fetchBlogsByTag']);
Route::post('/storeComment', [CommentController::class, 'store']);
Route::post('/like/{user_id}/{blog_id}', [CommentController::class, 'likeBlog'])->name('like.toggle');
Route::post('/game',  [UserController::class, 'game']);
Route::get('/JeParticipe', [EventController::class, "eventsForUser"]);
Route::get('/participerEvent/{event_id}/{user_id}', [EventController::class, 'participerEvent'])->name('participerEvent');
Route::get('/eventsDetails/{id}', [EventController::class, 'show2'])->name('events.show');


 /******************* Items+ Requests Front*/
 Route::resource('item', ItemController::class);
 Route::resource('request', RequestController::class);
 Route::get('/requests/show-offer',  [RequestController::class, 'showOffer']);
 Route::get('/requests/show-request',  [RequestController::class, 'showRequest']);
 Route::get('/requests/editAll/{id}',  [RequestController::class, 'editAll'])->name('request.editAll');
 Route::put('/requests/updateAll/{id}',  [RequestController::class, 'updateAll'])->name('request.updateAll');
 Route::get('/requests/new/{id}',  [RequestController::class, 'create'])->name('request.new');

  /******************* Items + Requests*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/claims', [\App\Http\Controllers\ClaimController::class, 'claimsForUser'])->name('claimsForUser');
    Route::get('/add', [\App\Http\Controllers\ClaimController::class, 'create'])->name('claim.create');
    Route::post('/add', [\App\Http\Controllers\ClaimController::class, 'store'])->name('claim.store');
    Route::get('/generate-pdf/{claim}', [\App\Http\Controllers\ClaimController::class, 'generatePdf'])->name('generatePdf');
    Route::get('/user/detail/claim/', [\App\Http\Controllers\ClaimController::class, 'userClaimDetail'])->name('UserClaimDetail');
});

Route::get('/profile', [ProfileUserController::class, 'edit'])->name('profile.edit');

Route::get('/edit-profile', [ProfileUserController::class, 'showForm'])->name('profile.showForm');




Route::prefix('dashboard')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/blog/add', [BlogController::class, 'create']);
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/comments/add',  [BlogController::class, 'create']);
    Route::get('/comments',  [BlogController::class, 'index']);
    Route::post('/user/block/{id}', [UserController::class, 'blockUser'])->name('blockUser');
    Route::post('/user/activate/{id}', [UserController::class, 'activateUser'])->name('activateUser');


    Route::get('/events', [EventController::class, 'eventsForAdmin']);
    Route::get('/events/add', [EventController::class, 'create']);
    Route::post('/events/add', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/generatePdf/{id}', [EventController::class,'generatePdf' ])->name('events.generatePdf');

    Route::get('/events/{id}', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events2', [EventController::class, 'affiche'])->name('events.index');
    Route::get('/stat/events', [EventController::class, 'stat']);

//    Route::get('/events', [EventController::class, 'rechercheParDate'])->name('events.rechercheParDate');


    Route::get('/participations', [ParticipationController::class, 'participationsForAdmin']);
    Route::get('/participations/create', [ParticipationController::class, 'create']);

    Route::post('/participations', [ParticipationController::class, 'store'])->name('participations.store');
    Route::get('/participations/edit/{id}', [ParticipationController::class, 'edit'])->name('participations.edit');
    Route::put('/participations/{id}', [ParticipationController::class, 'update'])->name('participations.update');
    Route::delete('/participations/{id}', [ParticipationController::class, 'destroy'])->name('participation.destroy');

    Route::get('/blogs',  [BlogController::class, 'index']);
    Route::resource('/organizations', OrganizationController::class);
    Route::resource('/blogs', BlogController::class);
    Route::resource('/donations', DonationController::class);
    Route::resource('/comments', CommentController::class);
    Route::resource('/claims', \App\Http\Controllers\ClaimController::class);
    Route::get('claims', [\App\Http\Controllers\ClaimController::class, 'claimsForAdmin'])->name('claimsForAdmin');
    Route::get('/search', [\App\Http\Controllers\ClaimController::class, 'search'])->name('search');
    Route::get('clear-filters', [\App\Http\Controllers\ClaimController::class, 'clearFilters'])->name('clearFilters');
    Route::post('/responses', [\App\Http\Controllers\ClaimController::class])->name('responses.store');
    Route::post('/claim/sendEmail/{claim}', [\App\Http\Controllers\ClaimController::class, 'sendEmail'])->name('sendEmail');
    Route::get('/claims/reply/{claim_id}', [\App\Http\Controllers\ResponseController::class, 'create'])->name('reply.create');
    Route::get('/claims/reply/{claim_id}', [\App\Http\Controllers\ResponseController::class, 'create'])->name('reply.create');
    Route::post('/reply/store', [\App\Http\Controllers\ResponseController::class, 'store'])->name('reply.store');
    Route::delete('/reply/delete/{id}', [\App\Http\Controllers\ResponseController::class, 'destroy'])->name('reply.destroy');
    Route::get('/response/{id}', [\App\Http\Controllers\ResponseController::class, 'edit'])->name('responses.edit');
    Route::put('/response/{id}', [\App\Http\Controllers\ResponseController::class, 'update'])->name('responses.update');
    Route::get('/reclamation/{id}', [\App\Http\Controllers\ResponseController::class, 'showClaim'])->name('claims.show');
    Route::delete('/claim/deleteClaim/{id}', [\App\Http\Controllers\ClaimController::class, 'destroy'])->name('supprimer');
    Route::delete('/claim/deleteUserClaim/{id}', [\App\Http\Controllers\ClaimController::class, 'destroyUserClaim'])->name('delete');
    Route::post('/claims/reply/{claim_id}', [\App\Http\Controllers\ResponseController::class, 'store'])->name('reply.store');
    Route::get('/donations-export', [DonationController::class, 'export'])->name('donations.export');
    Route::post('/organizations-import', [OrganizationController::class, 'import'])->name('organizations.import');
    Route::get('organization/chart', [OrganizationController::class, 'chart'])->name('organizations.chart');




     /******************* Items + Requests Back */
     Route::get('/item/list', [ItemController::class, 'indexDash'])->name('item.indexDash');
     Route::get('/request/list', [RequestController::class, 'indexDash'])->name('request.indexDash');
     Route::delete('/item/destroy/{id}', [ItemController::class, 'destroyDash'])->name('item.destroyDash');
     Route::get('/item/getItemsData', [ItemController::class, 'getItemsData'])->name('items.data');
     Route::delete('/request/destroy/{id}', [RequestController::class, 'destroyDash'])->name('request.destroyDash');
     /***********************************/
})->middleware(['auth', 'verified', 'checkAdmin'])->name('dashboard');

Route::fallback(function () {
    return view('backOffice.404');
});
Route::get('/organizations/{id}', [OrganizationController::class, 'show'])->name('organizations.show');
Route::get('/organizations', [OrganizationController::class, 'indexFrontOffice'])->name('organizations.indexFrontOffice');
Route::get('/search-organizations', [OrganizationController::class, 'search'])->name('organizations.search');
Route::post('/donations/add', [DonationController::class, 'store']);
//require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    Route::get('/profile',  [ProfileUserController::class, 'index']);


    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    Route::get('logout', [AuthenticatedSessionController::class, 'goToHome']);
});
