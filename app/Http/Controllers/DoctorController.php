<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        $doctors = Doctor::with('specialization')->get();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        $specializations = Specialization::all(); // Fetch specializations for the dropdown
        return view('doctors.create', compact('specializations'));
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'specialization_id' => 'required|exists:specializations,id',
            'contact' => 'nullable|string|max:15',
            'email' => 'required|email|unique:doctors,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the doctor
        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    /**
     * Show the form for editing the specified doctor.
     */
    public function edit(Doctor $doctor)
    {
        $specializations = Specialization::all();
        return view('doctors.edit', compact('doctor', 'specializations'));
    }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'specialization_id' => 'required|exists:specializations,id',
            'contact' => 'nullable|string|max:15',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the doctor
        $doctor->update($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
    public function showDoctorsBySpecialization($specialization)
    {
        // Find specialization
        $specializationModel = Specialization::where('name', $specialization)->first();
    
        if (!$specializationModel) {
            return back()->with('error', 'Specialization not found.');
        }
    
        // Fetch doctors for this specialization
        $doctors = $specializationModel->doctors;
    
        return view('doctors.index', compact('doctors', 'specializationModel'));
    }
    public function listBySpecialization($specialization)
{
    // Fetch doctors by specialization name
    $doctors = Doctor::whereHas('specialization', function ($query) use ($specialization) {
        $query->where('name', 'LIKE', "%$specialization%"); // Match specialization name
    })->get();

    if ($doctors->isEmpty()) {
        return view('doctors.index', ['doctors' => $doctors, 'message' => 'No doctors found for this specialization.']);
    }

    return view('doctors.index', compact('doctors'));
}

    

}