<?php

namespace App\Http\Controllers;

use App\Station;
use App\Ticket;
use App\Trip;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    //
    private $name = "Tickets";
    private $validationRules = [
        'name' => 'required',
        'phone' => 'required',
        'from' => 'required',
        'to' => 'required',
        'trip_id' => 'required|numeric'
    ];

    public function index(Request $request){
        $errors = $request->session()->get("errors");
        if(!empty($errors)){
            return new Response($errors->all(), Response::HTTP_NOT_FOUND);
        }

        $tickets = Ticket::all();
        $headers = [
            'id' => 'ID',
            'user' => 'User',
            'phone' => 'Phone',
            'trip_id' => 'Trip ID',
            'trip' => 'Trip',
            'departureStation' => "Departure",
            'arrivalStation' => "Arrival",
            'bus' => "Bus ID",
            'seat' => "Seat",
            'price' => "Price"
        ];

        $body = [];
        foreach ($tickets as $ticket){
            $user = $ticket->user->name;
            $phone = $ticket->user->phone;
            $trip = empty($ticket->trip) ? "DELETED TRIP" : $ticket->trip->getStationsStringified();
            $bus = empty($ticket->trip) ? "-" : $ticket->trip->bus_id;
            $departureStation = $ticket->departureStation->name;
            $arrivalStation = $ticket->arrivalStation->name;

            $ticket = $ticket->toArray();
            $ticket['user'] = $user;
            $ticket['phone'] = $phone;
            $ticket['trip'] = $trip;
            $ticket['bus'] = $bus;
            $ticket['departureStation'] = $departureStation;
            $ticket['arrivalStation'] = $arrivalStation;

            $body[] = $ticket;
        }

        return view("dashboard.list")
            ->with(
                [
                    'name' => $this->name,
                    'enableEdit' => false,
                    'data' =>
                        [
                            'headers' => $headers,
                            'body' => $body
                        ]
                ]
            );

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), $this->validationRules);
        if($validator->fails()){
            return new Response($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();

        $user = new User($request->all());
        $user->save();

        $from = Station::where('name', $request->from)->first();
        if(empty($from)){
            return new Response("No such station ".$request->from,Response::HTTP_NOT_FOUND);
        }

        $to = Station::where('name', $request->to)->first();
        if(empty($to)){
            return new Response("No such station ".$request->to,Response::HTTP_NOT_FOUND);
        }

        $trip = Trip::with('tickets')->find($request->trip_id);
        if(empty($trip)){
            return new Response("No such trip ".$request->trip_id,Response::HTTP_NOT_FOUND);
        }

        $reservedSeats = [];
        foreach ($trip->tickets as $ticket){
            if($ticket->departureStation->getStationOrderInTrip($trip) <= $from->getStationOrderInTrip($trip)){
                if($ticket->arrivalStation->getStationOrderInTrip($trip) >= $from->getStationOrderInTrip($trip)){
                    $reservedSeats[] = $ticket->seat;
                }
            }
        }
        sort($reservedSeats);
        $seat = 0;
        for($i = 0; $i < sizeof($reservedSeats); $i++){
            if($i > 0 && $reservedSeats[$i] - $reservedSeats[$i - 1] > 1){
                $seat = $reservedSeats[$i - 1] + 1;
                break;
            }
        }
        if($seat == 0){
            $seat = sizeof($reservedSeats) > 0 ? $reservedSeats[sizeof($reservedSeats) - 1] + 1 : 1;
        }

        if($seat > 12){
            return new Response("No available seats ".$request->to,Response::HTTP_NOT_FOUND);
        }

        $ticket = new Ticket();
        $ticket->seat = $seat;
        $ticket->price = 50;
        $ticket->user()->associate($user);
        $ticket->trip()->associate($trip);
        $ticket->departureStation()->associate($from);
        $ticket->arrivalStation()->associate($to);
        $ticket->save();

        DB::commit();

        return [
            "Ticket ID" => $ticket->id,
            "User"  => $user->name,
            "Phone"  => $user->phone,
            "Trip ID" => $trip->id,
            "Trip Stations" => $trip->getStationsStringified(),
            "Departure Station" => $ticket->departureStation->name,
            "Arrival Station" => $ticket->arrivalStation->name,
            "Bus ID" => $trip->bus_id,
            "Seat" => $seat,
            "Price" => $ticket->price
        ];
    }
}
