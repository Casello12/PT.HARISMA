<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class AccountsReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with(['invoices', 'invoices.payments'])
            ->whereHas('invoices', function($query) {
                $query->where('payment_status', '!=', 'paid');
            })
            ->orderBy('name')
            ->paginate(10);
        
        $totalReceivable = Invoice::where('payment_status', '!=', 'paid')->sum('remaining_amount');
        $overdueReceivable = Invoice::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->sum('remaining_amount');
        
        return view('accounts-receivable.index', compact('customers', 'totalReceivable', 'overdueReceivable'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts-receivable.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Accounts receivable is typically calculated from invoices, not manually created
        return redirect()->route('accounts-receivable.index')
            ->with('info', 'Piutang dihitung otomatis dari invoice yang belum lunas.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['invoices' => function($query) {
            $query->where('payment_status', '!=', 'paid')->with('payments');
        }]);
        
        $totalDue = $customer->invoices->sum('remaining_amount');
        $overdueAmount = $customer->invoices->where('due_date', '<', now())->sum('remaining_amount');
        
        return view('accounts-receivable.show', compact('customer', 'totalDue', 'overdueAmount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('accounts-receivable.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        // Accounts receivable is managed through invoices and payments
        return redirect()->route('accounts-receivable.show', $customer)
            ->with('info', 'Piutang dikelola melalui invoice dan pembayaran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return redirect()->route('accounts-receivable.index')
            ->with('error', 'Piutang tidak dapat dihapus secara manual. Silakan kelola melalui invoice dan pembayaran.');
    }

    /**
     * Get realtime accounts receivable data (API endpoint)
     */
    public function getRealtimeData()
    {
        $totalReceivable = Invoice::where('payment_status', '!=', 'paid')->sum('remaining_amount');
        $overdueReceivable = Invoice::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->sum('remaining_amount');
        
        $pendingInvoices = Invoice::where('payment_status', '!=', 'paid')
            ->with(['customer', 'payments'])
            ->orderBy('due_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'total_receivable' => $totalReceivable,
            'overdue_receivable' => $overdueReceivable,
            'pending_invoices' => $pendingInvoices,
            'last_updated' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get customer accounts receivable details (API endpoint)
     */
    public function getCustomerReceivable(Customer $customer)
    {
        $customer->load(['invoices' => function($query) {
            $query->where('payment_status', '!=', 'paid')->with('payments');
        }]);
        
        $totalDue = $customer->invoices->sum('remaining_amount');
        $overdueAmount = $customer->invoices->where('due_date', '<', now())->sum('remaining_amount');
        
        return response()->json([
            'success' => true,
            'customer' => $customer,
            'total_due' => $totalDue,
            'overdue_amount' => $overdueAmount,
            'invoices' => $customer->invoices
        ]);
    }
}