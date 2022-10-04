<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $users = User::orderBy('updated_at', 'desc')
            ->where('deleted_at', null)
            ->paginate(10);
        return view('pages.user.user', compact('users'));
        // return view('users.index');
    }
    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email:dns',
            'username' => 'required|min:3|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(6)],
            'role' => 'required',
        ]);

        try {
            $user = User::create([
                'name' => strtolower($request->name),
                'email' => strtolower($request->email),
                'username' => strtolower($request->username),
                'password' => bcrypt($request->password),
                'avatar' => 'user-avatar/5.png',
                'role' => $request->role,
            ]);
            return redirect()->route('user')->with('create', 'User created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('user')->with('create', 'User created failed.');
        }
    }

    public function edit(User $user)
    {
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required',
        ]);

        try {
            $user->update([
                'role' => $request->role,
            ]);
            return redirect()->route('user')->with('update', 'User updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('user')->with('update', 'User updated failed.');
        }
    }

    public function softDelete(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('user')->with('delete', 'User deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('user')->with('delete', 'User deleted failed.');
        }
    }

    public function search(Request $request)
    {
        //start date
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        //end date
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $search = strtolower($request->search);
        $magazines = [];
        //$search = $request->get('search');

        if ($request->role != 'all') {
            $users = User::where('name', 'like', '%' . $search . '%')
                //->orWhere('role', 'like', '%' . $search . '%')
                //condition if start date and end date is not null
                ->when($request->start_date && $request->end_date, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                //condition if start date is not null
                ->when($request->start_date, function ($query) use ($startDate) {
                    return $query->where('created_at', '>=', $startDate);
                })
                //condition if end date is not null
                ->when($request->end_date, function ($query) use ($endDate) {
                    return $query->where('created_at', '<=', $endDate);
                })
                //condition if role is not null
                ->when($request->role, function ($query) use ($request) {
                    return $query->where('role', $request->role);
                })
                ->where('deleted_at', null)
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
            return view('pages.user.user', compact('users'));
        } else {
            $users = User::where('name', 'like', '%' . $search . '%')
                //->orWhere('role', 'like', '%' . $search . '%')
                //condition if start date and end date is not null
                ->when($request->start_date && $request->end_date, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                //condition if start date is not null
                ->when($request->start_date, function ($query) use ($startDate) {
                    return $query->where('created_at', '>=', $startDate);
                })
                //condition if end date is not null
                ->when($request->end_date, function ($query) use ($endDate) {
                    return $query->where('created_at', '<=', $endDate);
                })
                ->where('deleted_at', null)
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
            return view('pages.user.user', compact('users'));
        }
    }

    public function changePassword(User $user)
    {
        return view('pages.user.change_password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        try {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('user')->with('update', 'Password updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('user')->with('error', 'Password updated failed.');
        }
    }
}
