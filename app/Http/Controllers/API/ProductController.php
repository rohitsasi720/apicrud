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
        $products = product::latest()->paginate(5);

        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    public function show($id)
    {
        //dd($id);
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        // return view('products.show', compact('product'));
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        //$image_path = $request->file('image')->storeAs('public/images', $request->file('image')->getClientOriginalName());
        $name = $request->input('name');
        $existingProduct = Product::where('name', $name)->first();

        if ($existingProduct) {
            $input = $request->all();

            if ($image = $request->file('image')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = "$profileImage";
            }

            $newProduct = Product::create($input);

            $input['handle'] = str_replace(' ', '-', $name) . '-' . $newProduct->id;
            $newProduct->update(['handle' => $input['handle']]);
            return response()->json(['message' => 'Product created successfully.'], 201);
        } else {
            $input = $request->all();
            $input['handle'] = str_replace(' ', '-', $name);

            if ($image = $request->file('image')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = "$profileImage";
            }

            $newProduct = Product::create($input);
            return response()->json(['message' => 'Product created successfully.'], 201);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'image' => 'required'
        ]);

        $product = Product::find($id);
        if ($product) {
            $name = $request->input('name');
            $existingProduct = Product::where('name', $name)->first();
            $input = $request->all();

            if ($image = $request->file('image')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = "$profileImage";
            }

            if ($existingProduct) {
                $input['handle'] = str_replace(' ', '-', $name) . '-' . $product->id;
            } else {
                $input['handle'] = str_replace(' ', '-', $name);
            }
            $product->update($input);
            return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
        } else {
            return $this->sendError('Product not found.');
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return $this->sendResponse([], 'Product deleted successfully.');
        } else {
            return $this->sendError('Product not found.');
        }
    }
}