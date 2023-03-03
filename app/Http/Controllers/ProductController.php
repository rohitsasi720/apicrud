<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        $products = product::latest()->paginate(5);

        return view('products.index', compact('products'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('products.create');
    }

    public function show(string $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return view('products.show', compact('product'));
        // return view('products.show');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return view('products.edit', compact('product'));
    }

}