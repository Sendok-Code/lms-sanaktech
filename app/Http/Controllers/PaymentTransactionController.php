<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'enrollment.course'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.transactions.index', compact('payments'));
    }
}
