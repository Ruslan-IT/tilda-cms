<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CustomDiskController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'comments' => 'required|string',
        ]);

        try {
            Mail::raw(
                "Имя: {$request->name}\nE-mail: {$request->email}\nКомментарии: {$request->comments}",
                function ($message) use ($request) {
                    $message->to(env('ADMIN_EMAIL')) // <- сюда придёт письмо
                        ->subject('Новая заявка на кастомный диск');
                }
            );

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Custom disk mail error: '.$e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

