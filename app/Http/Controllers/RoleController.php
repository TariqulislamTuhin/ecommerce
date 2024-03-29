<?php

namespace App\Http\Controllers;

use App\Enum\Role as EnumRole;
use App\Mail\AddNewAdminMailNotification;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.role.create', [
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1'
        ], [
            'permissions.required' => 'Give at least one Permission'
        ]);
        $role = Role::create(['name' => $request->name]);
        $role->syncpermissions($request->permissions);
        return redirect()->route('role.create')->with('success', 'Role Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('backend.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('backend.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'required|array|min:1'
        ], [
            'permissions.required' => 'Give at least one Permission'
        ]);
        $role->syncPermissions($request->permissions);
        return back()->with('success', 'Edited Permissions Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function revoke(Role $role, User $user)
    {
        if ($role->name != EnumRole::SUPER_ADMIN->value) {
            $user->removeRole($role);
            return back()->with('success', $role->name . ' Role remove from ' . $user->name);
        }
        return back()->with('error', 'Nice try! ' . $role->name . ' Can not be Removed ');
    }

    public function assignUser()
    {

        return view('backend.role.user_role', [
            "roles" => Role::all(),
            "users" => User::where('registration_method', 'local')->get(),
            "userwithRole" => User::role([EnumRole::SUPER_ADMIN->value, EnumRole::ADMIN->value])->get(),
        ]);
    }
    public function assignUserStore(Request $request)
    {
        $request->validate([
            "user" => "required",
            "role" => "required"
        ]);

        $user = User::findorfail($request->user);
        $user->assignRole(Role::findById($request->role));
        return back()->with('success', 'Role Added Successfully');
    }

    public function createAdmin()
    {
        return view('backend.role.add_new_admin', [
            "roles" => Role::all(),
        ]);
    }
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            "role" => "required",
        ]);
        $password = Str::random(8);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);
        $user->assignRole($request->role);
        event(new Registered($user));
        Mail::to($request->email)->send(new AddNewAdminMailNotification($password));
        return back();
    }
}
