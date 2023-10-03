<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\categoryRequest;
use App\Repositories\Category\CategoryInterface;

use App\Models\User;
use App\Models\Category;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;
use App\Notifications\CategoryAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class CategoryController extends Controller
{
    use ImageTrait;
    // protected $category;

    // public function __construct(CategoryInterface $category)
    // {
    //     $this->category = $category;
    // }



    public function index(Request $request)
    {
        // $data    = $this->category->index($request);
        $data = Category::
        when($request->name != null,function ($q) use($request){
            return $q->where('name','like','%'.$request->name.'%');
        })
        ->when($request->from_date != null,function ($q) use($request){
            return $q->whereDate('created_at','>',$request->from_date);
        })
        ->when($request->to_date != null,function ($q) use($request){
            return $q->whereDate('created_at','<',$request->to_date);
        })
        ->paginate(10);
        $trashed = false;
        return view('dashboard.category.index')
        ->with([
            'data'      => $data,
            'trashed'   => $trashed,
            'name'      => $request->name,
            'from_date' => $request->from_date,
            'to_date'   => $request->to_date,
        ]);
    }



    public function fetch()
    {
        $data = Category::all();
        return response()->json([
            'data' => $data,
        ]);
    }



    public function store(Request $request)
    {
        // return $this->category->store($request);
        try {
            $validator = Validator::make($request->all(),[
                'name'  => 'required|max:191|unique:categories,name',
                'photo' => 'nullable|file|mimes:png,jpg,jpeg',
            ]);
            if($validator->fails())
            {
                return response()->json([
                    'status'   => false,
                    'messages' => $validator->messages(),
                ]);
            }
            //upload image
            if ($request->photo) {
                $photo_name = $this->uploadImage($request->photo, 'attachments/category');
            }
            //insert data
            $category = Category::create([
                'name'  => $request->name,
                'photo' => $request->photo ? $photo_name : null,
            ]);
            if (!$category) {
                session()->flash('error');
                // return redirect()->back();
                return response()->json([
                    'status'   => false,
                    'messages' => 'لقد حدث خطأ ما برجاء المحاولة مجدداً',
                ]);
            }
            //send notification
            $users = User::where('id', '!=', Auth::user()->id)->select('id','name')->get();
            Notification::send($users, new CategoryAdded($category->id));

            session()->flash('success');
            // return redirect()->back();
            return response()->json([
                'status'   => true,
                'messages' => 'تم الحفظ بنجاح',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function edit($id)
    {
        try {
            $data = Category::find($id);
            if(!$data)
            {
                return response()->json([
                    'status'   => false,
                    'messages' => 'لقد حدث خطأ ما برجاء المحاولة مجدداً',
                ]);
            }
            return response()->json([
                'status' => true,
                'data'   => $data,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function update(Request $request)
    {
        // return $this->category->update($request);
        try {
            $validator = Validator::make($request->all(),[
                'name'  => 'required|max:191|unique:categories,name,$request->id',
                'photo' => 'nullable'.($request->hasFile('photo')?'|file|mimes:jpeg,jpg,png':''),
            ]);
            if($validator->fails())
            {
                return response()->json([
                    'status'   => false,
                    'messages' => $validator->messages(),
                ]);
            }
            $category  = Category::findOrFail($request->id);
            if (!$category) {
                session()->flash('error');
                // return redirect()->back();
                return response()->json([
                    'status'   => false,
                    'messages' => 'لقد حدث خطأ ما برجاء المحاولة مجدداً',
                ]);
            }
            //upload image
            if ($request->photo) {
                //remove old photo
                Storage::disk('attachments')->delete('category/' . $category->photo);
                $photo_name = $this->uploadImage($request->photo, 'attachments/category');
            }
            $category->update([
                'name'  => $request->name,
                'photo' => $request->photo ? $photo_name : $category->photo,
            ]);
            session()->flash('success');
            // return redirect()->back();
            return response()->json([
                'status'   => true,
                'messages' => 'تم الحفظ بنجاح',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroy(Request $request)
    {
        // return $this->category->destroy($request);
        try {
            // $related_table = realed_model::where('category_id', $request->id)->pluck('category_id');
            // if($related_table->count() == 0) { 
                $category = Category::findOrFail($request->id);
                if (!$category) {
                    session()->flash('error');
                    // return redirect()->back();
                    return response()->json([
                        'status'   => false,
                        'messages' => 'لقد حدث خطأ ما برجاء المحاولة مجدداً',
                    ]);
                }
                Storage::disk('attachments')->delete('category/' . $category->photo);
                $category->delete();
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



    public function deleteSelected(Request $request)
    {
        // return $this->category->deleteSelected($request);
        try {
            $delete_selected_id = explode(",", $request->delete_selected_id);
            // foreach($delete_selected_id as $selected_id) {
            //     $related_table = realed_model::where('category_id', $selected_id)->pluck('category_id');
            //     if($related_table->count() == 0) {
                    $categories = Category::whereIn('id', $delete_selected_id)->delete();
                    if(!$categories) {
                        session()->flash('error');
                        return redirect()->back();
                    }
                    session()->flash('success');
                    return redirect()->back();
            //     } else {
            //         session()->flash('canNotDeleted');
            //         return redirect()->back();
            //     }
            // }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function showNotification($route_id,$notification_id)
    {
        // $data = $this->category->showNotification($route_id,$notification_id);
        // return view('dashboard.category.index', compact('data'));
        $notification = NotificationModel::findOrFail($notification_id);
        $notification->update([
            'read_at' => now(),
        ]);
        
        $data = Category::paginate(10);
        $trashed = false;
        return view('dashboard.category.index', compact('data', 'trashed'));
    }
}
