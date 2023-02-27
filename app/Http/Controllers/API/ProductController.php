<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends BaseController
{


    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'image' => 'required'
        ]);

        $name = $request->input('name');
        $existingProduct = Product::where('name', $name)->first();

        if ($existingProduct) {
            $input = $request->all();
            $newProduct = Product::create($input);
            $input['handle'] = str_replace(' ', '-', $name) . '-' . $newProduct->id;
            $newProduct->update(['handle' => $input['handle']]);
            return response()->json(['message' => 'Product created successfully.'], 201);
        } 
        else {
            $input = $request->all();
            $input['handle'] = str_replace(' ', '-', $name);
            $newProduct = Product::create($input);
            return response()->json(['message' => 'Product created successfully.'], 201);
        }
    }

    
    public function update(Request $request, $id)
    {
       $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'image' => 'required'
        ]);

        $product = Product::find($id);
        if($product){
            $name = $request->input('name');
            $existingProduct = Product::where('name', $name)->first();
            $input = $request->all();

            if ($existingProduct) {
                $input['handle'] = str_replace(' ', '-', $name) . '-' . $product->id;
            } 
            else {
                $input['handle'] = str_replace(' ', '-', $name);
            }
            $product->update($input);
            return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
        } 
        else {
            return $this->sendError('Product not found.');
        }

    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return $this->sendResponse([], 'Product deleted successfully.');
        } 
        else {
            return $this->sendError('Product not found.');
        }
    }
    
}   