@extends('layouts.app')

@section('title')
    Invoice {{ $invoice->invoice_no }}
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4>
                    فاتورة {{ $invoice->invoice_no }}
                </h4>
                <a href="{{ route('invoice.pdf', $invoice->id) }}" class="btn btn-danger">
                    PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6>
                        العميل
                    </h6>
                    <p>
                        {{ $invoice->customer->name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h6>
                        التاريخ
                    </h6>
                    <p>
                        {{ $invoice->created_at->format('Y-m-d') }}
                    </p>
                </div>
            </div>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>
                            الصنف
                        </th>
                        <th>
                            الكمية
                        </th>
                        <th>
                            السعر
                        </th>
                        <th>
                            الخصم
                        </th>
                        <th>
                            الضريبة
                        </th>
                        <th>
                            الإجمالي
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>
                                {{ $item->item_name }}
                            </td>
                            <td>
                                {{ $item->qty }}
                            </td>
                            <td>
                                {{ $item->unit_price }}
                            </td>
                            <td>
                                {{ $item->discount }}
                            </td>
                            <td>
                                {{ $item->tax }}
                            </td>
                            <td>
                                {{ $item->total }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-4">
                    <label>
                        المجموع الفرعي
                    </label>
                    <input class="form-control" value="{{ $invoice->subtotal }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>
                        الخصم
                    </label>
                    <input class="form-control" value="{{ $invoice->discount }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>
                        الإجمالي النهائي
                    </label>
                    <input class="form-control" value="{{ $invoice->grand_total }}" readonly>
                </div>
            </div>
        </div>
    </div>
@endsection
