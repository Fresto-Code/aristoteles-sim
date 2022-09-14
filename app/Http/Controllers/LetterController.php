<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LetterController extends Controller
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
        //get letter not approve
        $latter = Letter::where('is_reviewed', '!=', 'false')->get();
        return view('pages.letter.letter', compact('latter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', '=', 'teacher')->get();
        return view('pages.letter.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|mimes:pdf|max:2048',
        ]);

        // $file = $request->file('file');
        // $name = time() . $file->getClientOriginalName();
        // $file->move(public_path() . '/files/', $name);

        // $letter = new Letter();
        // $letter->title = $request->title;
        // $letter->content = $request->content;
        // $letter->file = $name;
        // $letter->author_id = auth()->user()->id;
        // $letter->save();

        // file name
        try {
            $fileName = time() . '.' . $request->url->extension();
            $request->url->move(public_path('latter_temp'), $fileName);

            Letter::create([
                'user_recipient_id' => $request->user_recipient_id,
                'is_reviewed' => 'false',
                'note' => $request->note,
                'url' => $fileName,
            ]);

            return redirect()->route('letter.index')->with('create', 'Letter created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('letter.index')->with('error', 'Letter not created!');
            //return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter)
    {
        //$letter = Letter::find($letter->id);
        return view('pages.letter.show', compact('letter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function edit(Letter $letter)
    {
        return view('pages.letter.edit', compact('letter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Letter $letter)
    {
        $request->validate([
            'user_recipient_id' => 'required',
            'url' => 'required|mimes:pdf|max:2048',
        ]);
        try {
            // file name
            $fileName = time() . '.' . $request->url->extension();
            $request->url->move(public_path('latter_temp'), $fileName);

            Letter::where('id', $letter->id)->update([
                'user_recipient_id' => $request->user_recipient_id,
                'is_reviewed' => 'false',
                'note' => $request->note,
                'url' => $fileName,
            ]);

            return redirect()->route('letter.index')->with('update', 'Letter updated successfully.');
        } catch (\Throwable $th) {
            //return $th->getMessage();
            return redirect()->route('letter.index')->with('error', 'Letter not updated!');
        }
    }

    public function softDelete($letter)
    {
        try {
            $letter->delete();
            return redirect()->route('letter.index')->with('delete', 'Letter deleted successfully.');
        } catch (\Throwable $th) {
            //return $th->getMessage();
            return redirect()->route('letter.index')->with('error', 'Letter not deleted!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Letter $letter)
    {
        //
    }

    public function principalUpdate(Request $request, Letter $letter)
    {
        $request->validate([
            'user_recipient_id' => 'required',
            'is_reviewed' => 'required',
        ]);

        try {
            Letter::where('id', $letter->id)->update([
                'user_recipient_id' => $request->user_recipient_id,
                'is_reviewed' => $request->is_reviewed,
                'note' => $request->note,
            ]);

            return redirect()->route('letter.index')->with('update', 'Letter updated successfully.');
        } catch (\Throwable $th) {
            //return $th->getMessage();
            return redirect()->route('letter.index')->with('error', 'Letter not updated!');
        }
    }

    public function letterReviewed()
    {
        $latter = Letter::where('is_reviewed', '=', 'true')->get();
        return view('pages.letter.letter', compact('latter'));
    }

    public function createReplyLetter($letter)
    {
        return view('pages.letter.createReplyLetter', compact('letter',));
    }

    public function storeReplyLetter(Request $request)
    {
        $request->validate([
            'reply_latter' => 'required|mimes:pdf|max:2048',
        ]);

        try {
            // file name
            $fileName = time() . '.' . $request->reply_latter->extension();
            $request->reply_latter->move(public_path('latter_temp'), $fileName);

            Letter::create([
                'reply_latter' => $fileName,
            ]);

            return redirect()->route('letter.index')->with('create', 'Letter created successfully.');
        } catch (\Throwable $th) {
            //return $th->getMessage();
            return redirect()->route('letter.index')->with('error', 'Letter not created!');
        }
    }
}
