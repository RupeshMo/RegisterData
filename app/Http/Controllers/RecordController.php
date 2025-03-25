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

    public function show()
    {
        // Assuming you want to pass user information to the view
        $user = Auth::user(); // Get the currently authenticated user

        // You can also define any other data you want to pass
        $states = [
            1 => [
                'name' => 'Maharashtra',
                'districts' => ['Mumbai', 'Pune', 'Nagpur', 'Nashik', 'Thane', 'Aurangabad', 'Solapur']
            ],
            2 => [
                'name' => 'Karnataka',
                'districts' => ['Bengaluru', 'Mysuru', 'Mangaluru', 'Hubli', 'Belagavi', 'Davanagere', 'Ballari']
            ],
            3 => [
                'name' => 'Tamil Nadu',
                'districts' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli', 'Thoothukudi']
            ],
            4 => [
                'name' => 'Gujarat',
                'districts' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Gandhinagar', 'Anand', 'Bhavnagar']
            ],
            5 => [
                'name' => 'Rajasthan',
                'districts' => ['Jaipur', 'Udaipur', 'Jodhpur', 'Ajmer', 'Bikaner', 'Kota', 'Sikar']
            ],
            6 => [
                'name' => 'West Bengal',
                'districts' => ['Kolkata', 'Siliguri', 'Darjeeling', 'Howrah', 'Murshidabad', 'Nadia']
            ],
            7 => [
                'name' => 'Uttar Pradesh',
                'districts' => ['Lucknow', 'Kanpur', 'Agra', 'Varanasi', 'Ghaziabad', 'Noida']
            ],
            8 => [
                'name' => 'Punjab',
                'districts' => ['Chandigarh', 'Amritsar', 'Ludhiana', 'Patiala', 'Jalandhar']
            ],
            9 => [
                'name' => 'Haryana',
                'districts' => ['Gurugram (Gurgaon)', 'Faridabad', 'Ambala']
            ],
            10 => [
                'name' => 'Delhi',
                // Delhi is a union territory and has districts like:
                // New Delhi, North Delhi, South Delhi, East Delhi, West Delhi, etc.
                // For simplicity, we will just mention it as a single entity.
                // You can expand this if you want to list all districts explicitly.
                "districts" => ['New Delhi','North Delhi','South Delhi','East Delhi','West Delhi','North East Delhi']
            ]
        ];
        

        return view('registerdata', compact('user', 'states')); // Pass data to the view
    }
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
            'profilePhoto' => 'string', // Accept base64 string for profile photo
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Create a new record in the database
        $record = Records::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'profilePhoto' => null, // Default value for profile_photo (to avoid NOT NULL violation)
        ]);

        // Handle profile photo upload from webcam (base64 string)
        if ($request->filled('profilePhoto')) {
          // Assuming handleProfilePhoto returns the file path
          $path = FileHelper::handleProfilePhoto($request);
          Log::info("Path to be saved: {$path}");

          // Assuming you want to update a specific record, e.g., the current user's record
          
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
