<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice {{ $invoice->inv_unique_id }}</title>

<style>
    body {
        font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #1f2937;
    }

    h1,h2,h3 { margin: 0; }

    .muted { color: #6b7280; font-size: 11px; }

    table { width: 100%; border-collapse: collapse; }

    /* ===== TOP HEADER ===== */
    .header-table td {
        vertical-align: top;
        padding-bottom: 20px;
    }

    .status {
        text-align: right;
        font-size: 22px;
        letter-spacing: 1px;
        color: #6b7280;
        font-weight: bold;
    }

    /* ===== PARTY ===== */
    .party-table td {
        vertical-align: top;
        padding-bottom: 20px;
    }

    /* ===== META ===== */
    .meta-table td {
        vertical-align: top;
        padding: 6px 0;
    }

    /* ===== ITEMS ===== */
    .items th {
        text-align: left;
        background: #f3f4f6;
        border-bottom: 2px solid #d1d5db;
        padding: 8px;
    }

    .items td {
        padding: 8px;
        border-bottom: 1px solid #e5e7eb;
    }

    .right { text-align: right; }

    /* ===== TOTAL ===== */
    .total-row td {
        padding-top: 14px;
        font-size: 14px;
        font-weight: bold;
        color: #ef4444;
    }

</style>
</head>

<body>

{{-- ===== HEADER ===== --}}
<table class="header-table">
<tr>
    <td>
        <img src="{{ public_path('logo.png') }}" height="28"><br><br>
    </td>
    <td class="status">
        {{ strtoupper($invoice->status ?? 'DRAFT') }}
    </td>
</tr>
</table>

{{-- ===== TITLE ===== --}}
<table>
<tr>
    <td>
        <h1>Invoice</h1>
        <div class="muted">INV-{{ $invoice->inv_unique_id }}</div>
    </td>
</tr>
</table>

<br>

{{-- ===== PARTY ===== --}}
<table class="party-table">
<tr>
    <td width="50%">
        <strong>ABC Inc</strong><br>
        10 Redcamp Road<br>
        Kent, Milehill<br>
        ZE12 8QT<br>
        United Kingdom<br>
        VAT No: ABG1038492
    </td>

    <td width="50%" align="right">
        <strong>{{ $invoice->client->company_name }}</strong><br>
        {{ $invoice->client->address }}<br>
        {{ $invoice->client->city }}<br>
        {{ $invoice->client->postcode }}<br>
        United Kingdom<br>
        VAT: {{ $invoice->client->vat ?? '—' }}
    </td>
</tr>
</table>

<?php
$paymentsSum = \App\Models\Payment::where('invoice_id',$invoice->id)->sum('amount');
$subtotal = $invoice->items->sum('total');
$balance = $subtotal - $paymentsSum;
?>

{{-- ===== META ===== --}}
<table class="meta-table" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <!-- Left -->
        <td width="50%">
            <table width="100%">
                <tr>
                    <td width="30%" style="font-weight:bold;">Invoice Date</td>
                    <td width="60%">{{ optional($invoice->issue_date)->format('m-d-Y') }}</td>
                </tr>
                <tr>
                    <td width="30%" style="font-weight:bold;">Due Date</td>
                    <td width="60%">{{ optional($invoice->due_date)->format('m-d-Y') }}</td>
                </tr>
            </table>
        </td>

        <!-- Right -->
        <td width="50%" align="right">
            <table width="100%">
                <tr>
                    <td width="40%" style="font-weight:bold; text-align: right;">Payments</td>
                    <td width="20%" align="right">${{ number_format($paymentsSum,2) }}</td>
                </tr>
                <tr>
                    <td width="40%" style="font-weight:bold; text-align: right;">Balance Due</td>
                    <td width="20%" align="right">${{ number_format($balance,2) }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>               

<br><br>

{{-- ===== ITEMS ===== --}}
<table class="items">
<thead>
<tr>
    <th width="55%">Description</th>
    <th width="10%" class="right">Qty</th>
    <th width="15%" class="right">Unit</th>
    <th width="10%" class="right">Rate</th>
    <th width="10%" style="text-align: right">Total</th>
</tr>
</thead>

<tbody>
@foreach($invoice->items as $item)
<tr>
    <td>{{ $item->description }}</td>
    <td class="">{{ $item->quantity }}</td>
    <td class="">1</td>
    <td class="">{{ number_format($item->price,2) }}</td>
    <td class="right">{{ number_format($item->total,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

{{-- ===== TOTAL ===== --}}
<br>
<table>
<tr class="total-row">
    <td width="80%" align="right">Total</td>
    <td width="20%" align="right">${{ number_format($subtotal,2) }}</td>
</tr>
</table>

<br><br>

{{-- ===== TERMS ===== --}}
<strong>Terms</strong><br>
<span class="muted">Thank you for your business.</span>

</body>
</html>
