<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $products = Product::all();
        return view('product.index', compact('category'));
    }

    public function store(Request $request)
    {
        // Obtener las categorías ordenadas
        $category = Category::orderBy('name', 'ASC')->pluck('name', 'id');

        // Validar la solicitud
        $validated = $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'required|image', // Validación de imagen
            'category_id' => 'required|exists:category,id', // Asegúrate de que la categoría exista
        ]);

        // Inicializar la imagen
        $validated['image'] = null;

        // Manejar la carga de la imagen
        if ($request->hasFile('image')) {
            $slug = Str::slug($validated['name'], '-'); // Generar el slug con el nombre
            $imageName = $slug . '.' . $request->image->getClientOriginalExtension();
            $path = $request->image->move(public_path('/upload/products/'), $imageName);
            $validated['image'] = '/upload/products/' . $imageName; // Guardar la ruta de la imagen
        }

        // Crear el producto con los datos validados
        Product::create($validated);

        // Respuesta en formato JSON
        return response()->json([
            'success' => true
            //'message' => 'Producto creado'
        ]);
    }

    public function edit($id)
    {
        $category = Category::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');
        $product = Product::find($id);
        return $product;
    }

    public function update(Request $request, $id)
    {
        // Obtener las categorías ordenadas
        $category = Category::orderBy('name', 'ASC')->pluck('name', 'id');

        // Validar la solicitud
        $validated = $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            //'image'       => 'required|image',
            'category_id' => 'required|exists:category,id', // Asegúrate de que la categoría exista
        ]);

        // Obtener el producto existente
        $produk = Product::findOrFail($id);

        // Inicializar la imagen
        $input = $request->all();
        $input['image'] = $produk->image; // Usar la imagen existente por defecto

        // Manejar la carga de la nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($produk->image) {
                unlink(public_path($produk->image));
            }

            // Generar el nuevo slug para la imagen
            $slug = Str::slug($validated['name'], '-');
            $imageName = $slug . '.' . $request->image->getClientOriginalExtension();
            $input['image'] = '/upload/products/' . $imageName; // Guardar la ruta de la nueva imagen
            $request->image->move(public_path('/upload/products/'), $input['image']); // Mover la nueva imagen
        } else {
            // Si no se subió una nueva imagen, conserva la anterior
            $input['image'] = $produk->image;
        }

        // Actualizar el producto con los datos validados
        $produk->update($input);

        // Respuesta en formato JSON
        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado'
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!$product->image == NULL){
            unlink(public_path($product->image));
        }

        Product::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado'
        ]);
    }

    public function apiProduct(){
        $product = Product::all();

        return Datatables::of($product)
            ->addColumn('category_name', function ($product){
                return $product->category->name;
            })
            ->addColumn('show_photo', function($product){
                if ($product->image == NULL){
                    return 'No Imagen';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($product->image) .'" alt="">
                ';
            })
            ->addColumn('action', function($product){
                return'<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Editar</a> ' .
                    '<a onclick="deleteData('. $product->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
            })
            ->rawColumns(['category_name','show_photo','action'])->make(true);

    }
}
