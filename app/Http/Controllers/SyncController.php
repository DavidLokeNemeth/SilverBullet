<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SyncController extends Controller
{
    public function runSynchronisation()
    {
        set_time_limit(0);

        echo "In progress... <br/>";

        $page = 1;
        $lastPage = 1;


        $url = 'http://trialapi.craig.mtcdevserver.com/api/properties/?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug';
        do{
            $response = Http::get($url);

            $data = json_decode($response, true);

            if($data){
                foreach ($data['data'] as $property){
                    if(!PropertyType::find($property['property_type_id'])){
                        PropertyType::create($property['property_type']);
                    }

                    $oldproperty = Property::find($property['uuid']);
                    if($oldproperty){
                        if($oldproperty->updated_at< $property['updated_at']){
                            $oldproperty::update($property);
                        }
                    }else{
                        Property::create($property);
                    }
                }
                $lastPage = $data['last_page'];
                $url = html_entity_decode($data['next_page_url']);
            }


            echo $page."/".$lastPage." <br/>";
            sleep(1);
            $page++;

//            print_r($url.'<br/>');

        }while($page <= $lastPage);

        echo "Done";
    }
}
