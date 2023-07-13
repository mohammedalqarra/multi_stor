<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RoleAbility;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::paginate();

        return view('admin.roles.index'  , compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('admin.roles.create' , [
            'role' => new Role(),
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
            'abilities' => 'required|array'
        ]);

        $role = Role::createWithAbilities($request);

        // $role = Role::create([
        //     'name' => $request->post('name'),
        // ]);
        // //store ability
        // foreach($request->post('abilities') as $ability)
        // {
        //     RoleAbility::create([
        //         'role_id' => $role->id,
        //         'ability_id' => $ability,
        //         'type' => 'allow',
        //     ]);
        // }

        return redirect()->route('admin.roles.index')->with('success' , 'Role created successfully');
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
    public function edit(Role  $role)
    {
        //
        $role_abilities  = $role->abilities()->pluck('type' , 'ability')->toArray();

        return view('admin.roles.edit', compact('role' , 'role_abilities'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array'
        ]);

        $role->updateWithAbilities($request);

        return redirect()->route('admin.roles.index')->with('success' , 'Role created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        Role::destroy($id);
        return redirect()->route('admin.roles.index')->with('success' , 'Role deleted successfully');
    }
}
