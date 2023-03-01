<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class OwnLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // get enterprise
        $enterprise = DB::table('enterprises')
            ->first();
        return view('auth.login', compact('enterprise'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $request->username)->first();
        $userEmail = User::where('email', $request->username)->first();

        //login with username or email and password md5 or bcrypt
        if ($user != null) {
            //check if the user id_v2 is null
            if ($user->id_v2 == null || $user->is_change_password_v2 == 1) {
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
            if ($userEmail->id_v2 == null || $userEmail->is_change_password_v2 == 1) {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
