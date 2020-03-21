<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusController extends Controller
{
    //

    public function index(){
        return view("dashboard.list")->with(['name' => "Buses",
            'data' => [
                'headers' => ['ID', 'License Number', 'Trip'],
                'body' => [
                    ["1", "ABC 123", "Cairo, Alex"],
                    ["2", "XYZ 897", "Cairo, Port Said, Sinai"]
                ]
            ]]);
    }
}
