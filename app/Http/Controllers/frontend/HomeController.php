<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Company;
use App\Models\IpCount;
use App\Models\Post;
use App\Models\RegionName;
use App\Models\Socialmedia;
use App\Models\VisitorCount;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Home()
    {
        $ip = request()->ip();

        $is_public_ip = Location::get($ip);
        if ($is_public_ip == false) {
            $ip = '115.84.112.140';
        }

        $user_agent = request()->userAgent();
        $allip = VisitorCount::where('ip', $ip)->get();
        $data = Location::get($ip);

        if (count($allip) == 0) {
            $visitor = new VisitorCount();
            $visitor->ip = $ip;
            $visitor->user_agent = $user_agent;
            $visitor->countryName = $data->countryName;
            $visitor->regionName = $data->regionName;
            $visitor->cityName = $data->cityName;
            $visitor->save();

            $regionName = VisitorCount::where('regionName', $data->regionName)->get();
            if ($data->countryName == 'Laos' && count($regionName) == 1) {
                $ipByRegionName = new RegionName();
                $ipByRegionName->countryName = $data->countryName;
                $ipByRegionName->regionName = $data->regionName;
                $ipByRegionName->save();
            } else {
                RegionName::where('regionName', $data->regionName)->update(['totalVisitor' => DB::raw('totalVisitor+1')]);
            }

            $ips = new IpCount();
            $ips->ip = $ip;
            $ips->user_agent = $user_agent;
            $ips->countryName = $data->countryName;
            $ips->countryCode = $data->countryCode;
            $ips->regionCode = $data->regionCode;
            $ips->regionName = $data->regionName;
            $ips->cityName = $data->cityName;
            $ips->latitude = $data->latitude;
            $ips->longitude = $data->longitude;
            $ips->areaCode = $data->areaCode;
            $ips->timezone = $data->timezone;
            $ips->driver = $data->driver;
            $ips->save();
        } else {
            $ips = new IpCount();
            $ips->ip = $ip;
            $ips->user_agent = $user_agent;
            $ips->countryName = $data->countryName;
            $ips->countryCode = $data->countryCode;
            $ips->regionCode = $data->regionCode;
            $ips->regionName = $data->regionName;
            $ips->cityName = $data->cityName;
            $ips->latitude = $data->latitude;
            $ips->longitude = $data->longitude;
            $ips->areaCode = $data->areaCode;
            $ips->timezone = $data->timezone;
            $ips->driver = $data->driver;
            $ips->save();
        }

        $banner_slide = Banner::where('status', "1")->get();
        $count = $banner_slide->count();
        $category = Category::all();
        $post = Post::latest()->take(4)->get();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        $SITE_DOMAIN = env('SITE_DOMAIN');

        $test = Category::take(1)->first();
        // dd($test->user_id);
        return view('frontend.home_all.homepage', compact('banner_slide', 'category', 'post', 'footer', 'social', 'line', 'count', 'SITE_DOMAIN'));
    }

    public function allpost(Request $request)
    {



        //search
        $search = request()->query('search');
        $search_post = Post::whereHas('translations', function ($query) use ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        })->get();
        if (count($search_post) == 0) {
            $search_post = Post::whereHas('category', function ($query) use ($search) {
                $query->whereHas('translations', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            })->get();
        }

        $firstPost = Post::latest()->take(1)->get();
        $posts = Post::latest()->skip(1)->take(4)->get();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        $categories = Category::all();



        // dd($categories);
        $SITE_DOMAIN = env('SITE_DOMAIN');

        // if has search
        if ($search) {
            return view('frontend.search', compact('posts', 'social', 'line', 'footer', 'categories', 'SITE_DOMAIN', 'search_post', 'firstPost'));
        } else {
            return view('frontend.all_post', compact('posts', 'social', 'line', 'footer', 'categories', 'SITE_DOMAIN', 'search_post', 'firstPost'));
        }
    }

    public function banner($locale, $id)
    {
        $banner = Banner::where('status', "1")->where('id', $id)->first();
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        return view('frontend.banner.banner', compact('social', 'line', 'footer', 'banner'));
    }
}
