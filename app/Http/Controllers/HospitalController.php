<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\HospitalRoom;
use App\Http\Requests\HospitalRequest\DestroyHospitalRequest;
use App\Http\Requests\HospitalRequest\IndexHospitalRequest;
use App\Http\Requests\HospitalRequest\ShowHospitalRequest;
use App\Http\Requests\HospitalRequest\StoreHospitalRequest;
use App\Http\Requests\HospitalRequest\UpdateHospitalRequest;
use App\Http\Resources\HospitalResource;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexHospitalRequest $request)
    {
        //
        $hospital = Hospital::all();

        return HospitalResource::collection($hospital);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHospitalRequest $request)
    {
        //
        $hospital = Hospital::create($request->validate());
        return new HospitalResource($hospital);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(ShowHospitalRequest $request, int $hospital)
    {
        $hospital = Hospital::findOrFail($hospital);

        return new HospitalResource($hospital);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


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
    public function update(UpdateHospitalRequest $request, int $hospital)
    {
        $hospital = Hospital::findOrFail($hospital);
        $hospital->update($request->validated());

        return new HospitalResource($hospital);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyHospitalRequest $request, int $hospital)
    {
        //
        $hospital = Hospital::findOrFail($hospital);
        $hospital->delete();

        return null;
    }
}
