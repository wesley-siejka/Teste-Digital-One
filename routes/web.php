<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;


// tela de login
Route::get('/login', [AuthController::class, 'index'])->name('login');

//processar os dados do login
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

//logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//solicitar link para resetar a senha 
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

//formulario para redefinir a senha com token
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showRequestForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

//criação de usuários
Route::get('/cadastrar', [UserController::class, 'create'])->name('user.create');
Route::post('/store-user', [UserController::class, 'store'])->name('user.store');

//grupo de rotas restritas
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');

    

    Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');

    Route::get('/edit-password/{user}', [UserController::class, 'editPassword'])->name('user.editPassword');
    Route::put('/update-password/{user}', [UserController::class, 'updatePassword'])->name('user.updatePassword');

    Route::delete('/delete-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    
    // Listar publicações
    Route::get('/publications', [PublicationController::class, 'index'])->name('publication.index');

    // Formulário de nova publicação
    Route::get('/publications/create', [PublicationController::class, 'create'])->name('publication.create');

    // Salvar publicação
    Route::post('/publications', [PublicationController::class, 'store'])->name('publication.store');

    // Formulário de edição
    Route::get('/publications/{publication}/edit', [PublicationController::class, 'edit'])->name('publication.edit');

    // Atualizar publicação
    Route::put('/publications/{publication}', [PublicationController::class, 'update'])->name('publication.update');

    // Excluir publicação
    Route::delete('/publications/{publication}', [PublicationController::class, 'destroy'])->name('publication.destroy');
});
