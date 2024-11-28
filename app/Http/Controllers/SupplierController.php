<?php

namespace App\Http\Controllers;

use App\Exports\ExportSuppliers;
use App\Imports\SuppliersImport;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller {
	
	public function index() {
		$suppliers = Supplier::all();
		return view('supplier.index');
	}

	public function create() {
	}

	public function show($id) {
		//
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'ruc' => 'required|string|min:11',
			'company_name' => 'required|string',
			'address' => 'required|string',
			'email' => 'required|string|email|max:255|unique:supplier',
			'phone' => 'required|string|min:9',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		Supplier::create($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Proveedor creado'
		]);
	}


	public function edit($id) {
		$supplier = Supplier::find($id);
		return $supplier;
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'ruc' => 'required|string|min:11',
			'company_name' => 'required|string',
			'address' => 'required|string',
			'email' => 'required|string|email|max:255|unique:supplier,email,' . $id,
			'phone' => 'required|string|min:9',
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$supplier = Supplier::findOrFail($id);
		$supplier->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Proveedor actualizado'
		]);
	}

	public function destroy($id)
    {
        try {
            Supplier::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proveedor: ' . $e->getMessage()
            ], 500);
        }
    }

	public function apiSupplier() {
		$supplier = Supplier::all();

		return Datatables::of($supplier)
			->addColumn('action', function ($supplier) {
				return '<a onclick="editForm(' . $supplier->id . ')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Editar</a> ' .
				'<a onclick="deleteData(' . $supplier->id . ')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
			})
			->rawColumns(['action'])->make(true);
	}

	public function importSupplier(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'file' => 'required|mimes:xls,xlsx',
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		if ($request->hasFile('file')) {
			$file = $request->file('file');
			Excel::import(new SuppliersImport, $file);

			return redirect()->back()->with(['success' => 'Cargar proveedores de datos de archivos!']);
		}

		return redirect()->back()->with(['error' => 'Por favor elija el archivo antes!']);
	}


	public function exportPdf() {
		$supplier = Supplier::all();
		$pdf = PDF::loadView('supplier.SuppliersAllPDF', compact('supplier'));
		return $pdf->download('Proveedor.pdf');
	}

	public function exportExcel() {
		return (new ExportSuppliers)->download('Proveedor.xlsx');
	}
}
