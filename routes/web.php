<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

$uri = '';

foreach (Request::segments() as $segment) {
    $uri .= '/' . $segment;
}

$page = null;

if (Schema::hasTable('slug__slugs')) {
    $page = DB::table('pages')
        ->where('slug', '=', $uri)
        ->first();
}

if ($page) {
    $pageType= DB::table('page_types')
        ->where('id', '=', $page->page_type_id)
        ->first();

    if ($page->is_main) {
        Route::get($page->slug, [$pageType->controller, $pageType->action]);
        request()->merge(['entityId' => $page->entity_id]);
    } else {
        $pageMain = DB::table('pages')
            ->where('entity_id', '=', $page->entity_id)
            ->where('page_type_id', '=', $page->page_type_id)
            ->where('is_main', '=', 1)
            ->first();

        if ($pageMain) {
            Route::redirect($page->slug, $pageMain->slug);
        }
    }
}

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
