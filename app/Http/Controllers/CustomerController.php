<?php

namespace App\Http\Controllers;


use App\Models\CustomerPerson;
use App\Models\CustomerCompany;
use App\Models\Customer;
use App\Exports\ExportCustomers;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{    
    
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'client_type' => 'required|in:Persona,Empresa',
        ];
    
        if ($request->input('client_type') === 'Persona') {
            $rules = array_merge($rules, [
                'name_person' => 'required|string',
                'address_person' => 'required|string|max:255',
                'email_person' => 'required|email|unique:customer,email',
                'phone_person' => 'required|string|max:9',
            ]);
        } else {
            $rules = array_merge($rules, [
                'name_company' => 'required|string|max:255',
                'address_company' => 'required|string|max:255',
                'email_company' => 'required|email|unique:customer,email',
                'phone_company' => 'required|string|max:9',
            ]);
        }
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $customerData = [
            'name' => $request->input('client_type') === 'Persona' ? $request->input('name_person') : $request->input('name_company'),
            'address' => $request->input('client_type') === 'Persona' ? $request->input('address_person') : $request->input('address_company'),
            'email' => $request->input('client_type') === 'Persona' ? $request->input('email_person') : $request->input('email_company'),
            'phone' => $request->input('client_type') === 'Persona' ? $request->input('phone_person') : $request->input('phone_company'),
            'client_type' => $request->input('client_type'),
        ];

        // Crear el registro de Customer
        $customer = Customer::create($customerData);

        // Si es una Persona
        if ($request->input('client_type') === 'Persona') {
            $request->validate([
                'dni' => 'required|unique:customer_person,dni',
            ]);

            CustomerPerson::create([
                'dni' => $request->input('dni'),
                'date_birth' => $request->input('birth_date'),
                'gender' => $request->input('gender_person'),
                'customer_id' => $customer->id,
            ]);
        }

        // Si es una Empresa
        if ($request->input('client_type') === 'Empresa') {
            $request->validate([
                'ruc' => 'required|unique:customer_company,ruc',
            ]);

            CustomerCompany::create([
                'ruc' => $request->input('ruc'),
                'customer_id' => $customer->id,
            ]);
        }

        return response()->json(['message' => 'Cliente creado exitosamente'], 201);
    }
 
    public function edit($id)
    {
        $customers = Customer::find($id);
        return $customers;
    }

    public function update(Request $request, $id)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            // Validación para "Persona"
            'client_type' => 'required|string|in:Persona,Empresa',
            'name_person' => 'required_if:client_type,Persona|string|max:255',
            'address_person' => 'required_if:client_type,Persona|string|max:255',
            'email_person' => 'required_if:client_type,Persona|email|max:255|unique:customers,email,' . $id,
            'phone_person' => 'required_if:client_type,Persona|string|min:9',

            // Validación para "Empresa"
            'name_company' => 'required_if:client_type,Empresa|string|max:255',
            'address_company' => 'required_if:client_type,Empresa|string|max:255',
            'email_company' => 'required_if:client_type,Empresa|email|max:255|unique:customers,email,' . $id,
            'phone_company' => 'required_if:client_type,Empresa|string|min:9',
        ]);

        // Si la validación falla, retorna los errores
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Encontrar al cliente por su ID
        $customer = Customer::findOrFail($id);

        // Dependiendo del tipo de cliente, asignamos los valores correctos
        if ($request->input('client_type') === 'Persona') {
            $customer->name = $request->input('name_person');
            $customer->address = $request->input('address_person');
            $customer->email = $request->input('email_person');
            $customer->phone = $request->input('phone_person');
        } else {
            $customer->name = $request->input('name_company');
            $customer->address = $request->input('address_company');
            $customer->email = $request->input('email_company');
            $customer->phone = $request->input('phone_company');
        }

        // Actualizar el tipo de cliente
        $customer->client_type = $request->input('client_type');

        // Guardar los cambios en la base de datos
        $customer->save();

        // Responder con un mensaje de éxito
        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Cliente Delete'
        ]);
    }

    public function apiCustomer()
    {
        $customers = Customer::with('person', 'company')->get(); // Relacionando las personas y empresas

        return DataTables::of($customers)
            ->addColumn('client_type', function ($customer) {
                return $customer->client_type; // Devuelve 'Persona' o 'Empresa'
            })
            ->addColumn('contact', function ($customer) {
                return $customer->phone; // O cualquier otro dato que represente el contacto
            })
            ->addColumn('action', function($customer){
                return'<a onclick="editForm('. $customer->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Editar</a> ' .
                    '<a onclick="deleteData('. $customer->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
            })
            ->make(true);
    }

    public function exportCustomersAll()
    {
        $customers = Customer::all();
        $pdf = PDF::loadView('customer.CustomersAllPDF',compact('customer'));
        return $pdf->download('customer.pdf');
    }

    public function exportExcel()
    {
        return (new ExportCustomers)->download('customer.xlsx');
    }
}
