<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\Autenticacao;
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

Route::get("/login", [LoginController::class, "index"]);
Route::post("/login", [LoginController::class, "login"]);
Route::get("/logout", [LoginController::class, "logout"]);
Route::post("/cadastro", [LoginController::class, "cadastro"]);
Route::get("/reset", [LoginController::class, "reset"]);
Route::post("/email", [LoginController::class, "validaEmail"]);
Route::post("/token", [LoginController::class, "validaToken"]);
Route::post("/reset", [LoginController::class, "resetaSenha"]);

Route::middleware([Autenticacao::class])->group(function () {
    Route::get("/", [BlogController::class, "index"]);
    Route::get("/blog", [BlogController::class, "lista"]);
    Route::get("/blog/{id}", [BlogController::class, "recuperaPost"]);
    Route::post("/blog", [BlogController::class, "criaPost"]);
    Route::put("/blog/aprova", [BlogController::class, "aprovaPost"]);
    Route::post("/blog/{id}", [BlogController::class, "editaPost"]);
    Route::delete('/blog/{id}', [BlogController::class, "deletaPost"]);

    Route::get("/categoria", [CategoriaController::class, "index"]);
    Route::post("/categoria", [CategoriaController::class, "criaCategoria"]);
    Route::put("/categoria", [CategoriaController::class, "editaCategoria"]);
    Route::delete('/categoria/{id}', [CategoriaController::class, "deletaCategoria"]);

    Route::get("/usuarios", [UsuarioController::class, "index"]);
    Route::get("/usuario/{id}", [UsuarioController::class, "recuperaUsuario"]);
    Route::post("/usuario", [UsuarioController::class, "editaUsuario"]);
    Route::get('/exportar-csv', [UsuarioController::class, "exportarCSV"])->name('exportar.csv');
});
