<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Diary extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
    
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
    
    //  追記 (一緒に削除したいリレーション名を配列で指定)
    protected $softCascade = ['diary_image'];
        
}
