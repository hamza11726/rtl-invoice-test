@extends('layouts.app')

@section('title')
    Create Invoice
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4>
                إنشاء فاتورة
            </h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('invoice.store') }}">
                @csrf
                <div class="mb-3">
                    <label>
                        العميل
                    </label>
                    <select name="customer_id" id="customer_id" class="form-control">
                        <option value="">
                            اختر العميل
                        </option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                        data-bs-target="#customerModal">
                        + إضافة عميل
                    </button>
                </div>
                <div class="mb-3">
                    <label>
                        رقم الفاتورة
                    </label>
                    <input type="text" name="invoice_no" class="form-control" value="INV-{{ time() }}">
                </div>
                <button type="button" id="addRow" class="btn btn-primary mb-2">
                    + إضافة صنف
                </button>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>الصنف</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الخصم</th>
                                <th>الضريبة</th>
                                <th>الإجمالي</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            <tr>
                                <td>
                                    <input class="form-control" name="items[0][item_name]">
                                </td>
                                <td>
                                    <input type="number" value="1" class="form-control qty" name="items[0][qty]">
                                </td>
                                <td>
                                    <input type="number" value="0" class="form-control price"
                                        name="items[0][unit_price]">
                                </td>
                                <td>
                                    <input type="number" value="0" class="form-control discount"
                                        name="items[0][discount]">
                                </td>
                                <td>
                                    <input type="number" value="0" class="form-control tax" name="items[0][tax]">
                                </td>
                                <td>
                                    <input readonly class="form-control total">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove">
                                        X
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>
                            المجموع الفرعي
                        </label>
                        <input readonly name="subtotal" id="subtotal" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>
                            الخصم
                        </label>
                        <input readonly name="discount" id="total_discount" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>
                            الإجمالي النهائي
                        </label>
                        <input readonly name="grand_total" id="grand_total" class="form-control">
                    </div>
                </div>
                <button class="btn btn-success mt-3">
                    حفظ الفاتورة
                </button>
            </form>
        </div>
    </div>
    <div class="modal fade" id="customerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        إضافة عميل
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="customerForm">
                        @csrf
                        <input name="name" class="form-control mb-2" placeholder="الاسم">
                        <input name="email" class="form-control mb-2" placeholder="البريد">
                        <input name="phone" class="form-control mb-2" placeholder="الهاتف">
                        <textarea name="address" class="form-control mb-2" placeholder="العنوان"></textarea>
                        <button type="submit" class="btn btn-success">
                            حفظ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#customerForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('customer.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    $('#customer_id').append(`
                        <option value="${response.id}">
                        ${response.name}
                        </option>
                    `);
                    $('#customer_id').val(response.id);
                    $('#customerModal').modal('hide');
                    $('#customerForm')[0].reset();
                }
            });
        });
        let row = 1;
        $('#addRow').click(function() {
            $('#items').append(`
                    <tr>
                        <td>
                            <input class="form-control"
                            name="items[${row}][item_name]">
                        </td>
                        <td>
                            <input type="number"
                            value="1"
                            class="form-control qty"
                            name="items[${row}][qty]">
                        </td>
                        <td>
                            <input type="number"
                            value="0"
                            class="form-control price"
                            name="items[${row}][unit_price]">
                        </td>
                        <td>
                            <input type="number"
                            value="0"
                            class="form-control discount"
                            name="items[${row}][discount]">
                        </td>
                        <td>
                            <input type="number"
                            value="0"
                            class="form-control tax"
                            name="items[${row}][tax]">
                        </td>
                        <td>
                            <input readonly class="form-control total">
                        </td>
                        <td>
                            <button type="button"
                            class="btn btn-danger remove">
                            X
                            </button>
                        </td>
                    </tr>
                `);
            row++;
        });
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
            calculate();
        });
        $(document).on('keyup change', '.qty,.price,.discount,.tax', function() {
            calculate();
        });

        function calculate() {
            let subtotal = 0;
            let discount = 0;
            let tax = 0;
            $('#items tr').each(function() {
                let qty = Number($(this).find('.qty').val());
                let price = Number($(this).find('.price').val());
                let dis = Number($(this).find('.discount').val());
                let tx = Number($(this).find('.tax').val());
                let total = (qty * price) - dis + tx;
                $(this).find('.total').val(total);
                subtotal += qty * price;
                discount += dis;
                tax += tx;
            });
            $('#subtotal').val(subtotal);
            $('#total_discount').val(discount);
            $('#grand_total').val(
                subtotal - discount + tax
            );
        }
    </script>
@endpush
