<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Records extends Model // Matches 'records' table
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'profilePhoto'
    ];

    /**
     * Get the files associated with this record.
     */
    public function files()
    {
        return $this->hasMany(FileRecord::class); // Relationship with FileRecord model
    }
}
