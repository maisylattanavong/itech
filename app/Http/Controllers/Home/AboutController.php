<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\AboutTranslation;
use App\Models\MultiImage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function AboutPage()
    {
        $aboutpage = About::first();
        $en_aboutpage = AboutTranslation::where('locale', 'en')->first();
        $la_aboutpage = AboutTranslation::where('locale', 'la')->first();
        return view('admin.about_page.about_page_all', compact('aboutpage', 'en_aboutpage', 'la_aboutpage'));
    }

    public function StoreAbout(Request $request)
    {
        $request->validate([
            'en_title' => 'required',
            'en_long_description' => 'required',
            'la_title' => 'required',
            'la_long_description' => 'required',
            'about_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
        ]);

        $date = Carbon::now();
        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(523, 605)->save('storage/media/' . $name_gen);
            $save_url = 'storage/media/' . $name_gen;

            $about = About::create([
                'user_id' => Auth::user()->id,
                'status' => 'true',
                'about_image' => $save_url,
                'created_at' => $date,
                'updated_at' => $date
            ]);

            AboutTranslation::insert([
                'about_id' => $about->id,
                'locale' => 'en',
                'title' => $request->en_title,
                'long_description' => $request->en_long_description,
            ]);

            AboutTranslation::insert([
                'about_id' => $about->id,
                'locale' => 'la',
                'title' => $request->la_title,
                'long_description' => $request->la_long_description,
            ]);
        } else {
            $about = About::create([
                'user_id' => Auth::user()->id,
                'status' => 'true',
                'created_at' => $date,
                'updated_at' => $date
            ]);

            AboutTranslation::insert([
                'about_id' => $about->id,
                'locale' => 'en',
                'title' => $request->en_title,
                'long_description' => $request->en_long_description,
            ]);

            AboutTranslation::insert([
                'about_id' => $about->id,
                'locale' => 'la',
                'title' => $request->la_title,
                'long_description' => $request->la_long_description,
            ]);
        }

        $notifiction = array(
            'message' => 'About Page Insert Successfully', 'alert-type' => 'success'
        );

        return redirect()->back()->with($notifiction);
    }

    public function UpdateAbout(Request $request)
    {
        $request->validate([
            'en_title' => 'required',
            'en_long_description' => 'required',
            'la_title' => 'required',
            'la_long_description' => 'required',
        ]);

        $about_id = $request->id;
        $data = About::findOrFail($about_id);
        $image = $data->about_image;
        if ($request->file('about_image')) {
            $request->validate([
                'about_image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
            ]);

            if (file_exists($image)) {
                unlink($image);
            }

            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(523, 605)->save('storage/media/' . $name_gen);
            $save_url = 'storage/media/' . $name_gen;

            About::findOrFail($about_id)->update([
                'about_image' => $save_url,
            ]);
        }

        About::findOrFail($about_id)->update([
            'user_id' => Auth::user()->id,
        ]);

        AboutTranslation::findOrFail($request->en_id)->update([
            'title' => $request->en_title,
            'long_description' => $request->en_long_description,
        ]);

        AboutTranslation::findOrFail($request->la_id)->update([
            'title' => $request->la_title,
            'long_description' => $request->la_long_description,
        ]);

        $notifiction = array(
            'message' => 'About Page Updated without Image Successfully', 'alert-type' => 'success'
        );
        return redirect()->back()->with($notifiction);
    }


    // public function AboutMultiImage()
    // {
    //     return view('admin.about_page.multimage');
    // }

    // public function StoreMultiImage(Request $request)
    // {
    //     $image = $request->file('multi_image');
    //     foreach ($image as $multi_image) {
    //         $name_gen = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();

    //         Image::make($multi_image)->resize(220, 220)->save('upload/multi/' . $name_gen);
    //         $save_url = 'upload/multi/' . $name_gen;


    //         MultiImage::insert([
    //             'multi_image' => $save_url,
    //             'created_at' => Carbon::now(),
    //         ]);
    //     }
    //     $notifiction = array(
    //         'message' => 'Multi Image Inserted Successfully', 'alert-type' => 'success'
    //     );
    //     return redirect()->route('all.multi.image')->with($notifiction);
    // }

    // public function AllMultiImage()
    // {
    //     $allmultiImage = MultiImage::all();
    //     return view('admin.about_page.all_multiimage', compact('allmultiImage'));
    // }

    // public function EditMultiImage($id)
    // {
    //     $multiImage = MultiImage::findOrFail($id);
    //     return view('admin.about_page.edit_multi_image', compact('multiImage'));
    // }

    // public function UpdateMultiImage(Request $request)
    // {
    //     $multi_image_id = $request->id;

    //     if ($request->file('multi_image')) {
    //         $image = $request->file('multi_image');
    //         $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

    //         Image::make($image)->resize(220, 220)->save('upload/multi/' . $name_gen);
    //         $save_url = 'upload/multi/' . $name_gen;


    //         MultiImage::findOrFail($multi_image_id)->update([
    //             'multi_image' => $save_url,
    //         ]);
    //         $notifiction = array(
    //             'message' => 'Multi Image Updated Successfully', 'alert-type' => 'success'
    //         );
    //         return redirect()->route('all.multi.image')->with($notifiction);
    //     }
    // }

    // public function DeleteMultiImage($id)
    // {
    //     $multi = MultiImage::findOrFail($id);
    //     $img = $multi->multi_image;
    //     unlink($img);
    //     MultiImage::findOrfail($id)->delete();
    //     $notifiction = array(
    //         'message' => 'Multi Image Deleted Successfully', 'alert-type' => 'success'
    //     );
    //     return redirect()->back()->with($notifiction);
    // }
}
