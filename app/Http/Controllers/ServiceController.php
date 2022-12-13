<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ServiceController extends Controller
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
        $services = Service::orderBy('name', 'asc')->get();
        return $this->getResponse200($services);
    }

  
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $service = new Service();
        $service->name = $request->name;
        $service->save();
        return $this->getResponse201("Service", "Created", $service);
    }

  
    public function show($id)
    {
        $service = Service::find($id);
     

        return $this->getResponse200($service);
    }

   
    public function edit(Service $service)
    {
        
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()){
            $reponse = $this->response();
            $service = Service::find($id);
    
            DB::beginTransaction();
            try {
                if ($service) {
                    $service->name = $request->name;
                    $service->update();
                    return $this->getResponse201("Service", "Updated", $service);
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

    public function destroy(Service $service)
    {
      
    }
}
