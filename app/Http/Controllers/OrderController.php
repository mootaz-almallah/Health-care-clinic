<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
    public function generateInvoice(Order $order)
    {
        // التحقق من أن المستخدم هو صاحب الطلب
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $data = [
            'order' => $order,
            'user' => auth()->user(),
            'items' => $order->items,
            'date' => now()->format('Y-m-d H:i:s')
        ];

        $pdf = PDF::loadView('pdf.invoice', $data);
        
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
} 