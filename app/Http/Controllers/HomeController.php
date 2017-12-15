<?php

namespace App\Http\Controllers;

use App\Product;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalProduct = count(Product::where('tenantId', Auth::user()->tenantId)->get());
        $totalService = count(Service::where('tenantId', Auth::user()->tenantId)->get());
        return view('home', compact('totalProduct', 'totalService'));
    }
}
