<?php

// File.php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'filename'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}