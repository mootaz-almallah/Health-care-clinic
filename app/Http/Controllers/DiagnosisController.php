<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Symptom;

class DiagnosisController extends Controller
{
    public function index()
    {
        
        $symptoms = Symptom::orderBy('display_name')->get();
        return view('diagnosis.index', compact('symptoms'));
    }
    
    public function predict(Request $request)
    {
        $request->validate([
            'symptoms' => 'required|array|min:1',
            'symptoms.*' => 'string'
        ]);

        try {
            // Call the Flask API (make sure it's running)
            $response = Http::post('http://localhost:5000/predict', [
                'symptoms' => $request->symptoms
            ]);
            
            if ($response->successful()) {
                $result = $response->json();
                $selectedSymptoms = Symptom::whereIn('symptom_key', $request->symptoms)
                    ->orderBy('display_name')
                    ->get();
                    
                return view('diagnosis.result', compact('result', 'selectedSymptoms'));
            } else {
                return back()->with('error', 'API request failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to connect to API: ' . $e->getMessage());
        }
    }
}