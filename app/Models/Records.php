<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * Get the files associated with the record.
     */
    public function files()
    {
        return $this->hasMany(RecordFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
