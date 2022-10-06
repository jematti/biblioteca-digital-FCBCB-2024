<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Product;
use App\Models\Category;
use App\Models\Repository;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    public function index()
    {

        return view('filter');
    }

}
