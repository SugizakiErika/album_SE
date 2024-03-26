<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Diary_image extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function diaries()
    {
        return $this->belongsTo(Diary::class);
    }
    
    protected $fillable =[
        'name',
        'path',
        ];
}
