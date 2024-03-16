<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Diary_image extends Model
{
    use HasFactory;
    
    public function diaries()
    {
        return $this->belongsTo(Diary::class);
    }
    
    protected $fillable =[
        'name',
        'path',
        ];
}
