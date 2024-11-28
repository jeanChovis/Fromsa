<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Exports\ExportCategories;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{   

    public function index(Request $request): View
    {
        return view('category.index', [
            'user' => $request->user(),
        ]);
    } 

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Category::create($request->all());

        return response()->json([
            'success' => true
            //'message' => 'Categoria creada'
        ]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }


    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response()->json(['success' => 'Categoria actualizada']);
    }


    public function destroy($id)
    {
        try {
            Category::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Categoria eliminada'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la categoria: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function apiCategory()
    {
        $categories = Category::all();

        return Datatables::of($categories)
            ->addColumn('action', function($categories){
                return '<a onclick="editForm('. $categories->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Editar</a> ' .
                    '<a onclick="deleteData('. $categories->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
            })
            ->rawColumns(['action'])->make(true);
    }

    public function exportPdf()
    {
        $category = Category::all();
        $pdf = PDF::loadView('category.CategoryAllPDF',compact('category'));
        return $pdf->download('Categoria.pdf');
    }

    public function exportExcel()
    {
        return (new ExportCategories())->download('Categoria.xlsx');
    }
}
