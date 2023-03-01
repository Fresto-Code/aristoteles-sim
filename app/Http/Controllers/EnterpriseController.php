<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnterpriseController extends Controller
{
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

        return view('pages.enterprise.enterprise', compact('enterprise'));
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
        // validate
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable|numeric|digits_between:10,12',
            'email' => 'nullable|email:dns',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        try {
            Enterprise::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'logo' => $request->logo,
                'description' => $request->description,
            ]);

            return redirect()->route('enterprise')->with('create', 'Berhasil menyimpan pengaturan perusahaan');
        } catch (\Throwable $th) {
            return redirect()->route('enterprise')->with('error', 'Gagal menyimpan pengaturan perusahaan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function show(Enterprise $enterprise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function edit(Enterprise $enterprise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enterprise $enterprise)
    {
        // validate
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable|numeric|digits_between:10,12',
            'email' => 'nullable|email:dns',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        try {
            $enterprise->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'logo' => $request->logo,
                'description' => $request->description,
            ]);
            return redirect()->route('enterprise')->with('update', 'Berhasil menyimpan pengaturan perusahaan');
        } catch (\Throwable $th) {
            return redirect()->route('enterprise')->with('error', 'Gagal menyimpan pengaturan perusahaan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enterprise $enterprise)
    {
        //
    }
}
