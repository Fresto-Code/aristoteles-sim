<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagazineController extends Controller
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
        $magazine = Magazine::all();
        return view('pages.magazine.magazine', compact('magazine'));
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function browse()
    {
        $magazines = Magazine::join('users', 'users.id', '=', 'magazines.author_id')
            ->where('magazines.moderation_status','published')
            ->get(['magazines.*', 'users.name']);
        return view('pages.magazine.browse', compact('magazines'));
    }

    public function view(Magazine $magazine)
    {
        return view('pages.magazine.view_pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.magazine.create');
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
            'url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'moderation_status' => 'required',
        ]);

        //image name
        $imageName = time() . '_magazine.' . $request->url->extension();
        $request->url->move(public_path('magazine-images'), $imageName);

        Magazine::create([
            'author_id' =>  Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'url' => $imageName,
            'moderation_status' => $request->moderation_status,
        ]);
        
        return redirect('magazine')->with('create', 'Magazine added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function show(Magazine $magazine)
    {
        $magazine = Magazine::find($magazine->id);
        return view('pages.magazine.show', compact('magazine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function edit(Magazine $magazine)
    {
        return view('pages.magazine.edit', compact('magazine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Magazine $magazine)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'moderation_status' => 'required',
        ]);

        //image name
        $imageName = time() . '_magazine.' . $request->url->extension();
        $request->url->move(public_path('magazine-images'), $imageName);

        Magazine::where('id', $magazine->id)
            ->update([
                'author_id' =>  Auth::user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'url' => $imageName,
                'moderation_status' => $request->moderation_status,
            ]);

        return redirect('magazine')->with('update', 'Magazine updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Magazine  $magazine
     * @return \Illuminate\Http\Response
     */
    public function softDelete(Magazine $magazine)
    {
        //soft delete
        $magazine->delete();
        return redirect('magazine')->with('delete', 'Magazine deleted successfully!');
    }
    
    public function destroy(Magazine $magazine)
    {
        //
    }
}
