<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class MessageController extends Controller
{
    public function sendMessage(Request $request, $doctorId)
{
    $request->validate([
        'message' => 'required|string',
        'pdf_file' => 'nullable|mimes:pdf|max:10240',
        'image_file' => 'nullable|image|max:5120',
    ]);

    // Find the doctor or handle error
    $doctor = Doctor::findOrFail($doctorId);

    // Process and save the message and uploaded files
    $pdfPath = $request->hasFile('pdf_file') ? $request->file('pdf_file')->store('uploads/pdfs') : null;
    $imagePath = $request->hasFile('image_file') ? $request->file('image_file')->store('uploads/images') : null;

    // Save or send the message (e.g., to a database or email)

    return back()->with('success', 'Message sent successfully.');
}

}
