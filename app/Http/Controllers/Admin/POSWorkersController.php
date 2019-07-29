<?php

namespace App\Http\Controllers\Admin;

use App\Models\POSWorker;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\POSWorker\CreateRequest;

class POSWorkersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:view pos_workers')->only(['index', 'show']);
        $this->middleware('permission:create pos_workers')->only(['create', 'store']);
        $this->middleware('permission:update pos_workers')->only(['edit', 'update', 'editPassword', 'updatePassword', 'active']);
        $this->middleware('permission:delete pos_workers')->only(['destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = POSWorker::all();
        return view('admin.pos.workers.index', compact('workers'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = warehouse::all();
        return view('admin.pos.workers.create', compact('warehouses'));
    }
    
    /**
     * Store worker personal info.
     *
     * @param  \App\Models\POSWorker  $worker
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storePersonalInfo(Request $request, POSWorker $worker)
    {
        $worker->personalInfo()->create([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);
    }
    
    /**
     * Store worker address.
     *
     * @param  \App\Models\POSWorker  $worker
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storeAddress(Request $request, POSWorker $worker)
    {
        $worker->address()->create(
            $request->all()
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\Admin\POSWorker\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $worker = POSWorker::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'warehouse_id' => $request->warehouse,
            'password' => Hash::make($request->password),
        ]);
        if ($request->has('image')) {
            $worker
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('pos_worker.avatar');
        }
        $this->storePersonalInfo($request, $worker);
        $this->storeAddress($request, $worker);
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    public function show(POSWorker $worker)
    {
        return view('admin.pos.workers.show', compact('worker'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    public function edit(POSWorker $worker)
    {
        $warehouses = warehouse::all();
        return view('admin.pos.workers.edit', compact('worker', 'warehouses'));
    }

    /**
     * update admin personal info.
     *
     * @param  \App\Models\POSWorker  $worker
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updatePersonalInfo(Request $request, POSWorker $worker)
    {
        $worker->personalInfo()->update([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);
    }
    
    /**
     * update admin address.
     *
     * @param  \App\Models\POSWorker  $worker
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updateAddress(Request $request, POSWorker $worker)
    {
        $worker->address()->updateOrCreate(
            ['worker_id' => $worker->id],
            $request->all()
        );
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, POSWorker $worker)
    {
        $this->validateUpdateRequest($request, $worker);
        $worker->first_name = $request->first_name;
        $worker->last_name = $request->last_name;
        $worker->email = $request->email;
        $worker->warehouse_id = $request->warehouse;
        $worker->save();
        if ($request->has('image')) {
            $worker
            ->addMediaFromUrl($request->image)
            ->toMediaCollection('pos_worker.avatar');
        }
        $this->updatePersonalInfo($request, $worker);
        $this->updateAddress($request, $worker);
        return redirect()->route('pos.workers.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Valudate Update Registe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    protected function validateUpdateRequest(Request $request, POSWorker $worker)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                        Rule::unique('p_o_s_workers')->ignore($worker->id)
                        ],
            'image' => ['sometimes', 'image'],
            'warehouse' => ['required', 'exists:warehouses,id'],
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
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    public function editPassword(POSWorker $worker)
    {
        return view('admin.pos.workers.editpassword', compact('worker'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, POSWorker $worker)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $worker->password = Hash::make($request->password);
        $worker->save();
        return redirect()->route('pos.workers.index')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, POSWorker $worker)
    {
        $worker->active = !($worker->active);
        $worker->save();
        return redirect()->route('pos.workers.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\POSWorker  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->workers) {
            return back();
        }
        $this->validate($request, [
            'pos.workers.*' => 'required|exists:workers,id',
        ]);
        POSWorker::destroy($request->workers);
        return back()->with('status', trans('Deleted Successfully'));
    }
}
