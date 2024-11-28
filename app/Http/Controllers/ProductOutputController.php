<?php

namespace App\Http\Controllers;

use App\Exports\ExportProductOutput;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Product_Entry;
use App\Models\Product_Output;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;


class ProductOutputController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $customers = Customer::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $invoice_data = Product_Output::all();
        return view('product_output.index', compact('products','customers', 'invoice_data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'product_id'     => 'required',
           'customer_id'    => 'required',
           'date'            => 'required',
           'total'           => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Product_Output::create($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->stock -= $request->total;
        $product->save();

        return response()->json([
            'success'    => true,
            'message'    => 'Venta creada'
        ]);
    }

    public function edit($id)
    {
        $product_output = Product_Output::find($id);
        return $product_output;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id'     => 'required',
            'customer_id'    => 'required',
            'total'            => 'required',
            'date'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product_output = Product_Output::findOrFail($id);
        $product_output->update($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->stock -= $request->total;
        $product->update();

        return response()->json([
            'success'    => true,
            'message'    => 'Venta actualizada'
        ]);
    }

    public function destroy($id)
    {
        Product_Output::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Venta eliminado'
        ]);
    }

    public function apiProductsOutput(){
        $product = Product_Output::all();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->name;
            })
            ->addColumn('customer_name', function ($product){
                return $product->customer->name;
            })
            ->addColumn('action', function($product){
                return'<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Editar</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
            })
            ->rawColumns(['products_name','customer_name','action'])->make(true);
    }

    public function exportProductOutputPdf()
    {
        $product_output = Product_Output::all();
        $pdf = PDF::loadView('product_output.productKeluarAllPDF',compact('product_output'));
        return $pdf->download('Ventas.pdf');
    }

    public function exportProductOutput($id)
    {
        $product_output = Product_Output::findOrFail($id);
        $pdf = PDF::loadView('product_output.productKeluarPDF', compact('product_output'));
        return $pdf->download('Venta_N°'.$product_output->id.'.pdf');
    }

    public function exportProductOutputExcel()
    {
        return (new ExportProductOutput)->download('Ventas.xlsx');
    }
}
