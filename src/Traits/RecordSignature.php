<?php

namespace App\Traits;



trait RecordSignature
{
    protected static function boot()
    {
        parent::boot();

            static::creating(function ($model) 
            {
                $model->created_by = auth()->id;
                $model->created_at = now()->timezone(config('dashboard.time_zone'));
            });

            static::updating(function ($model) 
            {
                $model->updated_by = auth()->id;
                $model->updated_at = now()->timezone(config('dashboard.time_zone'));
            });

            static::deleting(function ($model) 
            {
                $model->deleted_by = auth()->id;
            });
        

    }

}