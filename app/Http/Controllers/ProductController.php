<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Repository;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('can:admin.products.index')->only('index');
        $this->middleware('can:admin.products.create')->only('create');
        $this->middleware('can:admin.products.edit')->only('edit','update');
        $this->middleware('can:admin.products.destroy')->only('destroy');
    }

    public function index()
    {
        $data['product']= Product::orderBy('id','asc')->where('habilitado',1)->simplepaginate(8);
        return view('product.index',$data);
    }


    public function create()
    {
        $categories = Category::all()->where('habilitado',1);
        $authors = Author::all()->where('habilitado',1);
        $repositories = Repository::all()->where('habilitado',1);
        return view('product.create')
                  ->with('categories',$categories)
                  ->with('authors',$authors)
                  ->with('repositories',$repositories);
    }

    public function store(Request $request)
    {
        // Validación de los inputs de la vista create de seccion "product"
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'edicion' => 'required',
            'numero_paginas' => 'required|numeric|regex:/^\d+$/',
            'fecha_publicacion' => 'required|date',
            'idioma' => 'required',
            'resumen' => 'required',
            'imagen' => 'required',
            'precio' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'cantidad'=> 'required|numeric|regex:/^\d+$/',
            'isbn',
            'ancho',
            'alto',
            'peso',
            'grueso',
            'author' => 'required',
            'category'=> 'required',
            'ubicacion'=> 'required',
            //'pdf' => 'nullable|mimes:pdf|max:2048' // PDF es opcional
        ]);

        $product = new Product;
        $product->titulo = $request->titulo;
        $product->edicion = $request->edicion;
        $product->numero_paginas = $request->numero_paginas;
        $product->fecha_publicacion = $request->fecha_publicacion;
        $product->idioma = $request->idioma;
        $product->resumen = $request->resumen;
        $product->imagen = $request->imagen;
        $product->precio = $request->precio;
        $product->cantidad = $request->cantidad;
        $product->isbn = $request->isbn;
        $product->ancho = $request->ancho;
        $product->alto = $request->alto;
        $product->peso= $request->peso;
        $product->grueso= $request->grueso;
        $product->author_id = $request->author;
        $product->category_id = $request->category;
        $product->repository_id = $request->ubicacion;

        // Guardar el PDF si se subió
        if($request->hasFile('pdf')) {
            $pdfName = time().'.'.$request->pdf->extension();
            $request->pdf->move(public_path('pdfs'), $pdfName);
            $product->pdf = 'pdfs/'.$pdfName;
        }

        $product->save();
        return redirect()->route('products.index')->with('store', 'ok');
    }


    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
          $authors = Author::all();
          $repositories = Repository::all();

        return view('product.edit')
        ->with('categories',$categories)
        ->with('authors',$authors)
        ->with('repositories',$repositories)
        ->with('product',$product);
    }


    public function update(Request $request, Product $product)
    {
        // Validación de los inputs de la vista create de sección "product"
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'edicion' => 'required',
            'numero_paginas' => 'required|numeric|regex:/^\d+$/',
            'fecha_publicacion' => 'required|date',
            'idioma' => 'required',
            'resumen' => 'required',
            'imagen' => 'required',
            'precio' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'cantidad' => 'required|numeric|regex:/^\d+$/',
            'isbn',
            'ancho',
            'alto',
            'peso',
            'grueso',
            'author' => 'required',
            'category' => 'required',
            'ubicacion' => 'required',
        ]);

        // Editar producto y recibiendo datos de la vista
        if($request->hasFile('pdf')) {
            // Eliminar el PDF antiguo si existe
            if ($product->pdf && file_exists(public_path($product->pdf))) {
                unlink(public_path($product->pdf));
            }

            $pdfName = time().'.'.$request->pdf->extension();
            $request->pdf->move(public_path('pdfs'), $pdfName);

            // Actualizar el nombre del PDF en la base de datos
            $product->pdf = 'pdfs/'.$pdfName;
        }

        $product->titulo = $request->titulo;
        $product->edicion = $request->edicion;
        $product->numero_paginas = $request->numero_paginas;
        $product->fecha_publicacion = $request->fecha_publicacion;
        $product->idioma = $request->idioma;
        $product->resumen = $request->resumen;
        $product->imagen = $request->imagen;
        $product->precio = $request->precio;
        $product->cantidad = $request->cantidad;
        $product->isbn = $request->isbn;
        $product->ancho = $request->ancho;
        $product->alto = $request->alto;
        $product->peso = $request->peso;
        $product->grueso = $request->grueso;
        $product->author_id = $request->author;
        $product->category_id = $request->category;
        $product->repository_id = $request->ubicacion;
        $product->save();

        return redirect()->route('products.index')->with('update','ok');
    }

    public function download($id)
    {
        $product = Product::findOrFail($id);
        $filePath = public_path($product->pdf);

        return response()->download($filePath);
    }
    public function destroy(Product $product)
    {
        $product->habilitado = '0';
        $product->save();
        return redirect()->route('products.index')
                        ->with('eliminar','ok');
    }
}
