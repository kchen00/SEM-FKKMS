<?php

namespace App\Http\Controllers;

use App\Models\bursary;
use App\Http\Requests\StorebursaryRequest;
use App\Http\Requests\UpdatebursaryRequest;

class BursaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorebursaryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(bursary $bursary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bursary $bursary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebursaryRequest $request, bursary $bursary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bursary $bursary)
    {
        //
    }
}
