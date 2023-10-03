<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use Hash;
use App\Models\User;
use App\Models\Notification as NotificationModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\UserAdded;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data  = User::orderBy('id','ASC')
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like','%'.$request->name.'%');
        })
        ->when($request->email != null,function ($q) use($request){
            return $q->where('email','like','%'.$request->email.'%');
        })
        ->when($request->mobile != null,function ($q) use($request){
            return $q->where('mobile','like','%'.$request->mobile.'%');
        })
        ->paginate(10);
        $roles = Role::pluck('name','name')->all();
        return view('dashboard.users.index')
        ->with([
            'data'   => $data,
            'roles'  => $roles,
            'name'   => $request->name,
            'email'  => $request->email,
            'mobile' => $request->mobile,
        ]);
    }
    


    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.users.show',compact('user'));
    }
    


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name'       => 'required',
                'email'      => 'required|email|unique:users,email',
                'mobile'     => 'required|unique:users,mobile',
                'password'   => 'required|same:confirm-password',
                'status'     => 'required',
                'roles_name' => 'required',
            ]);
            if($validator->fails())
            {
                session()->flash('error');
                return redirect()->back();
            }
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->assignRole($request->input('roles_name'));

            if (!$user) {
                session()->flash('error');
                return redirect()->back();
            }

            //send notification mail
            $users = User::where('id', '!=', Auth::user()->id)->get();
            // $id   = User::latest()->first()->id;
            Notification::send($users, new UserAdded($user->id));

            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    

        
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name'     => 'required',
                'email'    => 'required|email|unique:users,email,'.$request->id,
                'mobile'   => 'required|unique:users,mobile,'.$request->id,
                'password' => 'same:confirm-password',
                'roles'    => 'required'
            ]);
            if($validator->fails())
            {
                session()->flash('error');
                return redirect()->back();
            }
            $input = $request->all();
            // if(!empty($input['password'])) {
            //     $input['password'] = Hash::make($input['password']);
            // } else {
            //     $input = array_except($input,array('password'));
            // }
            $user = User::find($request->id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$request->id)->delete();
            $user->assignRole($request->input('roles'));
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    


    public function destroy(Request $request)
    {
        try {
            // $related_table = realed_model::where('user_id', $request->id)->pluck('user_id');
            // if($related_table->count() == 0) { 
                $user = User::findOrFail($request->id);
                if (!$user) {
                    session()->flash('error');
                    // return redirect()->back();
                    return response()->json([
                        'status'   => false,
                        'messages' => 'لقد حدث خطأ ما برجاء المحاولة مجدداً',
                    ]);
                }
                $user->delete();
                session()->flash('success');
                // return redirect()->back();
                return response()->json([
                    'status'   => true,
                    'messages' => 'تم الحذف بنجاح',
                ]);
            // } else {
                // session()->flash('canNotDeleted');
                // return redirect()->back();
            // }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function showNotification($id)
    {
        $notification = NotificationModel::findOrFail($id);
        $notification->update([
            'read_at' => now(),
        ]);
        $user = User::findOrFail($id);
        return view('dashboard.users.show',compact('user'));
    }
    


    public function changeStatus($id)
    {
        try {
            $user = User::find($id);
            if($user->status == 0)
            {
                $user->update(['status' => 1]);
            }
            else
            {
                $user->update(['status' => 0]);
            }
            if(!$user)
            {
                session()->flash('error');
                return redirect()->back();
            }
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}