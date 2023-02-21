<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use App\Models\Menu;

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
        $image_name = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $image_name);
        config(['dashboard.company_banner'=>'images/'.$image_name]);
        return redirect()->route('dashboard.config')->with('success', 'Dashboard Configration Updated Successfully!');
    }

    public function logo(Request $request)
    {
        $image = $request->file('company_logo');
        $image_name = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $image_name);
        config(['dashboard.company_logo'=>'images/'.$image_name]);
        return redirect()->route('dashboard.config')->with('success', 'Dashboard Configration Updated Successfully!');
    }

    public function setting(Request $request)
    {
        
        foreach($request->all() as $key=>$value){
            if(!is_null($value) && $key != "_token"){
                config([$key => $value]);
            }
        }
        return redirect()->route('dashboard.config')->with('success', 'Dashboard Configration Updated Successfully!');
    }

}
