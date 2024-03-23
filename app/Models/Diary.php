<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
    
    public function diary_image()
    {
        return $this->hasOne(Diary_image::class,'diaries_id');
    }
    
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    
    protected $casts = [
        //'is_keep' => 'boolean',
        'start',
        'title',
        'comment',
        'color',
        ];
        
        
}
