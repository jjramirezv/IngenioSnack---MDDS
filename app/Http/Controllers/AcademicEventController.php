<?php

namespace App\Http\Controllers;

use App\Models\AcademicEvent;
use Illuminate\Http\Request;

class AcademicEventController extends Controller
{
    public function index()
    {
        // Trae los eventos ordenados por fecha de inicio
        $events = AcademicEvent::orderBy('start_date', 'asc')->get();
        return view('seller.events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        AcademicEvent::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Evento registrado en el calendario.');
    }

    public function destroy(AcademicEvent $event)
    {
        $event->delete();
        return back()->with('success', 'Evento eliminado del calendario.');
    }
}