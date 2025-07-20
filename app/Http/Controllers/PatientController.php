<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Http\Requests\StorepatientRequest;
use App\Http\Requests\UpdatepatientRequest;
use App\Models\Doctor;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::paginate(10);
        return view('admin.patients', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:patients,phone',
            'user_id' => 'nullable|exists:users,id', // Optional: Link to a registered user
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');
    }
}


