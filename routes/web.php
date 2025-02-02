<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Follow\FollowController;
use Illuminate\Support\Facades\Redirect;

// use App\Http\Controllers\Event\EventController;

use App\Http\Controllers\Auth\AuthController;


Route::get("/", function(){
    return Redirect::to("/events");
});


Route::prefix('auth')->group(function () {
        Route::get("register", [ AuthController::class, "showRegistrationForm" ])->name("register");
        Route::post('register', [ AuthController::class, "registerUser" ])->name('register.post');
        Route::get('login', [ AuthController::class, "showLoginForm" ])->name('login');
        Route::post('login', [ AuthController::class, "userLogin" ])->name('login.post');
        Route::get('logout', [ AuthController::class, "userLogout" ])->name('logout');
});

Route::prefix('events')->middleware("auth")->group(function () {

    Route::get('/', [EventController::class, 'getAllEvents'])->name('events.index');

    Route::get('/create', [EventController::class, 'createEventsForm'])->name('events.create');
    Route::post('/create', [EventController::class, 'createEvents'])->name('events.store');

    Route::get('/{eventId}', [EventController::class, 'getSingleEventDetails'])->name('events.show');

    Route::get('/{eventId}/edit', [EventController::class, 'updateEventForm'])->name('events.edit');
    Route::put('/{eventId}/update', [EventController::class, 'updateEvent'])->name('events.update');

    // deleting events
    Route::delete('/delete/{eventId}', [ EventController::class, 'deleteEvent' ])->name('deleteEvent');

    // follow unfollow
    Route::post("/follow/{event_id}", [ FollowController::class, "follow" ])->name("follow");
    Route::delete("/unfollow/{event_id}", [ FollowController::class, "unfollow" ])->name("unfollow");

    // importing data
    Route::post("/import", [ EventController::class, "importCsv" ])->name("importCsv");
});


