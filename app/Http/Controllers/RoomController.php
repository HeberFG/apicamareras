<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Room;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{

    public function response()
    {
        return [
            "error" => true,
            "message" => "Wrong action!",
            "data" => []
        ];
    }

    public function index()
    {
        $rooms = Room::orderBy('type', 'asc')->get()->getServices(1);
        return $this->getResponse200($rooms);
    }

    public function create()
    {
         
    }

    public function store(Request $request)
    {
        $room = new Room();
        $room->number = $request->number;
        $room->type = $request->type;
        $room->floor = $request->floor;
        $room->state = $request->state;
        $room->user_id = $request->user_id;
        $room->build_id = $request->build_id;
        $room->save();
        foreach ($request->services as $item) {
            $room->services()->attach($item);
        }
        return $this->getResponse201("Room", "Created", $room);
    }

    public function show(Room $id)
    {
        $room = Room::with('services','observations', 'build')->get()->find($id);
        return [
            "status" => true,
            "message" => "Successfull query",
            "data" => $room
        ];
    }

    public function edit(Room $room)
    {}

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'type' => 'required',
            'floor' => 'required',
            'state' => 'required',
            'user_id' => 'required',
            'build_id' => 'required'
        ]);
        if (!$validator->fails()) {
            DB::beginTransaction();
            try {
                $room = Room::with("room", 'user', 'services')->where('id', $id)->first();
                if ($room) {
                    if ($room->user_id == auth()->user()->id) {

                        $room->number = $request->number;
                        $room->type = $request->type;
                        $room->floor = $request->floor;
                        $room->state = $request->state;
                        $room->user_id = auth()->user()->id;
                        $room->build_id = $request->build["id"];
                        foreach ($room->services as $item) {
                            $room->services()->detach($item->id);
                        }
                        foreach ($request->services as $item) {
                            $room->services()->attach($item);
                        }
                        $room = Room::with("book", 'user', 'services')->where('id', $id)->first();

                        DB::commit();

                        return $this->getResponse201(
                            "Room",
                            "updated",
                            $room
                        );
                    }else{
                        return $this->getResponse403();
                    }
                }else{
                    return $this->getResponse404();
                }
            } catch (Exception $err) {
                DB::rollBack();
                return $this->getResponse500([$err->getMessage()]);
            }
        }else{
            return $this->getResponse500([$validator->errors()]);
        }
    }

    public function destroy(Room $room)
    {}

    public function getRoomByUser($build_id)
    {
        $rooms = DB::table('rooms')
        ->where('user_id', auth()->user()->id)
        ->where('build_id', $build_id)
        ->get();
        return $this->getResponse200($rooms);
    }

    public function getAllRoomByUser()
    {
        $rooms = Room::with('build')
        ->where('user_id', auth()->user()->id)
        ->get();
        return $this->getResponse200($rooms);
    }

    public function changeStatus(Request $request, $id)
    {
        $history = new History();
        $history->user = auth()->user()->name;
        $history->state = $request->state;
        $history->room_id = $id;
        $history->save();
        $room = Room::find($id);

        $room->state = $request->state;

        $room->update();
        return $this->getResponse200($room);
    }
}
