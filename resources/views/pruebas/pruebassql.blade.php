$products=Product::query()->where('habilitado',1);

// if (Order::find($request->order_number)) {
    if ($request->product_id) {
        $products->where('id',$products_search);
        // $products = $products->get();
    }

    if ($request->category_id) {

        $products->where('category_id',$categories_search);
        $products = $products->get();
    }

    if ($request->repository_id) {
        $products->where('repository_id',$repositories_search);
        // $products = $products->get();
    }

    if ($request->author_id) {
         $products->where('author_id',$authors_search);
        //  $products = $products->get();
    }
    // $products = $products->get();


    // if (Order::find($request->order_number)) {
        if ($request->product_id) {
            $products = Product::query()->where('id',$products_search);
            $products = $products->get();
        }

        if ($request->category_id) {

            $products = Product::query()->where('category_id',$categories_search);
            $products = $products->get();

            if ($request->repository_id) {
                $products->where('repository_id',$repositories_search);

            }

            if ($request->author_id) {
                $products->where('author_id',$authors_search);

            }


        }

        // else {
        //     $products = Product::query()->all();
        //     if ($request->category_id) {
        //         $products->where('category_id',$categories_search);
        //     }
        //     if ($request->repository_id) {
        //         $products->where('repository_id',$repositories_search);
        //     }
        //     if ($request->author_id) {
        //         $products->where('author_id',$authors_search);
        //     }
        // }







        $products = Product::when($products_search,function($query,$products_search){
            $query->where('id',$products_search);
        })
        ->when($categories_search,function($query,$categories_search){
            $query->orwhere('category_id',$categories_search);
        })
        // ->when($repositories_search,function($query,$repositories_search){
        //     $query->where('repository_id',$repositories_search);
        // })
        // ->when($authors_search,function($query,$authors_search){
        //     $query->where('author_id',$authors_search);
        // })





        $products = Product::select("*")
        ->when($request->has('id'), function ($query) use ($request) {
            $query->where('id', $request->product_id);
        })->get();

        // if ($request->category_id) {
        //     $products->when($request->has('category_id'), function ($query) use ($request) {
        //         $query->where('category_id', $request->category_id);
        //     });
        // }
        // $products->get();







        $products = Product::where('habilitado',1);

        if ($request->product_id) {

            $products->when($products_search,function($query,$products_search){
                $query->where('id',$products_search);
            });
        }
        if ($request->category_id) {

            $products->when($categories_search,function($query,$categories_search){
                $query->where('category_id',$categories_search);
            });
        }

        if ($request->repository_id) {

            $products->when($repositories_search,function($query,$repositories_search){
                $query->where('repository_id',$repositories_search);
            });
        }
        if ($request->author_id) {

            $products->when($authors_search,function($query,$authors_search){
                $query->where('author_id',$authors_search);
            });
        }

        //obtener productos del filtro
        $products=$products->get();



        $orders = DB::table('orders')
        // ->where('content->rowId', 1384)
        ->get();
// $products = Product::where('habilitado',1);

// if ($request->product_id) {

//     $orders->when($products_search,function($query,$products_search){
//         // $query->where('id',$products_search);
//         $query->whereJsonContains('content->id',$products_search);
//     });
// }
// if ($request->category_id) {

//     $products->when($categories_search,function($query,$categories_search){
//         $query->where('category_id',$categories_search);
//     });
// }

// if ($request->repository_id) {

//     $products->when($repositories_search,function($query,$repositories_search){
//         $query->where('repository_id',$repositories_search);
//     });
// }
// if ($request->author_id) {

//     $products->when($authors_search,function($query,$authors_search){
//         $query->where('author_id',$authors_search);
//     });
// }

//obtener productos del filtro
// $products=$products->get();

    // $orders = Order::whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
    // $orders = $orders->get();
