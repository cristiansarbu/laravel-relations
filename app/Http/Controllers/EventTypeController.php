<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
{
    public function index() {
        $eventTypes = EventType::all();
        return response()->json(['data' => $eventTypes],200);
    }
    public function listEvents(EventType $type) {
        $events = $type->events;
        return response()->json(['message' => null, 'data' => $events], 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $eventType = EventType::create([
            'description' => $request->get('description'),
        ]);

        return response()->json(['message' => 'Event type created successfully.', 'data' => $eventType]);
    }
}
