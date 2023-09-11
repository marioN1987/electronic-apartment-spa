<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Floor;
use App\Models\State;
use App\Http\Requests\CreateHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use Illuminate\Support\Str;

class HousesController extends Controller
{   
    public function getStates() {
        return response()->json([
            'states' => State::all()
        ]);
    }

    public function list() {
        $all = House::all();

        $housesArr = $all->map(function($house) {
            return [
                'id' => $house->id,
                'state' => $house->state->name,
                'floors' => $house->floors
            ];
        });

        return response()->json([
            'houses' => $housesArr
        ]);
    }

    public function houseIdExists($id) {
        //check if id exists in table
        $exists = House::where('id', $id)->exists();

        if (!$exists) {
            abort(404);
        }
    }

    public function getHouseById($id) {

        $this->houseIdExists($id);

        $house = House::find($id);

        return response()->json([
            'house' => [
                'selected_state_name' => $house->state->name,
                'selected_state_id' => $house->state_id,
                'floors' => $house->floors,
                'states' => State::all()
            ],

        ]);
    }

    public function update(UpdateHouseRequest $request) {
        $validated = $request->validated();
        
        House::where('id', $validated['house_id'])
                ->update(['state_id' => $validated['house_state']]);
        
        foreach($validated['floors'] as $floorArr) {
            //if floor id exists means there is floor and update, otherwise create new one
            $floorId = isset($floorArr['id']) ? $floorArr['id'] : null;

            if ($floorId) {
                Floor::where([
                    ['house_id', $validated['house_id']], 
                    ['id', $floorId]
                ])->update([
                    'apartments_per_floor' => $floorArr['apartments_no'], 'entrances' => $floorArr['entrances']
                ]);
            //otherwise create new one
            } else {
                $floor = new Floor();
                $floor->house_id = $validated['house_id'];
                $floor->apartments_per_floor = $floorArr['apartments_no'];
                $floor->entrances = $floorArr['entrances'];
    
                if (!$floor->save()) {
                    return response('', 302);
                }
            }
        }
        
        return response('', 200);
    }

    public function create(CreateHouseRequest $request) {
        $validated = $request->validated();
        
        $house = new House();
        $house->state_id = $validated['house_state'];
        
        if(!$house->save()) {
            return response('', 302);
        }

        foreach($validated['floors'] as $key => $subAarr) {
            $floor = new Floor();
            $floor->house_id = $house->id;
            $floor->apartments_per_floor = $subAarr['apartments_no'];
            $floor->entrances = $subAarr['entrances'];

            if (!$floor->save()) {
                return response('', 302);
            }
        }
        
        return response('', 200);
    }

    public function delete($id) {
        $this->houseIdExists($id);

        House::where('id', $id)->delete();

        return response('', 200);
    }
}
