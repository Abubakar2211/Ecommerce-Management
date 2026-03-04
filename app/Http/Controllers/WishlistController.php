<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist = Wishlist::all();
        return response()->json($wishlist);
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        try{
            $validate = $request->validate([
                'user_id' => 'required',
                'product_id' => 'required'
            ]);
            $wishlist = Wishlist::create($validate);
            return response()->json(['message' => 'Wishlist created successfully']);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Wishlist $wishlist)
    {
        try{
            $validate = $request->validate([
                'user_id' => 'required|exists:users,id',
                'product_id' => 'required|exists:products,id'
            ]);
            $wishlist->update($validate);
            return response()->json(['message' => 'Wishlist updated successfully']);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Wishlist $wishlist)
    {
        try{
            $wishlist->delete();
            return response()->json(['message' => 'Wishlist deleted successfully']);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
