<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(['data' => $events], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::find($id);
        if ($event) {
            return response()->json(['message' => 'null', 'data' => $event], 200);
        } else {
            return response()->json(['message' => 'Event not found', 'data' => null], 400);
        }
    }

    public function listUsers(Event $event) {
        $users = $event->users;
        return response()->json(['message' => null, 'data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validateEvent($request);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $eventType = EventType::find($request->get('event_type_id'));

        if (!$eventType) {
            return response()->json(['message' => 'Event type does not exist.', 'data' => null], 400);
        }

        $event = Event::create([
            'event_name' => $request->get('event_name'),
            'event_detail' => $request->get('event_detail'),
            'event_type_id' => $request->get('event_type_id'),
        ]);

        return response()->json(['message' => 'Event created successfully.', 'data' => $event], 200);

    }

    public function validateEvent(Request $request) {
        return Validator::make($request->all(), [
            'event_name' => ['required', 'string', 'min:1', 'max:255'],
            'event_detail' => ['string', 'min:1', 'max:255'],
            'event_type_id' => ['required', 'numeric'],
        ]);
    }

}
