<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RepositoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

*/

// Página de inicio

Route::get('/',HomeController::class)->name('home');

Route::group(['middleware' => ['auth','verified']], function(){

    Route::resource('users',UserController::class)->names('admin.users');
    //CRUD Categoria
    Route::resource('category', CategoryController::class);
    //CRUD Autor
    Route::resource('author', AuthorController::class);
    //CRUD Editorial
    Route::resource('editorial', EditorialController::class);
    //CRUD Repositorios
    Route::resource('repository', RepositoryController::class);

    //Ruta para imagenes
    Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

    //Rutas para el Perfil de usario
    // Route::get('/editar-perfil',[PerfilController::class, 'index'])->name('perfil.index');
    // Route::post('/editar-perfil',[PerfilController::class, 'store'])->name('perfil.store');
    Route::resource('perfil', PerfilController::class);

    //actualizar contraseña
    Route::get('/changepassword', [PerfilController::class, 'changePassword'])->name('changepassword');
    Route::post('/change-password', [PerfilController::class, 'updatePassword'])->name('updatepassword');
});

//CRUD libros
Route::resource('books',BookController::class);
//Ruta de la Barra de Busqueda Principal Busqueda
Route::get('search',SearchController::class)->name('search');



//Rutas para el registro
Route::get('/register',[RegisterController::class, 'index'])->name('register');
Route::post('/register',[RegisterController::class, 'store']);
//Rutas para el login
Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('/login',[LoginController::class, 'store']);
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');

//Rutas de prueba
Route::get('/pruebas',function(){
    return view('pruebas.prueba2');
});





//Route::resource('books', LibroController::class);
//Route::get('/books', [LibroController::class, 'index'])->name('libros.index');
//Route::get('/books/{book}', [LibroController::class, 'show'])->name('libros.show');
//Route::get('/books/create', [LibroController::class, 'create'])->name('libros.create');
//Route::post('/books', [LibroController::class, 'store'])->name('libros.store');
