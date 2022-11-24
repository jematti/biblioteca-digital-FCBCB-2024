<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Author;
use App\Models\Product;
use App\Models\Category;
use App\Models\Repository;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\OrderNotification;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('can:admin.orders.index')->only('index');
        $this->middleware('can:admin.orders.create')->only('create');
        $this->middleware('can:admin.reports.orders')->only('report');
        $this->middleware('can:admin.reports.sales')->only('sale');
    }

    public function index()
    {
        //realizamos la consulta a la base de datos segun el usuario
        $orders = Order::query()->where('user_id', auth()->id());
        // $orders = Order::query()->orderBy('id','desc')->where('user_id', auth()->id());

        //preguntamos si recibimos una variable del estado de la orden
        if (request('estado')) {
            $orders->where('estado',request('estado'));
        }

        //obtenemos la coleccion de la ordenes
        $orders=$orders->get();

        //obtenemos la cantidad de ordenes por el estado de la orden
        $pendiente = Order::where('estado',1)->where('user_id', auth()->id())->count();
        $recibido = Order::where('estado',2)->where('user_id', auth()->id())->count();
        $enviado = Order::where('estado',3)->where('user_id', auth()->id())->count();
        $entregado = Order::where('estado',4)->where('user_id', auth()->id())->count();
        $anulado = Order::where('estado',5)->where('user_id', auth()->id())->count();

        return view('orders.index', compact('orders','pendiente','recibido','enviado','entregado','anulado'));
    }

    public function show(Order $order)
    {
        $this->authorize('verifica_usuario',$order);
        $items = json_decode($order->content);
        return view('orders.show', compact('order','items'));
    }

    public function payment(Order $order){

        $this->authorize('verifica_usuario',$order);
        $this->authorize('pago',$order);
        $items = json_decode($order->content);
        return view('orders.payment',compact('order','items'));

    }

    public function pay(Order $order){

        $order->estado = 2;
        $order->save();
        //crear notificación de orden de compra para administración
        $admin = User::find(1);
        $admin->notify(new OrderNotification($order->id,1,$order->estado));
        // crear notificacion para el usuario de orden recibida
        $order->user->notify(new OrderNotification($order->id,$order->user_id,$order->estado));
        return redirect()->route('orders.show',$order);
    }

    public function download($file){
        $pathtoFile = public_path('depositos'.'/'.$file);
        return response()->download($pathtoFile);
    }

    public function report()
    {
        $orders = Order::all();
        $repositories = Repository::all();
        $products = Product::all();
        $categories = Category::all();
        $authors = Author::all();

        return view('orders.report')->with('products',$products)
                                    ->with('categories',$categories)
                                    ->with('repositories',$repositories)
                                    ->with('authors',$authors)
                                    ->with('orders',$orders);
    }

    public function pdf(Request $request)
    {
        $this->validate($request,[
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'order_type' => 'required'
        ]);
        //tipo de orden de compra solicitada
        $order_type = $request->order_type;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;

        $orders = Order::whereDate('created_at', '>=', $fecha_inicio)->whereDate('created_at', '<=', $fecha_fin)->get();

        //adquirir la fecha
        $now = Carbon::now();

        $pdf = Pdf::loadView('report.order_report',
        ['orders' =>$orders,
        'now'=>$now,
        'fecha_inicio'=>$fecha_inicio,
        'fecha_fin'=>$fecha_fin,
        'order_type' => $order_type]);
        return $pdf->stream();
        // return $pdf->download('invoice.pdf');
    }

    public function sale()
    {
        $orders = Order::all();
        $repositories = Repository::all();
        $products = Product::all();
        $categories = Category::all();
        $authors = Author::all();

        return view('orders.sale')->with('products',$products)
                                    ->with('categories',$categories)
                                    ->with('repositories',$repositories)
                                    ->with('authors',$authors)
                                    ->with('orders',$orders);
    }


    public function sale_pdf(Request $request)
    {
        $this->validate($request,[
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ]);


        $products_search = $request->product_id;
        $categories_search = $request->category_id;
        $repositories_search = $request->repository_id;
        $authors_search = $request->author_id;

        //rango de fechas para el reporte
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;

        //obtener lista de productos vendidos
        $sales = Sale::whereDate('created_at', '>=', $fecha_inicio)->whereDate('created_at', '<=', $fecha_fin)->where('estado_producto',4);

        if ($request->product_id) {

            $sales->when($products_search,function($query,$products_search){
                $query->where('product_id',$products_search);
            });
        }
        if ($request->category_id) {

            $sales->when($categories_search,function($query,$categories_search){
                $query->where('categoria',$categories_search);
            });
        }

        if ($request->repository_id) {

            $sales->when($repositories_search,function($query,$repositories_search){
                $query->where('repositorio',$repositories_search);
            });
        }
        if ($request->author_id) {

            $sales->when($authors_search,function($query,$authors_search){
                $query->where('autor',$authors_search);
            });
        }

        //obtener productos del filtro
        $sales=$sales->get();
            //adquirir la fecha
            $now = Carbon::now();

            $pdf = Pdf::loadView('report.sales_report',
            ['sales' =>$sales,
            'now'=>$now,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin]);
            return $pdf->stream();
            return $pdf->download('invoice.pdf');
            // return view('report.sales_report')->with('products',$products)->with('products_search',$products_search);

    }


}
