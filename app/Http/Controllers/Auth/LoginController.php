<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

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
    //protected $redirectTo = RouteServiceProvider::HOME;


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

    // public function username()
    // {
    //     //get the login value from the request
    //     $loginValue = request('username');
    //     //check if the login value is an email or not
    //     $this->username = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //     //merge the login value to the request
    //     request()->merge([$this->username => $loginValue]);
    //     //return login type
    //     return property_exists($this, 'username') ? $this->username : 'email';
    //     //dd($this->username);
    // }

    // protected function redirectTo()
    // {
    //     if (auth()->user()->role == 'admin') {
    //         return '/home';
    //     } else if (auth()->user()->role == 'principal') {
    //         return '/home';
    //     } else if (auth()->user()->role == 'teacher') {
    //         return '/home';
    //     } else if (auth()->user()->role == 'osis') {
    //         return '/home';
    //     } else {
    //         return '/magazine/browse/dashboard';
    //     }
    // }

    //if authentication success can access login page
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();
        $userEmail = User::where('email', $request->username)->first();

        //login with username or email and password md5 or bcrypt
        if ($user != null) {
            //check if the user id_v2 is null
            if ($user->id_v2 == null) {
                if ($user) {
                    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                        if (auth()->user()->role == 'admin') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'principal') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'teacher') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'osis') {
                            return redirect()->intended('home');
                        } else {
                            return redirect()->intended('magazine/browse/dashboard');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Username atau Password salah');
                    }
                }
            } else {
                //login with password md5
                $key = 'fresto6';
                $password = md5($request->password . $key) . md5($request->password);
                $user = User::where('username', $request->username)->where('password', $password)->first();

                if ($user) {
                    if (Auth::loginUsingId($user->id)) {
                        if (auth()->user()->role == 'admin') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'principal') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'teacher') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'osis') {
                            return redirect()->intended('home');
                        } else {
                            return redirect()->intended('magazine/browse/dashboard');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Username atau Password salah');
                    }
                } else {
                    return redirect()->back()->with('error', 'Username atau Password salah');
                }
            }
        } elseif ($userEmail != null) {
            if ($userEmail->id_v2 == null) {
                if ($userEmail) {
                    if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                        if (auth()->user()->role == 'admin') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'principal') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'teacher') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'osis') {
                            return redirect()->intended('home');
                        } else {
                            return redirect()->intended('magazine/browse/dashboard');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Username atau Password salah');
                    }
                }
            } else {
                //login with password md5
                $key = 'fresto6';
                $password = md5($request->password . $key) . md5($request->password);
                $userEmail = User::where('email', $request->username)->where('password', $password)->first();

                if ($userEmail) {
                    if (Auth::loginUsingId($userEmail->id)) {
                        if (auth()->user()->role == 'admin') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'principal') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'teacher') {
                            return redirect()->intended('home');
                        } else if (auth()->user()->role == 'osis') {
                            return redirect()->intended('home');
                        } else {
                            return redirect()->intended('magazine/browse/dashboard');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Username atau Password salah');
                    }
                } else {
                    return redirect()->back()->with('error', 'Username atau Password salah');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Username atau Password salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
