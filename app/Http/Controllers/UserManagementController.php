<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:5', 'max:15', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['nullable', 'string', 'lowercase', 'max:100','email','unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email ? $request->email : null, // Set email to null if not provided
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role); // Assign the role from the request

        event(new Registered($user));

        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'username' => 'required|string|min:5|max:15|unique:users,username,'.$user->id.'|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'nullable|string|email:rfc,dns|max:100|unique:users,email,'.$user->id,
            'role' => 'required|exists:roles,name',
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'is_active' => $validated['is_active'],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
{
    DB::beginTransaction();
    try {
        // Deactivate user instead of deleting
        $user->update([
            'is_active' => true,
        ]);
        
        DB::commit();
        return redirect()->route('users.index')
            ->with('success', 'Akun pengguna berhasil diaktfikan');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('users.index')
            ->with('error', 'Gagal mengaktifkan pengguna');
    }
}


}
