<?php

namespace App\Http\Controllers;

use App\Bus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusController extends Controller
{
    //

    public function index(){
        $buses = Bus::with(['trips'])->get();
        $headers = ['id' => 'ID', 'license_num' => 'License Number','trips' => 'Trip'];

        $body = [];
        foreach ($buses as $bus){
            $bus = $bus->toArray();
            $bus['trips'] = "-";

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
        $fields = ['license_num' => 'License Number'];

        return view('dashboard.edit')
            ->with(
                [
                    'name' => 'Buses',
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

        $fields = ['license_num' => 'License Number'];

        return view('dashboard.edit')
            ->with(
                [
                    'name' => 'Buses',
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
