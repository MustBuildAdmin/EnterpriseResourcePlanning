<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
class RoleController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage role')) {
            $roles = Role::where('created_by', '=', \Auth::user()->creatorId())->where('created_by', '=', \Auth::user()->creatorId())->get();

            $roles_count = Role::where('created_by', '=', \Auth::user()->creatorId())->where('created_by', '=', \Auth::user()->creatorId())->get()->count();

            // return view('role.index')->with('roles', $roles);

            Cache::put('roles', $roles, 600);

            return view('roles.index')->with('roles', $roles)->with('roles_count', $roles_count);
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function create()
    {
        if (\Auth::user()->can('create role')) {
            $user = \Auth::user();
            if ($user->type == 'super admin') {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
            } else {
                $permissions = new Collection();
                foreach ($user->roles as $role) {
                    $permissions = $permissions->merge($role->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();
            }

            // return view('role.create', ['permissions' => $permissions]);
            return view('roles.create', ['permissions' => $permissions]);
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create role')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:100|unique:roles,name,NULL,id,created_by,'.\Auth::user()->creatorId(),
                    'permissions' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $name = $request['name'];
            $role = new Role();
            $role->name = $name;
            $role->created_by = \Auth::user()->creatorId();
            $permissions = $request['permissions'];
            $role->save();

            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            // return redirect()->route('roles.index')->with(
            //     'Role successfully created.', 'Role ' . $role->name . ' added!'
            // );
            return redirect()->route('roles.index')->with(
                'success', 'Role '.$role->name.' added!'
            );
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function edit(Role $role)
    {
        if (\Auth::user()->can('edit role')) {

            $user = \Auth::user();
            if ($user->type == 'super admin') {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
                // Cache::put('permissions', $permissions, 200);
            } else {
                $permissions = new Collection();
                foreach ($user->roles as $role1) {
                    $permissions = $permissions->merge($role1->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();
                // Cache::put('permissions', $permissions, 200);
            }

            // return view('role.edit', compact('role', 'permissions'));
            return view('roles.edit', compact('role', 'permissions'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function update(Request $request, Role $role)
    {
        if (\Auth::user()->can('edit role')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:100|unique:roles,name,'.$role['id'].',id,created_by,'.\Auth::user()->creatorId(),
                    'permissions' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $input = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach ($p_all as $p) {
                $role->revokePermissionTo($p);
            }

            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->route('roles.index')->with(
                'success', 'Role '.$role->name.' updated!'
            );
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function destroy(Role $role)
    {
        if (\Auth::user()->can('delete role')) {
            $role->delete();

            return redirect()->route('roles.index')->with(
                'success', 'Role successfully deleted.'
            );
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function delete_multi_role(Role $role, Request $request)
    {

        if (\Auth::user()->can('delete role')) {

            $ids = $request->ids;

            $role->whereIn('id', explode(',', $ids))->delete();

            return response()->json(['status' => true, 'message' => 'Role successfully deleted']);

        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function check_role_name(Request $request){
        $form_name = $request->form_name;
        $name = $request->name;
        if($request->id==null){
            if($form_name == "rolecreate"){
                $getCheckVal = DB::table('roles')
                    ->where('name',$request->name)
                    ->where('guard_name','web')->first();
            }
            else {
                $getCheckVal = "Not Empty";
            }
        }else{
            $getCheckVal = DB::table('roles')
            ->where('name',$request->name)
            ->whereNot('id', $request->id)
            ->where('guard_name','web')->first();
        }
        

        if ($getCheckVal == null) {
            echo "true";
            // return 1; //Success
        } else {
            echo "false";
            // return 0; //Error
        }
    }
}
