<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

class OrderController extends Controller
{
    public function send(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'items' => 'required|array',
            'total' => 'required'
        ]);

        //dd($validated);

        $orderId = rand(1, 999999);

        // 1) сохраняем заказ
        $order = Order::create([
            'user_id' => $orderId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['contact'],
            'items' => $validated['items'],   // сохраняем весь массив как есть
            'total_price' => $validated['total'],
        ]);




        Mail::to(env('ADMIN_EMAIL'))->send(
            new OrderMail($validated, $orderId)
        );

        // Отправка письма пользователю
        Mail::to($validated['email'])->send(new OrderMail($validated, $orderId));

        return response()->json([
            'success' => true,
            'order_id' => $orderId,
            'total' => $validated['total'],
        ]);
    }
}

