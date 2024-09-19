<?php

namespace App\Http\Controllers;

// app/Http/Controllers/TimeEntryController.php

use Carbon\Carbon;
use App\Models\TimeEntry;
use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    public function clockIn(Request $request)
    {
        $user = $request->user();  // Obtener el usuario autenticado

        // Crea un nuevo registro de entrada
        $entry = TimeEntry::create([
            'user_id' => $user->id,
            'clock_in' => now(),
        ]);

        return response()->json($entry, 201);
    }

    public function clockOut(Request $request, $entryId)
    {
        $user = $request->user();

        $entry = TimeEntry::where('user_id', $user->id)->where('id', $entryId)->firstOrFail();
        $entry->update([
            'clock_out' => now(),
        ]);

        return response()->json($entry);
    }

    public function getEntries(Request $request)
    {
        $user = $request->user();

        $entries = TimeEntry::where('user_id', $user->id)->get();

        return response()->json($entries);
    }

    // Método para verificar si ya hay Clock In hoy
    public function checkClockInToday(Request $request)
    {
        $user = $request->user();  // Obtener el usuario autenticado
        $today = Carbon::today();  // Fecha de hoy (inicio del día)

        // Obtener todas las entradas de hoy
        $entries = TimeEntry::where('user_id', $user->id)
            ->whereDate('clock_in', $today)
            ->orderBy('clock_in', 'asc')
            ->get();

        if ($entries->isNotEmpty()) {
            // Sumar el tiempo acumulado usando métodos de colección
            $accumulatedTime = $entries->sum(function ($entry) {
                return $entry->workedTimeInSeconds();
            });

            // Encontrar la última entrada para determinar si está clocked-in
            $lastEntry = $entries->last();
            $isClockedIn = is_null($lastEntry->clock_out);

            return response()->json([
                'clock_in_time' => $lastEntry->clock_in,  // La última hora de clock-in
                'accumulated_time' => $accumulatedTime,  // Tiempo acumulado total de hoy
                'is_clocked_in' => $isClockedIn,  // Si actualmente está clocked-in o no
                'entry_id' => $lastEntry->id,  // ID de la última entrada
            ]);
        }

        // Si no hay entradas hoy
        return response()->json([
            'clock_in_time' => null,  // La última hora de clock-in
            'accumulated_time' => 0,  // Tiempo acumulado total de hoy
            'is_clocked_in' => null,  // Si actualmente está clocked-in o no
            'entry_id' => null,  // ID de la última entrada
        ]);
    }
}
