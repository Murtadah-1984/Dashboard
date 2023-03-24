<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function config()
    {
        return view('settings.config');
    }

    public function banner(Request $request)
    {
        $image = $request->file('company_banner');
        $image_name = time() . 'Controllers' .$request->image->extension();
        $request->image->move(public_path('images'), $image_name);
        config(['dashboard.company_banner'=>'images/'.$image_name]);
        return redirect()->route('dashboard.config')->with('success', 'Dashboard Configration Updated Successfully!');
    }

    public function logo(Request $request)
    {
        $image = $request->file('company_logo');
        $image_name = time() . 'Controllers' .$request->image->extension();
        $request->image->move(public_path('images'), $image_name);
        config(['dashboard.company_logo'=>'images/'.$image_name]);
        return redirect()->route('dashboard.config')->with('success', 'Dashboard Configration Updated Successfully!');
    }

    public function setting(Request $request)
    {
        config(['dashboard.company_fullname' => $request->fullname]);
        config(['dashboard.company_name' => $request->name]);
        config(['dashboard.company_url' => $request->url]);
        config(['dashboard.company_email' => $request->email]);
        config(['dashboard.company_sologon' => $request->sologon]);
        config(['dashboard.time_zone' => $request->time_zone]);
        Config::set('dashboard.company_name' , $request->name);

        return redirect()->route('dashboard.config')->with('success', 'Dashboard Configration Updated Successfully!');
    }

}
