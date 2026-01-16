<?php

namespace App\Http\Controllers;

use App\Events\OrderDeleted;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Events\OrderCreated;
use App\Observers\OrderObserver;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::get();
        return response()->json(['orders' => $orders]);
        // $orders = Order::with(['product:id,name,price,stock,description,image', 'user:id,name,email'])
        //                 ->where('status', 'Completed')->orderby('id', 'desc')
        //                 ->cursorPaginate(2,['id','user_id','product_id','quantity','status']);
        // return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        Order::with('product')->create([
            'user_id' => auth()->id(),
            'total_price' => $request->total_price,
            'status' => $request->status
        ]);
        return response()->json(["message" => "$product->name Product Has Been Buy."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = Product::findOrFail($id)->where('id', $id)->first(['id', 'name', 'price', 'stock', 'description', 'image']);
        return view('order.create', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->with('product')->first();
        return response()->json(["message" => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->update([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);
        return response()->json(["message", "Order Has Been Updated Successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(["message", "Order Deleted Successfully."]);
    }

    public function cardview()
    {

        $orders = Order::with('product:id,name,price,stock,image')->where('user_id', auth()->id())
            ->where('status', '!=', 'Completed')->orderby('id', 'desc')
            ->Paginate(1, ['id', 'user_id', 'product_id', 'quantity', 'status']);
        $total_price = Order::where('user_id', auth()->id())
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->selectRaw('SUM(products.price * orders.quantity) as total')->value('total');
        return view('product.card', compact('orders', 'total_price'));
    }
}


