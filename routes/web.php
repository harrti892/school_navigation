<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\EdgeController;

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
    return view('home');
});
Route::get('/nodes/editor', [NodeController::class, 'editor'])->name('nodes.editor');
Route::post('/nodes/store', [NodeController::class, 'store'])->name('nodes.store');
Route::get('/admin/map-editor', [NavigationController::class, 'showMapEditor']);
Route::post('/admin/add-node', [NavigationController::class, 'addNode']);
Route::post('/admin/add-edge', [NavigationController::class, 'addEdge']);
Route::get('/admin/map-editor', [NavigationController::class, 'showMapEditor']);
Route::post('/admin/add-node', [NavigationController::class, 'addNode']);
Route::post('/admin/add-edge', [NavigationController::class, 'addEdge']);
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // 節點 API
    Route::post('/nodes', [NodeController::class, 'store'])->name('nodes.store');
    Route::delete('/nodes/{node_id}', [NodeController::class, 'destroy'])->name('nodes.destroy');

    // 邊 API
    Route::post('/edges', [EdgeController::class, 'store'])->name('edges.store');
    Route::delete('/edges/{edge_id}', [EdgeController::class, 'destroy'])->name('edges.destroy');
});
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/map-editor', [NavigationController::class, 'showMapEditor']);
    Route::post('/admin/add-node', [NavigationController::class, 'addNode']);
    Route::post('/admin/add-edge', [NavigationController::class, 'addEdge']);
});
Route::get('/admin', function () {
    return view('admin.dashboard'); // 對應 resources/views/admin/dashboard.blade.php
});
Route::get('/navigation', function () {
    return view('navigation');
});
