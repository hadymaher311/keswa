<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Admins\CreateRequest;

class AdminsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();
        return view('admin.admins.index', compact('admins'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.create', compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $admin = admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $admin->syncRoles($request->role);
        if ($request->has('image')) {
            $admin
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('admin.avatar');
        }
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $this->validateUpdateRequest($request, $admin);
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->save();
        $admin->syncRoles($request->role);
        if ($request->has('image')) {
            $admin
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('admin.avatar');
        }
        return redirect()->route('admins.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Valudate Update Registe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    protected function validateUpdateRequest(Request $request, Admin $admin)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                        Rule::unique('admins')->ignore($admin->id)
                        ],
            'role' => ['required', 'exists:roles,id'],
            'image' => ['sometimes', 'image']
        ]);
    }
    
    /**
     * Show the form for editing admin password.
     *
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function editPassword(Admin $admin)
    {
        return view('admin.admins.editpassword', compact('admin'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, Admin $admin)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $admin->password = Hash::make($request->password);
        $admin->save();
        return redirect()->route('admins.index')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, Admin $admin)
    {
        $admin->active = !($admin->active);
        $admin->save();
        return redirect()->route('admins.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->admins) {
            return back();
        }
        $this->validate($request, [
            'admins.*' => 'required|exists:admins,id',
        ]);
        Admin::destroy($request->admins);
        return back()->with('status', trans('Deleted Successfully'));
    }
}
