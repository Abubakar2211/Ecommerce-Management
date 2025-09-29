<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $userId = $order->user_id;
        $orderId = $order->id;
        $orderQunatity = $order->quantity;
        $product = Product::find($order->product_id);
        $product->update([
            'stock' => $product->stock - $orderQunatity
        ]);
        Log::info("New Order Created", ['order_id' => $orderId, 'user_id' => $userId]);
    }

    /**
     * Handle the Order "updated" event.
     */

    public function updated(Order $order): void
    {
        $productLatestQunatity = $order->quantity;
        $productQunatity = strval($order->getOriginal('quantity'));
        if ($productLatestQunatity > $productQunatity) {
            $stock = $productLatestQunatity - $productQunatity;
            Product::where('id', $order->product_id)->decrement('stock', $stock);
        } else {
            $stock = $productQunatity - $productLatestQunatity;
            Product::where('id', $order->product_id)->increment('stock', $stock);
        }
    }

    public function deleted(Order $order): void
    {
        $orderQunatity = $order->quantity;
        $product = Product::find($order->product_id);
        $product->update([
            'stock' => $product->stock + $orderQunatity
        ]);
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
