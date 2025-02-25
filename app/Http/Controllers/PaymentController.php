<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Bill;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // List All Payments
    public function index()
    {
        $payments = Payment::with(['patient', 'bill'])->get();
        $patients = Patient::all();
        $bills = Bill::all();
        return view('admin.payments.index', compact('payments', 'patients', 'bills'));
    }

    // Store New Payment using AJAX
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'bill_id' => 'required|exists:bills,id',
            'amount' => 'required|numeric',
            'status' => 'required|in:paid,unpaid',
            'mode' => 'required|in:cash,card,cheque,online',
        ]);

        $payment = Payment::create([
            'patient_id' => $request->patient_id,
            'bill_id' => $request->bill_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'mode' => $request->mode,
        ]);

        return response()->json(['success' => true, 'message' => 'Payment added successfully.', 'payment' => $payment]);
    }

    // Get Payment Details
    public function show(Payment $payment)
    {
        return response()->json(['success' => true, 'data' => $payment]);
    }

    // Update Payment using AJAX
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'bill_id' => 'required|exists:bills,id',
            'amount' => 'required|numeric',
            'status' => 'required|in:paid,unpaid',
            'mode' => 'required|in:cash,card,cheque,online',
        ]);

        $payment->update([
            'patient_id' => $request->patient_id,
            'bill_id' => $request->bill_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'mode' => $request->mode,
        ]);

        return response()->json(['success' => true, 'message' => 'Payment updated successfully.', 'payment' => $payment]);
    }

    // Delete Payment using AJAX
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['success' => true, 'message' => 'Payment deleted successfully.']);
    }
}
