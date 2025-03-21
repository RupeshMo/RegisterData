<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'file_path',
    ];

    /**
     * Get the record that owns the file.
     */
    public function record()
    {
        return $this->belongsTo(Record::class);
    }
}
