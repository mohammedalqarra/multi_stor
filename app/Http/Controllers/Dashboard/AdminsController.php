<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Admin::class , 'admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $admins = Admin::paginate();
        return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.create', [
            'role' => Role::all(),
            'admin' => new Admin(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);

        $admin = Admin::create($request->all());
        $admin->role()->attach($request->roles);


        return redirect()
            ->route('admin.index')
            ->with('success', 'Admin created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
        $role  = Role::all();
        $admin_roles = $admin->roles()->pluck('id')->toArray();

        return view('admin.edit', compact('admin', 'roles', 'admin_roles'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);

        $admin->update($request->all());
        $admin->role()->sync($request->roles);


        return redirect()
        ->route('admin.index')
        ->with('success', 'Admin update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Admin::destroy($id);

        return redirect()
        ->route('admin.index')->with('success' , 'Admin deleted successfully');
    }
}
