<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\HospitalRoom;
use App\Http\Requests\RoomRequestRequest\StoreRoomRequestRequest;
use App\Http\Requests\RoomRequestRequest\UpdateRoomRequestRequest;
use App\Http\Resources\RoomRequestResource;
use App\RoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authenticatedUser = Auth::user();
        $hospital = Hospital::findOrFail($authenticatedUser->id);

        $occupiedRooms = $hospital->rooms->roomRequests;
        return $occupiedRooms;
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
    public function store(StoreRoomRequestRequest $request)
    {
        //
        $roomRequest = RoomRequest::create($request->validated());

        return new RoomRequestResource($roomRequest);
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
    public function update(UpdateRoomRequestRequest $request, RoomRequest $roomRequest)
    {
        //
        $roomRequest = RoomRequest::findOrFail($roomRequest);
        $roomRequest->update($request->validated());

        $hospitalRoom =HospitalRoom::findOrFail($roomRequest->room_id);
        $hospitalRoom->update($request->validated());

        return new RoomRequestResource($roomRequest);
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
