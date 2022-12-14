<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        //avatar name
        $folderAndFileName = time() . '_avatar' .  $data['name'];
        $avatarName = $folderAndFileName . '.' . $data['avatar']->extension();
        $data['avatar']->move(
            public_path('avatar_temp'),
            $avatarName
        );

        return User::create([
            'name' => strtolower($data['name']),
            'email' => strtolower($data['email']),
            'username' => strtolower($data['username']),
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'cover' => Storage::disk('spaces')->putFile(
                'user-avatar/' . $folderAndFileName,
                public_path('avatar_temp') . '/' . $avatarName,
                'public'
            )
        ]);
    }
}
