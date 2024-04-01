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
    
    public function diary_images()
    {
        return $this->hasMany(Diary_image::class,'diaries_id');
    }
    
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    
    /**
     * @return void
     */
    public static function booted(): void
    {
        static::deleting(function ($diary) {
            $diary->diary_images()->delete();
        });
    }
    
    // //  追記 (一緒に削除したいリレーション名を配列で指定)
    // protected $softCascade = ['diary_image'];
        
}
