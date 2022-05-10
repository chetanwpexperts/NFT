<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Nfts;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = "";
        if(Auth::check())
        {
            $user = Auth::user();
        }
        // $recentNfts = Nfts::orderByDesc("id")->limit(12)->get();
        $recentNfts = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')
            ->where('nfts.type', "!=", "draft")
            ->where('nfts.status', "!=", "draft")
            ->where("nfts.status", '!=', "sold")
            ->orderByDesc("nfts.id")->limit(12)->get();

        $trending = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')->where("nfts.views", ">=", "500")->where("nfts.type", "!=", "draft")->where("nfts.status", '!=', "draft")->orderByDesc("nfts.id")->limit(20)->get();

        return view('home', compact('user','recentNfts', 'trending'));
    }
    
    public function about()
    {
        $user = "";
        if(Auth::check())
        {
            $user = Auth::user();
        }
        $page = array();
        $page['title'] = "About Us";
        $page['description'] = "About Description";
        return view('innertemplates/about',compact('page','user'));
    }
    
    public function contact()
    {
        $user = "";
        if(Auth::check())
        {
            $user = Auth::user();
        }
        $page = array();
        $page['title'] = "Contact Us";
        $page['description'] = "Contact Us";
        return view('innertemplates/contact',compact('page','user'));
    }
    
    public function ppolicy()
    {
        $user = "";
        if(Auth::check())
        {
            $user = Auth::user();
        }
        $page = array();
        $page['title'] = "Privacy Policy";
        $page['description'] = "Privacy Policy";
        return view('innertemplates/ppolicy',compact('page','user'));
    }
    
    public function terms()
    {
        $user = "";
        if(Auth::check())
        {
            $user = Auth::user();
        }
        $page = array();
        $page['title'] = "Terms And Conditions";
        $page['description'] = "Terms And Conditions";
        return view('innertemplates/terms',compact('page','user'));
    }
    
    public function refundCancelationPolicy()
    {
        $user = "";
        if(Auth::check())
        {
            $user = Auth::user();
        }
        $page = array();
        $page['title'] = "Refund And Cancelation Policy";
        $page['description'] = "Refund And Cancelation Policy";
        return view('innertemplates/refund-cancelation',compact('page','user'));
    }
    
    public function faq()
    {
        $user = "";
        if(Auth::check())
        {
            $user = Auth::user();
        }
        $page = array();
        $page['title'] = "FAQ";
        $page['description'] = "FAQ";
        return view('innertemplates/faq',compact('page','user'));
    }
}
