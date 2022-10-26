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
