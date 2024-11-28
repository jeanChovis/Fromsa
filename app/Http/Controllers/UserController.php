<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function index(Request $request): View
    {
        return view('user.index', [
            'user' => $request->user(),
        ]);
    }

	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|unique:users',
		]);

		User::create($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Usuario creado',
		]);

	}

	public function edit($id) {
		$users = User::find($id);
		return $users;
	}

	public function destroy($id) {
		User::destroy($id);

		return response()->json([
			'success' => true,
			'message' => 'Usuario eliminado',
		]);
	}

	public function update(Request $request, $id) {
        
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|min:2',
			'email' => 'required|string|email|max:255|unique:users' . $id,
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		}
		
		$user = User::findOrFail($id);
		
		$user->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Usuario actulizado',
			'data' => $user,
		]);
    }

    public function apiUsers() {
		$users = User::all();

		return Datatables::of($users)
			->addColumn('action', function ($users) {
				return '<a onclick="editForm(' . $users->id . ')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Editar</a> ' .
				'<a onclick="deleteData(' . $users->id . ')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
			})
			->rawColumns(['action'])->make(true);
	}
}
