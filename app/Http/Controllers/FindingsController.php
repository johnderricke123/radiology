<?php

namespace App\Http\Controllers;

use App\Findings;
use App\Http\Requests\StoreFindingsRequest;
use App\Http\Requests\UpdateFindingsRequest;

class FindingsController extends Controller
{
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
     * @param  \App\Http\Requests\StoreFindingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFindingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Findings  $findings
     * @return \Illuminate\Http\Response
     */
    public function show(Findings $findings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Findings  $findings
     * @return \Illuminate\Http\Response
     */
    public function edit(Findings $findings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFindingsRequest  $request
     * @param  \App\Findings  $findings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFindingsRequest $request, Findings $findings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Findings  $findings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Findings $findings)
    {
        //
    }
}
