<?php

declare(strict_types=1);

namespace App\Modules\Membership\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('membership.users.index', [
            'users' => User::with('roles')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('membership.users.create', [
            'roles' => Role::pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (! empty($data['role'])) {
            $user->assignRole($data['role']);
        }

        return redirect()->route('membership.users.index')->with('status', 'user-created');
    }

    public function edit(User $user)
    {
        return view('membership.users.edit', [
            'editUser' => $user,
            'roles' => Role::pluck('name'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->is_active = $request->boolean('is_active');
        $user->save();

        $user->syncRoles($data['role'] ? [$data['role']] : []);

        return redirect()->route('membership.users.edit', $user)->with('status', 'user-updated');
    }

    public function updatePassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('membership.users.edit', $user)->with('status', 'password-updated');
    }

    public function resetMfa(User $user)
    {
        $user->mfa_enabled = false;
        $user->mfa_secret = null;
        $user->mfa_enabled_at = null;
        $user->save();

        return redirect()->route('membership.users.index')->with('status', 'mfa-reset');
    }
}
