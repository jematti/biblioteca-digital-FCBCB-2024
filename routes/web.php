<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\RepositoryController;

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

// Página de inicio

Route::get('/',HomeController::class)->name('home');


//CRUD Categoria
Route::resource('category', CategoryController::class);
//CRUD Autor
Route::resource('author', AuthorController::class);
//CRUD Editorial
Route::resource('editorial', EditorialController::class);
//CRUD Repositorios
Route::resource('repository', RepositoryController::class);
//CRUD libros
Route::resource('books',BookController::class);
//Route::resource('books', LibroController::class);
//Route::get('/books', [LibroController::class, 'index'])->name('libros.index');
//Route::get('/books/{book}', [LibroController::class, 'show'])->name('libros.show');
//Route::get('/books/create', [LibroController::class, 'create'])->name('libros.create');
//Route::post('/books', [LibroController::class, 'store'])->name('libros.store');

//Ruta para imagenes
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

//Rutas para el Perfil
Route::get('/editar-perfil',[ProfileController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil',[ProfileController::class, 'store'])->name('perfil.store');
//Rutas para el registro
Route::get('/register',[RegisterController::class, 'index'])->name('register');
Route::post('/register',[RegisterController::class, 'store']);
//Rutas para el login
Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('/login',[LoginController::class, 'store']);
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');
//post pantalla principal de cada usuario
Route::get('/muro',[PostController::class, 'index'])->name('posts.index');


//Rutas de prueba
Route::get('/pruebas',function(){
    return view('pruebas.prueba');
});


//rutas de prueba para libros
Route::get('/libro',function(){
    return view('libro.libro');
});

Route::get('/libro1',function(){
    return view('libro.l1');
});

Route::get('/libro2',function(){
    return view('libro.l2');
});

Route::get('/libro3',function(){
    return view('libro.l3');
});

Route::get('/libro4',function(){
    return view('libro.l4');
});

Route::get('/libro5',function(){
    return view('libro.l5');
});

Route::get('/libro6',function(){
    return view('libro.l6');
});

Route::get('/libro7',function(){
    return view('libro.7');
});

Route::get('/libro8',function(){
    return view('libro.l8');
});

Route::get('/libro9',function(){
    return view('libro.l9');
});

Route::get('/libro10',function(){
    return view('libro.l10');
});

Route::get('/libro11',function(){
    return view('libro.l11');
});

Route::get('/libro12',function(){
    return view('libro.l12');
});

Route::get('/libro13',function(){
    return view('libro.l13');
});

Route::get('/libro14',function(){
    return view('libro.l14');
});

Route::get('/libro15',function(){
    return view('libro.l15');
});

Route::get('/libro16',function(){
    return view('libro.l16');
});

Route::get('/libro17',function(){
    return view('libro.l17');
});

Route::get('/libro18',function(){
    return view('libro.l18');
});
