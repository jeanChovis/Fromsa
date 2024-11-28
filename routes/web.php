<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerPersonController;
use App\Http\Controllers\CustomerCompanyController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOutputController;
use App\Http\Controllers\ProductEntryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/panel', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/registrar', [RegisteredUserController::class, 'create'])->name('auth.register');


Route::middleware('auth')->group(function () {  
    Route::resource('categoria', CategoryController::class);
    Route::get('/IndiceCategoria', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/apiCategoria', [CategoryController::class, 'apiCategory'])->name('api.category'); 
    Route::get('/exportarCategoriaPDF', [CategoryController::class, 'exportPdf'])->name('exportPDF.categoryAll');
    Route::get('/exportarCategoriaEXCEL', [CategoryController::class, 'exportExcel'])->name('exportExcel.categoryAll');

    Route::resource('producto', ProductController::class);
    Route::get('/IndiceProducto', [ProductController::class, 'index'])->name('product.index');
    Route::get('/apiProducto', [ProductController::class, 'apiProduct'])->name('api.product');
    
    Route::resource('cliente', CustomerController::class);
    Route::post('/ingresarCliente', [CustomerController::class, 'store']);
    Route::get('/IndiceCliente', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('apiCliente', [CustomerController::class, 'apiCustomer'])->name('api.customer');  
    Route::post('/importarCliente', [CustomerController::class, 'importCustomer'])->name('import.customer');
    Route::get('/exportarClientePDF', [CustomerController::class, 'exportPdf'])->name('exportPDF.customerAll');
    Route::get('/exportarClienteEXCEL', [CustomerController::class, 'exportExcel'])->name('exportExcel.customerAll');

    Route::resource('proveedor', SupplierController::class);
    Route::get('/IndiceProveedor', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('apiProveedor', [SupplierController::class, 'apiSupplier'])->name('api.supplier');  
    Route::post('/importarProveedor', [SupplierController::class, 'importSupplier'])->name('import.supplier');
    Route::get('/exportarProveedorPDF', [SupplierController::class, 'exportPdf'])->name('exportPDF.supplierAll');
    Route::get('/exportarProveedorEXCEL', [SupplierController::class, 'exportExcel'])->name('exportExcel.supplierAll');

    Route::resource('comprarProducto', ProductEntryController::class);
    Route::get('/IndiceComprarProducto', [ProductEntryController::class, 'index'])->name('product_entry.index');
    Route::get('apiComprarProducto', [ProductEntryController::class, 'apiEntryProduct'])->name('api.entryproduct');
    Route::get('/exportarCompraPDF', [ProductEntryController::class, 'exportProductEntryPdf'])->name('exportPDF.entryproductAll');
    Route::get('/exportarCompraEXCEL', [ProductEntryController::class, 'exportProductEntryExcel'])->name('exportExcel.entryproductAll');
    Route::get('/exportarCompra/{id}', [ProductEntryController::class, 'exportProductEntry'])->name('exportPDF.productEntry');

    Route::resource('venderProducto', ProductOutputController::class);
    Route::get('/IndiceVenderProducto', [ProductOutputController::class, 'index'])->name('product_output.index');
    Route::get('apiVenderProducto', [ProductOutputController::class, 'apiProductsOutput'])->name('api.outputproduct');
    Route::get('/exportarVenderPDF', [ProductOutputController::class, 'exportProductOutputPdf'])->name('exportPDF.outputproductAll');
    Route::get('/exportarVenderEXCEL', [ProductOutputController::class, 'exportProductOutputExcel'])->name('exportExcel.outputproductAll');
    Route::get('/exportarVender/{id}', [ProductOutputController::class, 'exportProductOutput'])->name('exportPDF.productOutput');

    Route::get('/usuario', [UserController::class, 'index'])->name('user.index');
    Route::get('/apiUsuario', [UserController::class, 'apiUsers'])->name('api.users');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__.'/auth.php';
