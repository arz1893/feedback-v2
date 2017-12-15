<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Tenant;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function companyLogin() {
        return view('auth.company-login');
    }

    public function checkTenant(Request $request) {
        $tenant = Tenant::where('email', $request->tenant_email)->first();
        if(is_null($tenant)) {
            return redirect()->back()->withErrors(['error' => 'Sorry we couldn\'t find your company']);
        } else {
            $request->session()->put('tenant_id', $tenant->systemId);
            return redirect()->route('login');
        }
    }
}
