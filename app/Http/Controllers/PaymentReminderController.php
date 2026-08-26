<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class PaymentReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overdueInvoices = Invoice::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->with(['customer', 'payments'])
            ->orderBy('due_date')
            ->paginate(10);
        
        $upcomingInvoices = Invoice::where('payment_status', '!=', 'paid')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->with(['customer', 'payments'])
            ->orderBy('due_date')
            ->paginate(10);
        
        return view('payment-reminders.index', compact('overdueInvoices', 'upcomingInvoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = Invoice::where('payment_status', '!=', 'paid')
            ->with('customer')
            ->orderBy('due_date')
            ->get();
        
        return view('payment-reminders.create', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'reminder_type' => 'required|in:email,sms,whatsapp',
            'scheduled_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::with('customer')->find($validated['invoice_id']);
        
        // Send reminder (simulated)
        $message = $this->generateReminderMessage($invoice, $validated['reminder_type']);
        
        // Log the reminder (in real implementation, send actual message)
        \Log::info("Payment reminder sent", [
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer->id,
            'type' => $validated['reminder_type'],
            'message' => $message
        ]);

        return redirect()->route('payment-reminders.index')
            ->with('success', 'Pengingat pembayaran berhasil dikirim ke ' . $invoice->customer->name);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'payments'])->findOrFail($id);
        return view('payment-reminders.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('payment-reminders.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        return redirect()->route('payment-reminders.index')
            ->with('info', 'Pengingat pembayaran dikelola melalui pengiriman pesan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return redirect()->route('payment-reminders.index')
            ->with('error', 'Pengingat pembayaran tidak dapat dihapus.');
    }

    /**
     * Generate reminder message
     */
    private function generateReminderMessage($invoice, $type)
    {
        $daysOverdue = now()->diffInDays($invoice->due_date, false);
        
        $message = "Yth. " . $invoice->customer->name . ",\n\n";
        $message .= "Ini adalah pengingat pembayaran untuk invoice " . $invoice->invoice_number . ".\n";
        $message .= "Jumlah yang harus dibayar: Rp " . number_format($invoice->remaining_amount, 0, ',', '.') . "\n";
        $message .= "Jatuh tempo: " . $invoice->due_date->format('d-m-Y') . "\n";
        
        if ($daysOverdue > 0) {
            $message .= "Invoice telah overdue selama " . abs($daysOverdue) . " hari.\n";
        } else {
            $message .= "Invoice akan jatuh tempo dalam " . abs($daysOverdue) . " hari.\n";
        }
        
        $message .= "\nMohon segera lakukan pembayaran.\n\n";
        $message .= "Terima kasih.";
        
        return $message;
    }

    /**
     * Send bulk reminders
     */
    public function sendBulkReminders(Request $request)
    {
        $validated = $request->validate([
            'reminder_type' => 'required|in:email,sms,whatsapp',
            'filter' => 'required|in:overdue,upcoming,all',
        ]);

        $query = Invoice::where('payment_status', '!=', 'paid');
        
        if ($validated['filter'] === 'overdue') {
            $query->where('due_date', '<', now());
        } elseif ($validated['filter'] === 'upcoming') {
            $query->whereBetween('due_date', [now(), now()->addDays(7)]);
        }
        
        $invoices = $query->with('customer')->get();
        
        $sentCount = 0;
        foreach ($invoices as $invoice) {
            $message = $this->generateReminderMessage($invoice, $validated['reminder_type']);
            
            \Log::info("Bulk payment reminder sent", [
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer->id,
                'type' => $validated['reminder_type'],
                'message' => $message
            ]);
            
            $sentCount++;
        }

        return redirect()->route('payment-reminders.index')
            ->with('success', "Berhasil mengirim {$sentCount} pengingat pembayaran.");
    }

    /**
     * Get realtime payment reminder data (API endpoint)
     */
    public function getRealtimeData()
    {
        $overdueCount = Invoice::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->count();
        
        $upcomingCount = Invoice::where('payment_status', '!=', 'paid')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->count();
        
        $totalOverdueAmount = Invoice::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->sum('remaining_amount');
        
        return response()->json([
            'success' => true,
            'overdue_count' => $overdueCount,
            'upcoming_count' => $upcomingCount,
            'total_overdue_amount' => $totalOverdueAmount,
            'last_updated' => now()->format('Y-m-d H:i:s')
        ]);
    }
}