<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letter;

class LettersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('letter.create');        
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
            $certificado = file_get_contents($request->certificado);
//            $chavePublica = openssl_pkey_get_details(openssl_pkey_get_public($certificado))["key"];
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());                        
        }

        $carta = Letter::create([
            'title' => $request->title,
            'letter_from' => auth()->user()->name,
            'letter_to' => $request->letter_to,
            'content' => $request->content
        ]);
        
        
        return response($carta->export($certificado))
            ->header('Content-type', 'application/pdf')
            ->header('Content-Disposition', 'attachment;');

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
