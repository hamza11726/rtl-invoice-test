<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class InvoiceController extends Controller
{
    public function index()
    {

        $invoices = Invoice::with('customer')
        ->latest()
        ->get();

        return view(
            'invoice.index',
            compact('invoices')
        );

    }

    public function create()
    {
        $customers = Customer::latest('created_at')->get();
        return view('invoice.create',compact('customers'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'customer_id'=>'required|exists:customers,id',
            'invoice_no'=>'required',
            'items'=>'required|array',
            'items.*.item_name'=>'required',
            'items.*.qty'=>'required|numeric|min:1',
            'items.*.unit_price'=>'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $discount = 0;
            $tax = 0;

            foreach($request->items as $item)
            {
                $subtotal += $item['qty'] * $item['unit_price'];
                $discount += $item['discount'] ?? 0;
                $tax += $item['tax'] ?? 0;
            }

            $grandTotal =
            $subtotal - $discount + $tax;

            $invoice = Invoice::create([
                'customer_id'=>$request->customer_id,
                'invoice_no'=>$request->invoice_no,
                'subtotal'=>$subtotal,
                'discount'=>$discount,
                'tax'=>$tax,
                'grand_total'=>$grandTotal,
            ]);

            foreach($request->items as $item)
            {
                InvoiceItem::create([
                    'invoice_id'=>$invoice->id,
                    'item_name'=>$item['item_name'],
                    'qty'=>$item['qty'],
                    'unit_price'=>$item['unit_price'],
                    'discount'=>$item['discount'] ?? 0,
                    'tax'=>$item['tax'] ?? 0,
                    'total'=>
                    ($item['qty'] * $item['unit_price'])
                    - ($item['discount'] ?? 0)
                    + ($item['tax'] ?? 0)

                ]);

            }

            DB::commit();

            return redirect()
            ->route('invoice.show',$invoice->id)
            ->with('success','Invoice created successfully');
        }catch(\Exception $e){
            DB::rollBack();

            return back()
            ->with('error',$e->getMessage());

        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load([
            'customer',
            'items'
        ]);

        return view(
            'invoice.show',
            compact('invoice')
        );

    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load([
            'customer',
            'items'
        ]);

        $html = view(
            'invoice.pdf',
            compact('invoice')
        )->render();

        $mpdf = new Mpdf([
            'mode'=>'utf-8',
            'format'=>'A4',
            'directionality'=>'rtl',
            'default_font'=>'dejavusans'
        ]);

        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output(
                $invoice->invoice_no.'.pdf',
                'I'
            )
        )
        ->header(
            'Content-Type',
            'application/pdf'
        );
    }
}
