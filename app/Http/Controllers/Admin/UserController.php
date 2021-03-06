<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Ramsey\Uuid\Uuid;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public $pagination = 20;
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = User::orderBy('name', 'ASC')->paginate($this->pagination);
        return view('admin.usuarios.index', compact('info'));
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();

        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|min:3|max:250',
            'password'  => 'required|string|min:6|max:10',
            'cellphone' => 'required|min:10',
            'telephone' => 'required|min:10',
            'email'     => 'required|email|unique:users,email',
            'roles'     => 'required'
        ]);

        $input = $request->all();
        //dd($input);
        $input['uuid'] = Uuid::uuid4();
        $input['type'] = $input['roles'];
        $input['password'] = FacadesHash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // cadastrar
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        $roles = Role::pluck('name', 'id')->all();
        $userRole = $user->roles->pluck('id')->all();

        return view('admin.usuarios.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id, $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required|min:3|max:250',
            'cellphone' => 'required|min:10',
            'telephone' => 'required|min:10',
            'email'     => 'required|email',
            'roles'     => 'required'
        ]);

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = FacadesHash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }       

        $user = User::find($id);
        $user->update($input);
        FacadesDB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.usuarios.index')
                        ->with('success', 'Registro atualizado com Sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
