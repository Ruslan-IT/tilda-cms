<?php
namespace App\Http\Controllers;

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
            'items' => 'required|array',
            'total' => 'required'
        ]);

        $orderId = rand(100000, 999999);

        Mail::to(env('ADMIN_EMAIL'))->send(
            new OrderMail($validated, $orderId)
        );

        return response()->json([
            'success' => true,
            'order_id' => $orderId,
            'total' => $validated['total'],
        ]);
    }
}

