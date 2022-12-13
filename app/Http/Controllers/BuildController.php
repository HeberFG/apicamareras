<?php

namespace App\Http\Controllers;

use App\Models\Build;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BuildController extends Controller
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
        $buildings = Build::orderBy('name', 'asc')->get();
        return $this->getResponse200($buildings);
    }

    public function create()
    {}

    public function store(Request $request)
    {
        $build = new Build();
        $build->name = $request->name;
        $build->save();
        return $this->getResponse201("Build", "Created", $build);
    }

    public function show($id)
    {
        $build = Build::find($id);
 
        return $this->getResponse200($build);
    }

    public function edit(Build $build)
    {}

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()){
            $reponse = $this->response();
            $build = Build::find($id);
    
            DB::beginTransaction();
            try {
                if ($build) {
                    $build->name = $request->name;
                    $build->update();
                    return $this->getResponse201("Build", "Updated", $build);
                } else {
                    $reponse["message"] = "Not found";
                }
    
                DB::commit();
            } catch (Exception $e) {
                return $e;
                $response["message"] = "Rollback transaction";
                DB::rollBack();
            }
        }else{
            return $this->getResponse500([$validator->errors()]);
        }
       
    }

    public function destroy(Build $build)
    {}

    public function getBuildByUser(){
        $buildings = DB::table('rooms')
        ->join('buildings', 'rooms.build_id', '=', 'buildings.id')
        ->where('rooms.user_id', auth()->user()->id)
        ->select('buildings.*')
        ->groupBy('buildings.id')
        ->get();
        return $this->getResponse200($buildings);
    }
}
