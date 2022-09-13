<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\ModerationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;

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
        $magazines = Magazine::join(
            'users',
            'users.id',
            '=',
            'magazines.author_id'
        )->get(['magazines.*', 'users.name'])->sortBy('moderation_status');;
        return view('pages.magazine.magazine', compact('magazines'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function browse()
    {
        $magazines = Magazine::join(
            'users',
            'users.id',
            '=',
            'magazines.author_id'
        )
            ->where('magazines.moderation_status', 'published')
            ->get(['magazines.*', 'users.name'])->sortBy('updated_at');;
        return view('pages.magazine.public.magazine', compact('magazines'));
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
        return view('pages.magazine.public.create');
    }

    /**
     * Approve the magazine to be published.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve(Magazine $magazine)
    {
        try {
            Magazine::where('id', $magazine->id)->update([
                'moderation_status' => 'published',
            ]);

            $updatedMagzine = Magazine::where('id', $magazine->id)->first();
            //dd($updatedMagzine);

            Storage::disk('spaces')->setVisibility($updatedMagzine->url, 'public');
            Storage::disk('spaces')->setVisibility($updatedMagzine->cover, 'public');
            return redirect('magazine')->with(
                'update',
                'Magazine updated successfully!'
            );
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                // 'cover_file' => 'mimes:jpeg,png|max:200000',
                // 'magazine_file' => 'required|mimes:pdf|max:500000',
            ]);

            $folderAndFileName = time() . '_magazine';

            //magazine name and file
            $magazineName =
                $folderAndFileName . '.' . $request->magazine_file->extension();
            $request->magazine_file->move(
                public_path('magazines_temp'),
                $magazineName
            );

            //magazine cover
            $magazineCoverName =
                $folderAndFileName . '.' . $request->cover_file->extension();
            $request->cover_file->move(
                public_path('magazines_temp'),
                $magazineCoverName
            );

            Magazine::create([
                'author_id' => Auth::user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'url' => Storage::disk('spaces')->putFile(
                    'magazines/' . $folderAndFileName,
                    public_path('magazines_temp') . '/' . $magazineName,
                    'private'
                ),
                'cover' => Storage::disk('spaces')->putFile(
                    'magazines/' . $folderAndFileName,
                    public_path('magazines_temp') . '/' . $magazineCoverName,
                    'private'
                ),
                'moderation_status' => 'draft',
            ]);

            return redirect('magazine/browse/dashboard')->with(
                'create',
                'Magazine added successfully!'
            );
        } catch (\Throwable $th) {
            return redirect('magazine/browse/dashboard')->with(
                'Failed',
                'Magazine failed to be added!'
            );
        }
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

        Magazine::where('id', $magazine->id)->update([
            'author_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'url' => $imageName,
            'moderation_status' => $request->moderation_status,
        ]);

        return redirect('magazine')->with(
            'update',
            'Magazine updated successfully!'
        );
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
        return redirect('magazine')->with(
            'delete',
            'Magazine deleted successfully!'
        );
    }

    public function destroy(Magazine $magazine)
    {
        //
    }

    public function showMagazineComment(Magazine $magazine)
    {
        $comments = ModerationComment::where('magazine_id', $magazine->id)->get();
        return view('pages.magazine.comment', compact('comments', 'magazine'));
    }
}
