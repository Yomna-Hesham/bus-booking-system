<?php

namespace App\Http\Controllers;

use App\Bus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    //

    private $name = "Buses";
    private $validationRules = [
        'license_num' => 'required'
    ];

    public function index(){
        $buses = Bus::with(['trips'])->get();
        $headers = ['id' => 'ID', 'license_num' => 'License Number','trips' => 'Trip'];

        $body = [];
        foreach ($buses as $bus){
            $trip = $bus->trips()->where('time', ">=", Carbon::now()->startOfDay())->first();
            $bus = $bus->toArray();
            $bus['trips'] = isset($trip) ? $trip->getStationsStringified() : "-";

            $body[] = $bus;
        }

        return view("dashboard.list")
            ->with(
                [
                    'name' => "Buses",
                    'data' =>
                        [
                            'headers' => $headers,
                            'body' => $body
                        ]
                ]
            );
    }

    public function create(){
        $fields = [
            'license_num' => ['label' => 'License Number', 'type' => 'text']
        ];

        return view('dashboard.edit')
            ->with(
                [
                    'name' => $this->name,
                    'fields' => $fields
                ]
            );
    }

    public function store(Request $request){
        $request->validate($this->validationRules);

        $bus = new Bus($request->all());
        $bus->save();

        return redirect()->route('buses.index');
    }

    public function edit($id){
        $bus = Bus::find($id);

        $fields = [
            'license_num' => ['label' => 'License Number', 'type' => 'text']
        ];

        return view('dashboard.edit')
            ->with(
                [
                    'name' => $this->name,
                    'fields' => $fields,
                    'data' => $bus->toArray()
                ]
            );
    }

    public function update(Request $request, $id){
        $request->validate($this->validationRules);

        $bus = Bus::find($id);

        $bus->fill($request->all());

        $bus->save();

        return redirect()->route('buses.index');
    }

    public function destroy($id){
        DB::beginTransaction();
        $bus = Bus::find($id);

        foreach ($bus->trips as $trip){
            if($trip->time < Carbon::now()->startOfDay()){
                $trip->bus()->dissociate();
                $trip->save();
            }else{
                return new Response("There an upcoming trip ".$trip->getStationsStringified()." associated with this bus, please change its bus before deletion", Response::HTTP_CONFLICT);
            }
        }

        $bus->delete();

        DB::commit();

        return new Response("Deleted", Response::HTTP_OK);
    }
}
