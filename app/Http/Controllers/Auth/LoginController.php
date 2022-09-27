<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function username()
    {
        //get the login value from the request
        $loginValue = request('username');
        //check if the login value is an email or not
        $this->username = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //merge the login value to the request
        request()->merge([$this->username => $loginValue]);
        //return login type
        return property_exists($this, 'username') ? $this->username : 'email';
        //dd($this->username);
    }

    protected function redirectTo()
    {
        if (auth()->user()->role == 'admin') {
            return '/home';
        } else if (auth()->user()->role == 'principal') {
            return '/home';
        } else if (auth()->user()->role == 'teacher') {
            return '/home';
        } else if (auth()->user()->role == 'osis') {
            return '/home';
        } else {
            return '/magazine/browse/dashboard';
        }
    }

    // //if authentication success can access login page
    // protected function authenticated(Request $request, $user)
    // {
    //     //login with username or email
    //     $this->username();
    //     //get the login value from the request
    //     $loginValue = request('username');
    //     //check if the login value is an email or not
    //     $this->username = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //     //merge the login value to the request
    //     request()->merge([$this->username => $loginValue]);
    //     //return login type
    //     //return property_exists($this, 'username') ? $this->username : 'email';


    //     if ($user->role == 'admin') {
    //         return redirect()->intended('/home');
    //     } else if ($user->role == 'principal') {
    //         return redirect()->intended('/home');
    //     } else if ($user->role == 'teacher') {
    //         return redirect()->intended('/home');
    //     } else if ($user->role == 'osis') {
    //         return redirect()->intended('/home');
    //     } else {
    //         return redirect()->intended('/magazine/browse/dashboard');
    //     }
    // }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
