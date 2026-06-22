@extends('layouts.app')

@section('title')
    Invoices
@endsection


@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>
                    رقم الفاتورة
                </th>
                <th>
                    العميل
                </th>
                <th>
                    الإجمالي
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>
                        {{ $invoice->invoice_no }}
                    </td>
                    <td>
                        {{ $invoice->customer->name }}
                    </td>
                    <td>
                        {{ $invoice->grand_total }}
                    </td>
                    <td>
                        <a href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-primary">
                            View
                        </a>
                        <a href="{{ route('invoice.pdf', $invoice->id) }}" class="btn btn-danger">
                            PDF
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
