<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordSignature;

class Menu extends Model 
{
    use RecordSignature, SoftDeletes;

    public function children()
    {
        return $this->hasMany(\App\Models\Menu::class, 'parent_id')
            ->with('children');
    }
}