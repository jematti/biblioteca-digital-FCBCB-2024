<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\CreateOrderController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

*/

// Página de inicio

Route::get('/', HomeController::class)->name('home');


Route::group(['middleware' => ['auth', 'verified']], function () {
    //Admin-Usuarios
    Route::resource('users', UserController::class)->names('admin.users');
    //CRUD Roles
    Route::resource('roles', RoleController::class)->names('admin.roles');
    //CRUD Categoria
    Route::resource('category', CategoryController::class);

    //CRUD Repositorios
    Route::resource('repository', RepositoryController::class);
    //Administrar Ordenes
    Route::get('admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');

    //Ruta para imagenes
    Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

    //Rutas para Actualizar Perfil de usuario
    Route::resource('perfil', PerfilController::class);

    //actualizar contraseña
    Route::get('/changepassword', [PerfilController::class, 'changePassword'])->name('changepassword');
    Route::post('/change-password', [PerfilController::class, 'updatePassword'])->name('updatepassword');


    //ruta de carrito de compras
    Route::get('shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart');

    //ruta de ordenes
    Route::get('/orderscreate', [CreateOrderController::class, 'index'])->name('orderscreate.index');
    Route::get('/orderscreate/{order}/edit', [CreateOrderController::class, 'edit'])->name('orderscreate.edit');
    // Route::post('/subjects/update/{id}', 'SubjectsController@update')->name('orderscreate.update');

    //para mostrar el pedido ya finalizado
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    //ruta para resumen de orden
    Route::get('orders/{order}/payment', [OrderController::class, 'payment'])->name('orders.payment');

    //ruta para confirmar la orden
    Route::get('orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');

    //ruta para ver mis ordenes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    //descargar imagenes de depositos
    Route::get('/download/{file}', [OrderController::class, 'download'])->name('orders.download');

    //descargar imagen  de QR
    Route::get('/download', [CreateOrderController::class, 'download'])->name('qr.download');

    //Notificaciones
    Route::get('/notification', NotificationController::class)->name('notification');

    //Generar Pdf's
    //reporte de ordenes de compra
    Route::get('/report/pdf', [OrderController::class, 'report'])->name('report_order.pdf');
    Route::post('/orders/pdf', [OrderController::class, 'pdf'])->name('order.pdf');
    //reporte de ventas en general
    Route::get('/sale/pdf', [OrderController::class, 'sale'])->name('report_sale.pdf');
    Route::post('/sales/pdf', [OrderController::class, 'sale_pdf'])->name('sale.pdf');


});

//CRUD Autor
Route::resource('author', AuthorController::class);
//CRUD libros
Route::resource('products', ProductController::class);
//Filtro de busqueda
Route::resource('filter', FilterController::class);
//Ruta de la Barra de Busqueda Principal Busqueda
Route::get('search', SearchController::class)->name('search');

//Rutas de prueba
Route::get('/pruebas', function () {
     return view('pruebas.prueba2');
    // Cart::destroy();
});
//Ruta para autenticación y registro
require __DIR__ . '/auth.php';


//Route::resource('books', LibroController::class);
//Route::get('/books', [LibroController::class, 'index'])->name('libros.index');
//Route::get('/books/{book}', [LibroController::class, 'show'])->name('libros.show');
//Route::get('/books/create', [LibroController::class, 'create'])->name('libros.create');
//Route::post('/books', [LibroController::class, 'store'])->name('libros.store');
