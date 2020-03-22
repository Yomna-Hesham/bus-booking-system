<?php

namespace App\Http\Controllers;

use App\Bus;
use App\Station;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TripController extends Controller
{
    //
    private $name = "Trips";

    public function index(){
        $trips = Trip::with(['stations'])->get();
        $headers = ['id' => 'ID', 'time' => 'Time', 'bus_id' => 'Bus ID', 'stations' => 'Stations'];

        $body = [];
        foreach ($trips as $trip){
            $stations = $trip->getStationsStringified();
            $trip = $trip->toArray();
            $trip['stations'] = $stations;

            $body[] = $trip;
        }

        return view("dashboard.list")
            ->with(
                [
                    'name' => $this->name,
                    'data' =>
                        [
                            'headers' => $headers,
                            'body' => $body
                        ]
                ]
            );
    }

    public function create(){
        $stationsOptions = $this->getStationsForView();
        $busesOptions = $this->getBusesForView();

        $fields = [
            'bus_id' => ['label' => 'Bus', 'type' => 'select', 'options' => $busesOptions, 'multiple' => false],
            'time' => ['label' => 'Time', 'type' => 'date'],
            'stations' => ['label' => 'Stations', 'type' => 'select', 'options' => $stationsOptions, 'multiple' => true]
        ];

        return view('dashboard.edit')
            ->with([
                'name' => $this->name,
                'fields' => $fields
            ]);
    }

    public function store(Request $request){
        $trip = new Trip($request->all());
        $trip->save();

        $stationOrder = 1;
        foreach (array_reverse($request->stations) as $station){
            $trip->stations()->attach($station, ['order' => $stationOrder]);
            $stationOrder++;
        }

        return redirect()->route('trips.index');
    }

    public function edit($id){
        $trip = Trip::find($id);

        $stationsOptions = $this->getStationsForView();
        $busesOptions = $this->getBusesForView();

        $fields = [
            'bus_id' => ['label' => 'Bus', 'type' => 'select', 'options' => $busesOptions, 'multiple' => false],
            'time' => ['label' => 'Time', 'type' => 'date'],
            'stations' => ['label' => 'Stations', 'type' => 'select', 'options' => $stationsOptions, 'multiple' => true]
        ];

        return view('dashboard.edit')
            ->with(
                [
                    'name' => $this->name,
                    'fields' => $fields,
                    'data' => $trip
                ]
            );
    }

    public function update(Request $request, $id){
        $trip = Trip::find($id);
        $trip->fill($request->all());
        $trip->save();

        $trip->stations()->detach();

        $stationOrder = 1;
        foreach (array_reverse($request->stations) as $station){
            $trip->stations()->attach($station, ['order' => $stationOrder]);
            $stationOrder++;
        }

        return redirect()->route('trips.index');
    }

    public function destroy($id){
        $trip = Trip::find($id);
        $trip->stations()->detach();
        $trip->delete();

        return new Response(Response::HTTP_OK);
    }

    private function getStationsForView(){
        $stations = Station::all();
        $stationsOptions = [];
        foreach ($stations as $station){
            $stationsOptions[$station->id] = $station->name;
        }

        return $stationsOptions;
    }

    private function getBusesForView(){
        $buses = Bus::all();
        $busesOptions = [];
        foreach ($buses as $bus){
            if(!$this->isBusAssignedToTrip($bus))
                $busesOptions[$bus->id] = $bus->id." - ".$bus->license_num;
        }

        return $busesOptions;
    }

    private function isBusAssignedToTrip(Bus $bus){
        return !$bus->trips()->where('time', '>=', Carbon::now()->startOfDay())->get()->isEmpty();
    }
}
