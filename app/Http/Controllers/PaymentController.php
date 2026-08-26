<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['invoice.customer', 'verifiedBy'])->orderBy('payment_date', 'desc')->paginate(10);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $query = Invoice::where('payment_status', '!=', 'paid')->with('customer');
        
        if ($request->has('invoice_id')) {
            $query->where('id', $request->invoice_id);
        }
        
        $invoices = $query->get();
        return view('payments.create', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,transfer,credit_card,debit_card,check,other',
            'amount' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'account_name' => 'nullable|string',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,verified,rejected',
        ]);

        // Generate payment number
        $validated['payment_number'] = 'PAY-' . now()->format('Ymd') . '-' . str_pad(Payment::count() + 1, 4, '0');
        $validated['verified_by'] = $validated['status'] === 'verified' ? auth()->id() : null;
        $validated['verified_at'] = $validated['status'] === 'verified' ? now() : null;
        $validated['created_by'] = auth()->id();

        $payment = Payment::create($validated);

        // Update invoice payment status
        $invoice = Invoice::find($validated['invoice_id']);
        $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
        
        if ($validated['status'] === 'verified') {
            $totalPaid += $payment->amount;
        }
        
        $invoice->paid_amount = $totalPaid;
        $invoice->remaining_amount = $invoice->grand_total - $totalPaid;
        
        if ($invoice->remaining_amount <= 0) {
            $invoice->payment_status = 'paid';
        } elseif ($invoice->paid_amount > 0) {
            $invoice->payment_status = 'partial';
        }
        
        $invoice->save();
        
        if ($validated['status'] === 'verified') {
            $invoice->paid_amount = $totalPaid;
            $invoice->remaining_amount = $invoice->grand_total - $totalPaid;
            
            if ($invoice->remaining_amount <= 0) {
                $invoice->payment_status = 'paid';
            } elseif ($invoice->paid_amount > 0) {
                $invoice->payment_status = 'partial';
            }
            
            $invoice->save();
        }

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['invoice.customer', 'verifiedBy']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment, Request $request)
    {
        $query = Invoice::where('payment_status', '!=', 'paid')->with('customer');
        
        if ($request->has('invoice_id')) {
            $query->where('id', $request->invoice_id);
        }
        
        $invoices = $query->get();
        return view('payments.edit', compact('payment', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,transfer,credit_card,debit_card,check,other',
            'amount' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'account_name' => 'nullable|string',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $oldStatus = $payment->status;
        $validated['verified_by'] = $validated['status'] === 'verified' ? auth()->id() : null;
        $validated['verified_at'] = $validated['status'] === 'verified' ? now() : null;

        $payment->update($validated);

        // Update invoice payment status if status changed
        if ($oldStatus !== $validated['status']) {
            $invoice = Invoice::find($validated['invoice_id']);
            $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
            
            if ($validated['status'] === 'verified') {
                $totalPaid += $payment->amount;
            }
            
            $invoice->paid_amount = $totalPaid;
            $invoice->remaining_amount = $invoice->grand_total - $totalPaid;
            
            if ($invoice->remaining_amount <= 0) {
                $invoice->payment_status = 'paid';
            } elseif ($invoice->paid_amount > 0) {
                $invoice->payment_status = 'partial';
            } else {
                $invoice->payment_status = 'unpaid';
            }
            
            $invoice->save();
        }

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $invoice = $payment->invoice;
        
        $payment->delete();

        // Recalculate invoice payment status
        $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
        $invoice->paid_amount = $totalPaid;
        $invoice->remaining_amount = $invoice->grand_total - $totalPaid;
        
        if ($invoice->remaining_amount <= 0) {
            $invoice->payment_status = 'paid';
        } elseif ($invoice->paid_amount > 0) {
            $invoice->payment_status = 'partial';
        } else {
            $invoice->payment_status = 'unpaid';
        }
        
        $invoice->save();

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }

    /**
     * Verify payment
     */
    public function verify(Payment $payment)
    {
        $payment->status = 'verified';
        $payment->verified_by = auth()->id();
        $payment->verified_at = now();
        $payment->save();

        // Update invoice payment status
        $invoice = $payment->invoice;
        $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
        $invoice->paid_amount = $totalPaid;
        $invoice->remaining_amount = $invoice->grand_total - $totalPaid;
        
        if ($invoice->remaining_amount <= 0) {
            $invoice->payment_status = 'paid';
        } elseif ($invoice->paid_amount > 0) {
            $invoice->payment_status = 'partial';
        }
        
        $invoice->save();

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Reject payment
     */
    public function reject(Payment $payment)
    {
        $payment->status = 'rejected';
        $payment->verified_by = auth()->id();
        $payment->verified_at = now();
        $payment->save();

        // Recalculate invoice payment status
        $invoice = $payment->invoice;
        $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
        $invoice->paid_amount = $totalPaid;
        $invoice->remaining_amount = $invoice->grand_total - $totalPaid;
        
        if ($invoice->remaining_amount <= 0) {
            $invoice->payment_status = 'paid';
        } elseif ($invoice->paid_amount > 0) {
            $invoice->payment_status = 'partial';
        } else {
            $invoice->payment_status = 'unpaid';
        }
        
        $invoice->save();

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil ditolak.');
    }
}