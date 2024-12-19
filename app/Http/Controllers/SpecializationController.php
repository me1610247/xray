<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\Doctor;

class SpecializationController extends Controller
{
    /**
     * Display a listing of all specializations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $specializations = Specialization::withCount('doctors')->get(); // Counting related doctors
    
        return view('specializations.index', compact('specializations'));
    }
    public function showDoctors($id)
{
    $specialization = Specialization::findOrFail($id);
    $doctors = Doctor::where('specialization_id', $id)->get();
    return view('doctors.index', compact('doctors', 'specialization'));
}
}
