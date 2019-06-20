<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:view roles')->only(['index', 'show']);
        $this->middleware('permission:create roles')->only(['create', 'store']);
        $this->middleware('permission:update roles')->only(['edit', 'update']);
        $this->middleware('permission:delete roles')->only(['destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
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
            'name' => 'required|string|min:2|unique:roles',
            'permissions.*' => 'sometimes|exists:permissions,id',
        ]);
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if ($role->name == 'super' && $role->guard_name = 'admin') {
            return back();
        }
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2',
            'permissions.*' => 'sometimes|exists:permissions,id',
        ]);
        if ($role->name == 'super' && $role->guard_name = 'admin') {
            return back();
        }
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->roles) {
            return back();
        }
        $this->validate($request, [
            'roles.*' => 'required|exists:roles,id',
        ]);
        $roles = Role::find($request->roles);
        foreach ($roles as $role) {
            if ($role->name == 'super' && $role->guard_name = 'admin') {
                return back();
            }
        }
        Role::destroy($request->roles);
        return back()->with('status', trans('Deleted Successfully'));
    }
}
