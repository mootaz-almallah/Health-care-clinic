<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialization;

use App\Models\Patient;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get random featured doctors (10)
        $featuredDoctors = Doctor::where('status', 'approved')
            ->with('specialization')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        // Get all specializations for search
        $specializations = Specialization::orderBy('name')->get();

        // Statistics
        $stats = [
            'doctors_count' => Doctor::where('status', 'approved')->count(),
            'governorates' => Doctor::where('status', 'approved')->distinct('governorate')->count(),
            'happy_patients' => Patient::count(),
            'support_available' => '24/24'
        ];

        return view('public.welcome', compact('featuredDoctors', 'specializations', 'stats'));
    }
}
