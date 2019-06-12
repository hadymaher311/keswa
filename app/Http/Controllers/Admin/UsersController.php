<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('admin.users.create');
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
        ]);
        if ($request->has('image')) {
            $user
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('user.avatar');
        }
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
        return view('admin.users.show', compact('admin'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('admin', 'roles'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Admin $user)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();
        $user->assignRole($request->role);
        if ($request->has('image')) {
            $user
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('user.avatar');
        }
        return redirect()->route('users.index')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Show the form for editing admin password.
     *
     * @param  Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function editPassword(Admin $user)
    {
        return view('admin.users.editpassword', compact('admin'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, Admin $user)
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
     * @param  Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, Admin $user)
    {
        $user->active = !($user->active);
        $user->save();
        return redirect()->route('users.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin  $user
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
