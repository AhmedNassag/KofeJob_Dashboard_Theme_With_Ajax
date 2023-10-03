<?php

namespace App\Repositories\Category;

use App\Models\User;
use App\Models\Category;
use App\Models\Notification as NotificationModel;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CategoryAdded;

class CategoryRepository implements CategoryInterface 
{
    use ImageTrait;

    public function index($request)
    {
        return Category::
        when($request->name_ar != null,function ($q) use($request){
            return $q->where('name','like','%'.$request->name.'%');
        })
        ->paginate(1);
    }



    public function store($request)
    {
        try {
            $validated = $request->validated();
            //upload image
            if ($request->photo) {
                $photo_name = $this->uploadImage($request->photo, 'attachments/category');
            }
            //insert data
            $category = Category::create([
                'name' => $request->name,
                'photo'   => $request->photo ? $photo_name : null,
            ]);
            if (!$category) {
                session()->flash('error');
                return redirect()->back();
            }
            //send notification
            $users = User::where('id', '!=', Auth::user()->id)->get();
            Notification::send($users, new CategoryAdded($category->id));

            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function update($request)
    {
        try {
            $validated = $request->validated();
            $category = Category::findOrFail($request->id);
            if (!$category) {
                session()->flash('error');
                return redirect()->back();
            }
            //upload image
            if ($request->photo) {
                //remove old photo
                Storage::disk('attachments')->delete('category/' . $category->photo);
                $photo_name = $this->uploadImage($request->photo, 'attachments/category');
            }
            $category->update([
                'name' => $request->name,
                'photo'   => $request->photo ? $photo_name : $category->photo,
            ]);
            if (!$category) {
                session()->flash('error');
                return redirect()->back();
            }
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroy($request)
    {
        try {
            // $related_table = realed_model::where('category_id', $request->id)->pluck('category_id');
            // if($related_table->count() == 0) { 
                $category = Category::findOrFail($request->id);
                if (!$category) {
                    session()->flash('error');
                    return redirect()->back();
                }
                Storage::disk('attachments')->delete('category/' . $category->photo);
                $category->delete();
                session()->flash('success');
                return redirect()->back();
            // } else {
                // session()->flash('canNotDeleted');
                // return redirect()->back();
            // }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function deleteSelected($request)
    {
        try {
            $delete_selected_id = explode(",", $request->delete_selected_id);
            // foreach($delete_selected_id as $selected_id) {
            //     $related_table = realed_model::where('category_id', $selected_id)->pluck('category_id');
            //     if($related_table->count() == 0) {
                    $categories = Category::whereIn('id', $delete_selected_id)->delete();
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



    public function showNotification($id,$notification_id)
    {
        $notification = NotificationModel::findOrFail($notification_id);
        $notification->update([
            'read_at' => now(),
        ]);
        return $this->index();
    }
}
