<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('users.view');

        $users = User::paginate();

        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('admin.create', [
            'roles' => Role::all(),
            'user'  => new User(),
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

        $user = User::create($request->all());
        $user->roles()->attach($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully');
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
    public function edit(User $user)
    {
        //
        $roles = Role::all();
        $user_roles = $user->roles()->pluck('id')->toArray();

        return view('users.edit', compact('user', 'roles', 'user_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);

        $user->update($request->all());
        $user->roles()->attach($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updatep successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        User::destroy($id);

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
