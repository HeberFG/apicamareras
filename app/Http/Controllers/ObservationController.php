<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObservationController extends Controller
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
        $observations = Observation::orderBy('text', 'asc')->get();
        return $this->getResponse200($observations);
    }

    public function create()
    {}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'evidencies' => 'required',
            'room_id' => 'required'
        ]);
        if (!$validator->fails()) {
            DB::beginTransaction();
            try {
                $observation = new Observation();
                $observation->text = $request->text;
                $observation->evidencies = $request->evidencies;
                $observation->room_id = $request->room_id;
                $observation->save();
                DB::commit();

                return $this->getResponse201(
                    "Observation",
                    "created",
                    $observation
                );
            } catch (Exception $err) {
                DB::rollBack();
                return $this->getResponse500([$err->getMessage()]);
            }
        } else {
            return $this->getResponse500([$validator->errors()]);
        }
    }

    public function show($id)
    {
        
        $observation = Observation::find($id);
      

        return $this->getResponse200($observation);
    }

    public function edit(Observation $observation)
    {
     }

    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'evidences' => 'required',
            'user_id' => 'required'
        ]);
        if (!$validator->fails()) {
            DB::beginTransaction();
            try {
                $observation = Observation::with("observation", 'user')->where('id', $id)->first();
                if ($observation) {
                    if ($observation->user_id == auth()->user()->id) { 
                        $observation->text = $request->text;
                        $observation->evidences = $request->evidences;
                        $observation->update();

                        $observation = Observation::with("observation", 'user')->where('id', $id)->first();

                        DB::commit();

                        return $this->getResponse201(
                            "Observation",
                            "updated",
                            $observation
                        );
                    } else {
                        return $this->getResponse403();
                    }
                } else {
                    return $this->getResponse404();
                }
            } catch (Exception $err) {
                DB::rollBack();
                return $this->getResponse500([$err->getMessage()]);
            }
        } else {
            return $this->getResponse500([$validator->errors()]);
        }
    }

    public function destroy(Observation $observation)
    {
        
    }
}
