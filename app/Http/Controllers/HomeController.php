<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->role == 'student') {
            $magazines = Magazine::join(
                'users',
                'users.id',
                '=',
                'magazines.author_id'
            )
                ->where('magazines.author_id', Auth::user()->id)
                ->orderBy('moderation_status')
                ->paginate(10, ['magazines.*', 'users.name', 'users.avatar']);
        } else {
            $magazines = Magazine::join(
                'users',
                'users.id',
                '=',
                'magazines.author_id'
            )
                ->orderBy('moderation_status')
                ->paginate(10, ['magazines.*', 'users.name', 'users.avatar']);
        }

        return view('pages.magazine.magazine', compact('magazines'));
    }
}
