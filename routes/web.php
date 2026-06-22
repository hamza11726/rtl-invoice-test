<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return redirect()->route('invoice.create');
});


Route::get('/invoice/create',[InvoiceController::class,'create'])->name('invoice.create');

Route::post('/invoice/store',[InvoiceController::class,'store'])->name('invoice.store');

Route::post('/customer/store',[CustomerController::class,'store'])->name('customer.store');

Route::get('/invoice/{invoice}',[InvoiceController::class,'show'])->name('invoice.show');

Route::get('/invoice/{invoice}/pdf',[InvoiceController::class,'pdf'])->name('invoice.pdf');

Route::get('/invoices',[InvoiceController::class,'index'])->name('invoice.index');
