<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\documentresource;
use App\Models\document;
use Illuminate\Http\Request;

class documentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        $validation=$request->validated();
        $path = $request->file('file_path')->store('documents', 'public');
        $document=document::create([
            'file_path'=>$path,
            'description'=> $validation['description'],
            'title' => $validation['title'],
            'user_id' => $validation['user_id'],
        ]);

        return (new documentresource($document))
            ->additional([
                'message' => 'successfullprofile stored',
            ])
            ->response()
            ->setStatusCode(200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
