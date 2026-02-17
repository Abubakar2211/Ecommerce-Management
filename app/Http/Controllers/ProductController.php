<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::get();
        return response()->json(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $product = $request->validate([
                "name" => "required|string",
                "description" => "string|nullable",
                "price" => "required|integer",
                "stock" => "required|integer",
                "vendor_id" => "required|integer|exists:users,id",
                "image" => "nullable|image|mimes:jpg,png,jpeg",
                "category" => "nullable|string",
                "subcategory" => "nullable|string",
                "brand" => "nullable|string"
            ]);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $product['image'] = $image->storeAs("images", $imageName, 'public');
            }
            Product::create($product);
            return response()->json(["message" => 'Product Created ' . $product["name"]]);
        } catch (Exception $error) {
            return response()->json(["error" => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Request $request) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, Request $request)
    {
        try {
            $data = $request->validate([
                "name" => "required|string",
                "description" => "nullable|string",
                "price" => "required|integer",
                "stock" => "required|integer",
                "vendor_id" => "required|integer|exists:users,id",
                "image" => "nullable|image|mimes:jpg,png,jpeg",
                "category" => "nullable|string",
                "subcategory" => "nullable|string",
                "brand" => "nullable|string"
            ]);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $data['image'] = $image->storeAs("images", $imageName, 'public');
                Storage::disk('public')->delete($product->image);
            } else {
                $data['image'] = $product->image;
            }
            $product->update($data);
            return response()->json(["message" => 'Product Updated ' . $data["name"]]);
        } catch (Exception $error) {
            return response()->json(["error" => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
