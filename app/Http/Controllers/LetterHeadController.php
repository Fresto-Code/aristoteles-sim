<?php

namespace App\Http\Controllers;

use App\Models\LetterHead;
use Illuminate\Http\Request;

class LetterHeadController extends Controller
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
        $letterHeads = LetterHead::all();
        return view('pages.letterHead.letterHead', compact('letterHeads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.letterHead.create');
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
            'title' => 'required',
            'left_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'right_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {

            LetterHead::create([
                'title' => $request->title,
                'left_picture' => $request->left_picture,
                'right_picture' => $request->right_picture,
                'detail' => $request->detail,
                'sub_detail' => $request->sub_detail,
            ]);
            return redirect('letter-head')->with('create', 'Letter head created!');
        } catch (\Throwable $th) {
            return redirect('letter-head')->with('error', 'Letter head not created!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LetterHead  $letterHead
     * @return \Illuminate\Http\Response
     */
    public function show(LetterHead $letterHead)
    {
        return view('pages.letterHead.show', compact('letterHead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LetterHead  $letterHead
     * @return \Illuminate\Http\Response
     */
    public function edit(LetterHead $letterHead)
    {
        return view('pages.letterHead.edit', compact('letterHead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LetterHead  $letterHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LetterHead $letterHead)
    {
        $request->validate([
            'title' => 'required',
            'left_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'right_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            LetterHead::where('id', $letterHead->id)
                ->update([
                    'title' => $request->title,
                    'left_picture' => $request->left_picture,
                    'right_picture' => $request->right_picture,
                    'detail' => $request->detail,
                    'sub_detail' => $request->sub_detail,
                ]);
            return redirect('letter-head')->with('update', 'LetterHead updated!');
        } catch (\Throwable $th) {
            return redirect('letter-head')->with('error', 'Letter head not updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LetterHead  $letterHead
     * @return \Illuminate\Http\Response
     */

    public function softDelete(LetterHead $letterHead)
    {
        try {
            $letterHead->delete();
            return redirect('letter-head')->with('delete', 'LetterHead deleted!');
        } catch (\Throwable $th) {
            return redirect('letter-head')->with('error', 'Letter head not deleted!');
        }
    }

    public function destroy(LetterHead $letterHead)
    {
        //
    }
}
