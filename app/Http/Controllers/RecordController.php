<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Records; // Updated model name
use App\Models\FileRecord; // Updated model name
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Helper\FileHelper;
class RecordController extends Controller
{
    /**
     * Handle the record submission.
     */
    public function submitRecord(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'files.*' => 'nullable|file|mimes:jpg,png,pdf|max:10240', // Validate file uploads
            'profilePhoto' => 'nullable|string', // Accept base64 string for profile photo
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Create a new record in the database
        $record = Records::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'user_id' => $user->id, // Associate the record with the logged-in user
            'profilePhoto' => null, // Default value for profile_photo (to avoid NOT NULL violation)
        ]);

        // Handle profile photo upload from webcam (base64 string)
        if ($request->filled('profilePhoto')) {
          // Assuming handleProfilePhoto returns the file path
          $path = FileHelper::handleProfilePhoto($request);
          
          // Assuming you want to update a specific record, e.g., the current user's record
          $record = Records::find(auth()->id()); // You can adjust this to find the record you want to update
          
          if ($record) {
              $record->update(['profilePhoto' => $path]);
              Log::info("Profile photo uploaded: profile_photos/{$path}");
          } else {
              Log::error("Record not found for profile photo upload.");
          }
      }
      

        // Handle multiple file uploads (if any)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                // Save each file to 'uploads' directory in public storage
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                // Create a FileRecord entry for each uploaded file
                FileRecord::create([
                    'record_id' => $record->id,
                    'file_path' => $filePath,
                ]);

                Log::info("File uploaded: " . $filePath);
            }
        }

        return redirect()->back()->with('success', 'Record uploaded successfully!');
    }
}
