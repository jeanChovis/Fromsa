<?php

namespace App\Http\Controllers;

use App\Exports\ExportProductEntry;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Product_Entry;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class ProductEntryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $suppliers = Supplier::orderBy('company_name','ASC')
            ->get()
            ->pluck('company_name','id');

        $invoice_data = Product_Entry::all();
        return view('product_entry.index', compact('products','suppliers','invoice_data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'    => 'required',
            'supplier_id'   => 'required',
            'amount'        => 'required',
            'date'          => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        Product_Entry::create($request->all());
    
        $product = Product::findOrFail($request->product_id);
        $product->stock += $request->amount;
        $product->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Compra creada'
        ]);
    }

    public function edit($id)
    {
        $product_entry = Product_Entry::find($id);
        return $product_entry;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id'    => 'required',
            'supplier_id'   => 'required',
            'amount'        => 'required',
            'date'          => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $product_entry = Product_Entry::findOrFail($id);
    
        // Restablecemos la cantidad del producto original antes de actualizar
        $original_product = Product::findOrFail($product_entry->product_id);
        $original_product->stock -= $product_entry->amount;
        $original_product->save();
    
        // Actualizamos la entrada del producto con los nuevos datos
        $product_entry->update($request->all());
    
        // Actualizamos la cantidad del nuevo producto
        $product = Product::findOrFail($request->product_id);
        $product->stock += $request->amount;
        $product->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Compra actualizada'
        ]);
    }

    public function destroy($id)
    {
        Product_Entry::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Compra eliminada'
        ]);
    }

    public function apiEntryProduct(){
        $product = Product_Entry::all();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->name;
            })
            ->addColumn('supplier_name', function ($product){
                return $product->supplier->company_name;
            })
            ->addColumn('action', function($product){
                return '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Editar</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a> ';
            })
            ->rawColumns(['products_name','supplier_name','action'])->make(true);
    }

    public function exportProductEntryPdf()
    {
        $product_entry = Product_Entry::all();
        $pdf = PDF::loadView('product_entry.productEntryAllPDF',compact('product_entry'));
        return $pdf->download('Compra_realizada.pdf');
    }

    public function exportProductEntryExcel()
    {
        return (new ExportProductEntry)->download('Compra_realizada.xlsx');
    }

    //Compras realizadas
    public function exportProductEntry($id)
    {
        $product_entry = Product_Entry::findOrFail($id);
        $pdf = PDF::loadView('product_entry.productEntryPDF', compact('product_entry'));
        return $pdf->download('Factura_N°'.$product_entry->id.'.pdf');
    }

    
}
