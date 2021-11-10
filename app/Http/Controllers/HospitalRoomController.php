<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\HospitalRoom;
use App\Http\Requests\HospitalRoomRequest\DestroyHospitalRoomRequest;
use App\Http\Requests\HospitalRoomRequest\IndexHospitalRoomRequest;
use App\Http\Requests\HospitalRoomRequest\ShowHospitalRoomRequest;
use App\Http\Requests\HospitalRoomRequest\StoreHospitalRoomRequest;
use App\Http\Requests\HospitalRoomRequest\UpdateHospitalRoomRequest;
use App\Http\Resources\HospitalResource;
use App\Http\Resources\HospitalRoomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexHospitalRoomRequest $request)
    {
        //
        $hospitalRoom = HospitalRoom::all();

        return HospitalRoomResource::collection($hospitalRoom);
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
    public function store(StoreHospitalRoomRequest $request)
    {
        $user = Auth::user();
        $hospital = Hospital::whereUserId($user->id)->first();

        // dd($request->validated());
        $hospitalRoom = HospitalRoom::create(
            array_merge([
                'hospital_id' => $hospital->id,
            ], $request->validated()));


        return new HospitalRoomResource($hospitalRoom);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowHospitalRoomRequest $request, int $hospitalRoom)
    {
        //
        $hospitalRoom = HospitalRoom::findOrFail($hospitalRoom);
        return new HospitalRoomResource($hospitalRoom);
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
    public function update(UpdateHospitalRoomRequest $request, int $hospitalRoom)
    {
        //
        $hospitalRoom = HospitalRoom::findOrFail($hospitalRoom);
        $hospitalRoom->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyHospitalRoomRequest $request, int $hospitalRoom)
    {
        //
        $hospitalRoom = HospitalRoom::findOrFail($hospitalRoom);
        $hospitalRoom->delete();

        return null;
    }
}
