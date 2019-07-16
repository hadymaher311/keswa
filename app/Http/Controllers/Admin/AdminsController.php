<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\warehouse;
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
        $this->middleware('permission:view admins')->only(['index', 'show']);
        $this->middleware('permission:create admins')->only(['create', 'store']);
        $this->middleware('permission:update admins')->only(['edit', 'update', 'editPassword', 'updatePassword', 'active']);
        $this->middleware('permission:delete admins')->only(['destroy']);
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
        $warehouses = warehouse::all();
        return view('admin.admins.create', compact('roles', 'warehouses'));
    }
    
    /**
     * Store admin personal info.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storePersonalInfo(Request $request, Admin $admin)
    {
        $admin->personalInfo()->create([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);
    }
    
    /**
     * Store admin address.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storeAddress(Request $request, Admin $admin)
    {
        $admin->address()->create(
            $request->all()
        );
    }
    
    /**
     * Store admin warehouses.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storeWarehouses(Request $request, Admin $admin)
    {
        $admin->warehouses()->sync(
            $request->warehouses
        );
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
        $this->storePersonalInfo($request, $admin);
        $this->storeAddress($request, $admin);
        $this->storeWarehouses($request, $admin);
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
        $warehouses = warehouse::all();
        return view('admin.admins.edit', compact('admin', 'roles', 'warehouses'));
    }

    /**
     * update admin personal info.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updatePersonalInfo(Request $request, Admin $admin)
    {
        $admin->personalInfo()->update([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);
    }
    
    /**
     * update admin address.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updateAddress(Request $request, Admin $admin)
    {
        $admin->address()->updateOrCreate(
            ['admin_id' => $admin->id],
            $request->all()
        );
    }
    
    /**
     * update admin warehouses.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updateWarehouses(Request $request, Admin $admin)
    {
        $admin->warehouses()->sync(
            $request->warehouses
        );
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
        $this->updatePersonalInfo($request, $admin);
        $this->updateAddress($request, $admin);
        $this->updateWarehouses($request, $admin);
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
            'image' => ['sometimes', 'image'],
            'warehouses' => ['required', 'array'],
            'warehouses.*' => ['required', 'exists:warehouses,id'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'max:11', 'min:11'],
            'gender' => ['required', 'string', 'in:male,female'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'building' => ['required', 'string', 'max:255'],
            'floor' => ['required', 'string', 'max:255'],
            'apartment' => ['required', 'string', 'max:255'],
            'nearest_landmark' => ['nullable', 'string', 'max:255'],
            'location_type' => ['required', 'string', 'in:home,business'],
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
