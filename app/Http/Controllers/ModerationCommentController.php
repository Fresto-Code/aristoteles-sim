<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\ModerationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModerationCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Magazine $magazine)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        ModerationComment::create([
            'magazine_id' => $magazine->id,
            'user_id' => Auth::user()->id,
            'comment' => $request->comment
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModerationComment  $moderationComment
     * @return \Illuminate\Http\Response
     */
    public function show(ModerationComment $moderationComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModerationComment  $moderationComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ModerationComment $moderationComment, Magazine $magazine)
    {
        return view('pages.magazine.moderation-comment-edit', compact('moderationComment', 'magazine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModerationComment  $moderationComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModerationComment $moderationComment)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        ModerationComment::where('id', $moderationComment->id)
            ->update([
                'comment' => $request->comment
            ]);

        return redirect()->route('magazine.comment', $moderationComment->magazine_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModerationComment  $moderationComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModerationComment $moderationComment)
    {
        //
    }
}
