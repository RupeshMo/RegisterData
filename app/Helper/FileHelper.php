<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

// Creating a new file helper to extract functions for reusability
class FileHelper {

    /**
     * 
     * Function documentation
     * @param \Illuminate\Http\Request $request
     * @param string @oldFileName
     * @return string|null
     * 
     */

     public static function handleProfilePhoto($request, $oldFileName = null) {
      $path = null;
  
      // Check if 'profilePhoto' is present in the request
      if ($request->filled('profilePhoto')) {
          $imageData = $request->input('profilePhoto');
          
          // Strip out the base64 part and decode the image data
          $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $imageData);
          $image = base64_decode($imageData);
  
          // Generate a unique name for the image
          $formattedUsername = preg_replace('/\s+/', '_', strtolower($request->name));
          $imageName = $formattedUsername . '_' . now()->format('Y-m-d_H-i-s') . '.jpg'; // Ensure the extension is correct
  
          // Define the path where the image will be saved
          $path = public_path('profile_photos/' . $imageName);
  
          // Create the directory if it doesn't exist
          if (!file_exists(public_path('profile_photos'))) {
              mkdir(public_path('profile_photos'), 0777, true);
          }
  
          // Save the image to the specified path
          file_put_contents($path, $image);
      } else {
          // If no profilePhoto in the request, keep the old file name
          $path = $oldFileName;
      }
  
      return 'profile_photos/' . $imageName; // return the relative path
  }
  

}