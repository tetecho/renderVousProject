<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Users
        $numberPatient = User::where('role', 'patient')->count();
        $numberMedecin = User::where('role', 'medecin')->count();

        // Rendez-vous stats
        $totalRdv = RendezVous::count();
        $rdvConfirmed = RendezVous::where('statut', 'confirme')->count();
        $rdvPending = RendezVous::where('statut', 'en_attente')->count();
        $rdvCancelled = RendezVous::where('statut', 'annule')->count();

        // Today's appointments
        $todayRdv = RendezVous::whereDate('date_heure', Carbon::today())->count();

        // Upcoming appointments
        $upcomingRdv = RendezVous::where('date_heure', '>', Carbon::now())
            ->orderBy('date_heure', 'asc')
            ->take(5)
            ->get();

        // Recent appointments
        $recentRdv = RendezVous::with(['patient', 'medecin', 'service'])
            ->latest()
            ->take(5)
            ->get();
        $months = [];
        $appointmentsCount = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('M Y'); // e.g., "Jan 2025"

            $count = RendezVous::whereYear('date_heure', $month->year)
                ->whereMonth('date_heure', $month->month)
                ->count();

            $appointmentsCount[] = $count;
        }

        return view('dashboard', compact(
            'numberPatient',
            'numberMedecin',
            'totalRdv',
            'rdvConfirmed',
            'rdvPending',
            'rdvCancelled',
            'todayRdv',
            'upcomingRdv',
            'recentRdv',
            'months',           // array of month labels
            'appointmentsCount' // array of counts
        ));
    }
}
