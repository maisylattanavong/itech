<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function Tag()
    {
        $tags = Tag::withoutTrashed()->get();
        $trashed = Tag::onlyTrashed()->count();
        $update = null;

        return view('admin.tag.tag_all', compact('tags', 'update', 'trashed'));
    }

    public function StoreTag(Request $request)
    {
        $request->validate([
            'en_tag' => 'required',
            'la_tag' => 'required',
        ]);

        $valid_en = TagTranslation::where('name', strip_tags($request->en_tag))->where('locale', 'en')->first();
        $valid_la = TagTranslation::where('name', strip_tags($request->la_tag))->where('locale', 'la')->first();
        if ($valid_en || $valid_la) {
            $notifiction = array(
                'message' => 'This Tag Already have! Please try again!!', 'alert-type' => 'error'
            );
            return back()->with($notifiction);
        }

        $tag = Tag::create([
            'user_id' => Auth::user()->id,
            'status' => 'true',
            'created_at' => Carbon::now(),
        ]);

        TagTranslation::insert([
            'name' => $request->en_tag,
            'slug' => strtolower(str_replace(' ', '-', $request->en_tag)),
            'locale' => $request->en_locale,
            'tag_id' => $tag->id,
        ]);

        TagTranslation::insert([
            'name' => $request->la_tag,
            'slug' => strtolower(str_replace(' ', '-', $request->la_tag)),
            'locale' => $request->la_locale,
            'tag_id' => $tag->id,
        ]);

        $notifiction = array(
            'message' => 'Creating Tag Successfully!!', 'alert-type' => 'success'
        );

        return back()->with($notifiction);
    }

    public function EditTag(Request $request)
    {
        $id = $request->id;
        $tags = Tag::withoutTrashed()->get();
        $trashed = Tag::onlyTrashed()->count();
        $en_tags = TagTranslation::where('tag_id', $id)->where('locale', 'en')->first();
        $la_tags = TagTranslation::where('tag_id', $id)->where('locale', 'la')->first();
        $update = 'true';
        return view('admin.tag.tag_all', compact('tags', 'en_tags', 'la_tags', 'update', 'trashed'));
    }

    public function UpdateTag(Request $request)
    {
        $request->validate([
            'en_tag' => 'required',
            'la_tag' => 'required',
        ]);

        $id = $request->id;
        $en_id = $request->en_id;
        $la_id = $request->la_id;
        $en_tag = strip_tags($request->en_tag);
        $la_tag = strip_tags($request->la_tag);
        $valid_en = TagTranslation::where('name', $en_tag)->where('locale', 'en')->first();
        $valid_la = TagTranslation::where('name', $la_tag)->where('locale', 'la')->first();

        if ($valid_en) {
            $db_en_id = $valid_en->id;
            if ($en_id != $db_en_id) {
                $notifiction = array(
                    'message' => 'This Tag Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        if ($valid_la) {
            $db_la_id = $valid_la->id;
            if ($la_id != $db_la_id) {
                $notifiction = array(
                    'message' => 'This Tag Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        Tag::findOrFail($id)->update([
            'user_id' => Auth::user()->id,
        ]);

        TagTranslation::findOrFail($en_id)->update([
            'name' => $en_tag,
            'slug' => strtolower(str_replace(' ', '-', $en_tag)),
        ]);

        TagTranslation::findOrFail($la_id)->update([
            'name' => $la_tag,
            'slug' => strtolower(str_replace(' ', '-', $la_tag)),
        ]);

        $notifiction = array(
            'message' => 'Update Tag Sucessfully!!', 'alert-type' => 'info'
        );

        return redirect()->route('tag')->with($notifiction);
    }

    public function DeleteTag(Request $request)
    {
        $id = $request->id;
        Tag::findOrFail($id)->delete();
        $notifiction = array(
            'message' => 'Deleted Tag Sucessfully!!', 'alert-type' => 'danger'
        );
        return back()->with($notifiction);
    }

    public function index(Request $request)
    {
        $trashed = Tag::onlyTrashed()->get();
        return view('admin.tag.tag_trash', compact('trashed'));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        Tag::where('id', $id)->withTrashed()->restore();
        $notifiction = array(
            'message' => 'Restore Tag Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('tag')->with($notifiction);
    }

    public function force_delete(Request $request)
    {
        $id = $request->id;
        Tag::where('id', $id)->withTrashed()->forceDelete();
        $notifiction = array(
            'message' => 'Deleted Tag Sucessfully!!', 'alert-type' => 'danger'
        );
        return redirect()->route('tag')->with($notifiction);
    }
}
