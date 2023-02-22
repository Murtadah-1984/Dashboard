<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\App\RecordSignature;

class Menu extends Model 
{
    use RecordSignature, SoftDeletes;
   
    protected $fillable=[
        "title", "route", "model", "class", "parent_id", "order"
    ];
    public function children()
    {
        return $this->hasMany(\App\Models\Menu::class, 'parent_id')
            ->with('children');
    }

    public static function generate($model)
    {
        self::firstOrCreate([
            'title' => "{{$model}}s",
            'route'=>"{{$model}}.index",
            'model'=>"App\Models\{{$model}}",
            'class'=>'fas fa-clone',
            'order'=> 0
        ]);
    }
}