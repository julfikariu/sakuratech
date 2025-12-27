<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\Admin\Payment\PaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index(Request $request)
    {
        $query = Payment::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('invoice_id', 'like', "%{$search}%");
        }

        // Filter by payment method
        if ($request->filled('method') && $request->get('method') !== 'all') {
            $query->where('payment_method', $request->get('method'));
        }

        // Sort by latest first
        $paginator = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Transform to match frontend expectations
        $paginator->getCollection()->transform(function ($payment) {
            return [
                'id' => $payment->id,
                'invoice_id' => $payment->invoice_id,
                'user_id' => $payment->user_id,
                'amount' => (float) $payment->amount,
                'payment_date' => $payment->payment_date?->format('Y-m-d'),
                'payment_method' => $payment->payment_method,
                'transaction_id' => $payment->transaction_id,
                'notes' => $payment->notes,
                'created_at' => $payment->created_at?->format('d M Y, h:i A'),
            ];
        });

        return Inertia::render('admin/payments/Index', [
            'payments' => $paginator,
        ]);
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $invoices = Invoice::orderBy('id', 'desc')->take(50)->get()->map(function ($inv) {
            return [ 'id' => $inv->id, 'label' => $inv->inv_unique_id ?? '#'.$inv->id ];
        });

        $paymentMethods = ['credit_card','bank_transfer','paypal','check','cash','other'];

        return Inertia::render('admin/payments/Form', [
            'invoices' => $invoices,
            'paymentMethods' => $paymentMethods,
            'is_edit' => false,
        ]);
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(PaymentRequest $request)
    {
        Payment::create([
            'invoice_id' => $request->invoice_id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.payments.index')->with('flash', [
            'message' => 'Payment created successfully!',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $data = [
            'id' => $payment->id,
            'invoice_id' => $payment->invoice_id,
            'user_id' => $payment->user_id,
            'amount' => (float) $payment->amount,
            'payment_date' => $payment->payment_date,
            'payment_method' => $payment->payment_method,
            'transaction_id' => $payment->transaction_id,
            'notes' => $payment->notes,
            'created_at' => $payment->created_at?->format('d M Y, h:i A'),
        ];
        return Inertia::render('admin/payments/DetailsModal', [
            'payment' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        $invoices = Invoice::orderBy('id', 'desc')->take(50)->get()->map(function ($inv) {
            return [ 'id' => $inv->id, 'label' => $inv->inv_unique_id ?? '#'.$inv->id ];
        });

        $data = [
            'id' => $payment->id,
            'invoice_id' => $payment->invoice_id,
            'user_id' => $payment->user_id,
            'amount' => (float) $payment->amount,
            'payment_date' => $payment->payment_date,
            'payment_method' => $payment->payment_method,
            'transaction_id' => $payment->transaction_id,
            'notes' => $payment->notes,
        ];

        return Inertia::render('admin/payments/Form', [
            'payment' => $data,
            'invoices' => $invoices,
            'is_edit' => true,
        ]);
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:credit_card,bank_transfer,paypal,check,cash,other',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id,' . $payment->id,
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('flash', [
            'message' => 'Payment updated successfully!',
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('flash', [
            'message' => 'Payment deleted successfully!',
            'type' => 'success',
        ]);
    }
}
