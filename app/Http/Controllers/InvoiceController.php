<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\SalesOrder;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['customer', 'salesOrder'])->orderBy('invoice_date', 'desc')->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $salesOrders = SalesOrder::where('status', 'confirmed')->orWhere('status', 'payment_verified')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('invoices.create', compact('customers', 'salesOrders', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'payment_status' => 'required|in:unpaid,partial,paid,overdue',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.tax_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.notes' => 'nullable|string',
        ]);

        // Generate invoice number
        $validated['invoice_number'] = 'INV-' . now()->format('Ymd') . '-' . str_pad(Invoice::count() + 1, 4, '0');
        $validated['discount_amount'] = $validated['discount_amount'] ?? 0;
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0;
        $validated['tax_percentage'] = $validated['tax_percentage'] ?? 11;
        $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;
        $validated['paid_amount'] = 0;
        $validated['remaining_amount'] = $validated['grand_total'];
        $validated['is_sent'] = false;
        $validated['created_by'] = auth()->id();

        $items = $validated['items'];
        unset($validated['items']);

        $invoice = Invoice::create($validated);

        // Save items
        foreach ($items as $item) {
            $item['invoice_id'] = $invoice->id;
            $item['subtotal'] = $item['quantity'] * $item['unit_price'];
            $item['discount_amount'] = $item['discount_amount'] ?? 0;
            $item['discount_percentage'] = $item['discount_percentage'] ?? 0;
            $item['tax_amount'] = $item['tax_amount'] ?? 0;
            $item['tax_percentage'] = $item['tax_percentage'] ?? 0;
            $item['total_amount'] = $item['subtotal'] - $item['discount_amount'] + $item['tax_amount'];
            
            InvoiceItem::create($item);
        }

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'salesOrder', 'items.product', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $salesOrders = SalesOrder::where('status', 'confirmed')->orWhere('status', 'payment_verified')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $invoice->load('items');
        return view('invoices.edit', compact('invoice', 'customers', 'salesOrders', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'payment_status' => 'required|in:unpaid,partial,paid,overdue',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.tax_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.notes' => 'nullable|string',
        ]);

        $validated['discount_amount'] = $validated['discount_amount'] ?? 0;
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0;
        $validated['tax_percentage'] = $validated['tax_percentage'] ?? 11;
        $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;
        $validated['remaining_amount'] = $validated['grand_total'] - $invoice->paid_amount;

        $items = $validated['items'];
        unset($validated['items']);

        $invoice->update($validated);

        // Delete existing items
        $invoice->items()->delete();

        // Save new items
        foreach ($items as $item) {
            $item['invoice_id'] = $invoice->id;
            $item['subtotal'] = $item['quantity'] * $item['unit_price'];
            $item['discount_amount'] = $item['discount_amount'] ?? 0;
            $item['discount_percentage'] = $item['discount_percentage'] ?? 0;
            $item['tax_amount'] = $item['tax_amount'] ?? 0;
            $item['tax_percentage'] = $item['tax_percentage'] ?? 0;
            $item['total_amount'] = $item['subtotal'] - $item['discount_amount'] + $item['tax_amount'];
            
            InvoiceItem::create($item);
        }

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->payments()->count() > 0) {
            return redirect()->route('invoices.index')
                ->with('error', 'Invoice tidak dapat dihapus karena sudah memiliki pembayaran.');
        }

        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil dihapus.');
    }
}