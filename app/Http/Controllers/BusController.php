<?php

namespace App\Http\Controllers;

use App\Bus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusController extends Controller
{
    //

    private $name = "Buses";

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
        $bus = Bus::find($id);

        $bus->fill($request->all());

        $bus->save();

        return redirect()->route('buses.index');
    }

    public function destroy($id){
        Bus::destroy($id);

        return new Response(Response::HTTP_OK);
    }
}
