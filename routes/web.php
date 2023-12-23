<?php

use App\Models\Announcement;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/charts', function () {
    return view('charts');
});

Route::get('/stats', function () {
    return view('stats');
});

Route::get('/announcement', function () {
    $announcement = Announcement::first();

    abort_if(!$announcement?->is_active, 404);

    return view('announcement', [
      'announcement' => $announcement,
    ]);
});

Route::get('/announcement/edit', function () {
    $announcement = Announcement::first();

    return view('edit-announcement', [
      'announcement' => $announcement,
    ]);
});

Route::patch('/announcement/update', function (Request $request) {
    $fields = $request->validate([
      'is_active' => 'required',
      'banner_text' => 'required',
      'banner_color' => 'required',
      'title_text' => 'required',
      'title_color' => 'required',
      'content' => 'required',
      'button_text' => 'required',
      'button_color' => 'required',
      'button_link' => 'required|url',
    ]);

    $announcement = Announcement::first();
    $announcement->update($fields);

    return back()->with('success_message', 'Announcement was updated!');
});
