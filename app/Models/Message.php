<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
       'read_at'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
