<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\WarehouseRelatedLocation;
use App\Http\Requests\Admin\Users\CreateRequest;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:view users')->only(['index', 'show']);
        $this->middleware('permission:create users')->only(['create', 'store']);
        $this->middleware('permission:update users')->only(['edit', 'update', 'editPassword', 'updatePassword', 'active']);
        $this->middleware('permission:delete users')->only(['destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = WarehouseRelatedLocation::whereHas('warehouse', function($warehouse){
            return $warehouse->active();
        })->get();
        return view('admin.users.create', compact('locations'));
    }
    
    /**
     * Store User personal info.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storePersonalInfo(Request $request, User $user)
    {
        $user->personalInfo()->create([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);
    }
    
    /**
     * Store User address.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storeAddress(Request $request, User $user)
    {
        $address = $user->addresses()->create(
            $request->all()
        );
        $user->main_location = $address->id;
        $user->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verified_at' => Carbon::now(),
            'added_by' => 'phone'
        ]);
        if ($request->has('image')) {
            $user
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('user.avatar');
        }
        $this->storePersonalInfo($request, $user);
        $this->storeAddress($request, $user);
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * update User personal info.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updatePersonalInfo(Request $request, User $user)
    {
        $user->personalInfo()->update([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->ValidateUpdateRequest($request, $user);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();
        if ($request->has('image')) {
            $user
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('user.avatar');
        }
        $this->updatePersonalInfo($request, $user);
        return redirect()->route('users.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Valudate Update Registe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $User
     * @return \Illuminate\Http\Response
     */
    protected function validateUpdateRequest(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 
                        Rule::unique('users')->ignore($user->id)
                        ],
            'image' => ['sometimes', 'image'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'max:11', 'min:11'],
            'gender' => ['required', 'string', 'in:male,female'],
        ]);
    }
    
    /**
     * Show the form for editing User password.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function editPassword(User $user)
    {
        return view('admin.users.editpassword', compact('user'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('users.index')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, User $user)
    {
        $user->active = !($user->active);
        $user->save();
        return redirect()->route('users.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->users) {
            return back();
        }
        $this->validate($request, [
            'users.*' => 'required|exists:users,id',
        ]);
        User::destroy($request->users);
        return back()->with('status', trans('Deleted Successfully'));
    }
}
