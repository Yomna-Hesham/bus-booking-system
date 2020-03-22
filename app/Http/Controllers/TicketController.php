<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    private $name = "Tickets";

    public function index(){
        $tickets = Ticket::all();
        $headers = [
            'id' => 'ID',
            'user' => 'User',
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
            $trip = $ticket->trip->getStationsStringified();
            $bus = $ticket->trip->bus_id;
            $departureStation = explode(" , ", $trip)[0];
            $arrivalStation = array_reverse(explode(" , ", $trip))[0];

            $ticket = $ticket->toArray();
            $ticket['user'] = $user;
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
}
