<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileRecord extends Model // Matches 'file_records' table
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'file_path',
    ];

    /**
     * Define table name explicitly if needed.
     */
    protected $table = 'file_records';

    /**
     * Get the record that owns this file.
     */
    public function record()
    {
        return $this->belongsTo(Records::class); // Relationship with Records model
    }
}
