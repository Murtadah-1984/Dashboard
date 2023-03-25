<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordStampAndReport;

class Menu extends Model
{
    //use RecordStampAndReport;
    use SoftDeletes;

    protected $fillable=[
        "title", "route", "policy", "class", "parent_id", "order"
    ];

    static $searchable=[
        "title", "route", "policy", "class", "parent_id", "order"
    ];
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public static function generate($model, $table)
    {
        self::firstOrCreate([
            'title' => "{$model}s",
            'route'=>"{$table}.index",
            'policy'=>"browse_{$table}",
            'class'=>'fas fa-clone',
            'order'=> 0
        ]);
    }
}
