<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
        $this->middleware('permission:إضافة صلاحية', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    }
    


    public function index(Request $request)
    {
        $data = Role::orderBy('id','DESC')
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like','%'.$request->name.'%');
        })
        ->paginate(10);
        return view('dashboard.roles.index')
        ->with([
            'data'   => $data,
            'name'   => $request->name,
        ]);
    }
    


    public function create()
    {
        $permission = Permission::get();
        return view('dashboard.roles.create',compact('permission'));
    }
    


    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name'       => 'required|unique:roles,name',
                'permission' => 'required',
            ]);
            if ($validator->fails()) {
                session()->flash('error');
                return redirect()->back();
            }
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            session()->flash('success');
            return redirect()->route('role.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function show($id)
    {
        $role            = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$id)->get();
        return view('dashboard.roles.show',compact('role','rolePermissions'));
    }
    


    public function edit($id)
    {
        $role            = Role::find($id);
        $permission      = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        return view('dashboard.roles.edit',compact('role','permission','rolePermissions'));
    }
    


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'       => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('role.index')->with('success','Role updated successfully');
    }
    


    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('role.index')->with('success','Role deleted successfully');
    }



    public function delete(Request $request)
    {
        try {
            $role = DB::table("roles")->where('id',$request->id)->delete();
            if (!$role) {
                session()->flash('error');
                return redirect()->back();
            }
            
            session()->flash('success');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}