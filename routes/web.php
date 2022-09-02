<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use Gloudemans\Shoppingcart\Facades\Cart;
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
use App\Http\Controllers\CreateOrderController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\Admin\AdminOrderController;

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

    //CRUD Repositorios
    Route::resource('repository', RepositoryController::class);
    //Administrar Ordenes
    Route::get('admin/orders',[AdminOrderController::class,'index'])->name('admin.orders.index');
    Route::get('admin/orders/{order}',[AdminOrderController::class,'show'])->name('admin.orders.show');


    //Ruta para imagenes
    Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

    //Rutas para el Perfil de usario
    // Route::get('/editar-perfil',[PerfilController::class, 'index'])->name('perfil.index');
    // Route::post('/editar-perfil',[PerfilController::class, 'store'])->name('perfil.store');
    Route::resource('perfil', PerfilController::class);

    //actualizar contraseña
    Route::get('/changepassword', [PerfilController::class, 'changePassword'])->name('changepassword');
    Route::post('/change-password', [PerfilController::class, 'updatePassword'])->name('updatepassword');


    //ruta de carrito de compras
    Route::get('shopping-cart',[ShoppingCartController::class, 'index'])->name('shopping-cart');

    //ruta de ordenes
    Route::get('/orderscreate', [CreateOrderController::class, 'index'])->name('orderscreate.index');

    //para mostrar el pedido ya finalizado
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    //ruta para resumen de orden
    Route::get('orders/{order}/payment', [OrderController::class,'payment'])->name('orders.payment');

    //ruta para confirmar la orden
    Route::get('orders/{order}/pay', [OrderController::class,'pay'])->name('orders.pay');

    //ruta para ver mis ordenes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    //descargar imagenes
    Route::get('/download/{file}' , [OrderController::class, 'download'])->name('orders.download');

});

//CRUD Autor
Route::resource('author', AuthorController::class);
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
    //  return view('pruebas.prueba2');
    Cart::destroy();
});


//Route::resource('books', LibroController::class);
//Route::get('/books', [LibroController::class, 'index'])->name('libros.index');
//Route::get('/books/{book}', [LibroController::class, 'show'])->name('libros.show');
//Route::get('/books/create', [LibroController::class, 'create'])->name('libros.create');
//Route::post('/books', [LibroController::class, 'store'])->name('libros.store');
