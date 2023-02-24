<?php

namespace App\Traits;
use App\Models\Report;
use Schema;

trait RecordStampAndReport
{
    protected static function boot()
    {
        parent::boot();

            static::creating(function ($model) 
            {
                if (!app()->runningInConsole())
                {
                    $model->created_by = auth()->user()->id;
                }else{
                    $model->created_by = 1;
                }
                $model->created_at = now()->timezone(config('dashboard.time_zone'));
            });

            static::updating(function ($model) 
            {
                $model->updated_by = auth()->user()->id;
                $model->updated_at = now()->timezone(config('dashboard.time_zone'));
            });

            static::deleting(function ($model) 
            {
                $model->deleted_by = auth()->user()->id;
            });

            static::created(function ($model) 
            {
                static::reportDetails($model,'Created');
            });

            static::updated(function ($model) 
            {
                static::reportDetails($model,'Updated');
            });

            static::restored(function ($model) 
            {
                static::reportDetails($model,'Restored');
            });

            static::deleted(function ($model) 
            {
                static::reportDetails($model,'Deleted');
            });

            static::forceDeleted(function ($model) 
            {
                static::reportDetails($model,'Forcely Deleted');
            });
        

    }

    public static function makeModelDetails($model)
    {
        $hiddenColumns=config('dashboard.hiddenColumns');
        $columns=array_diff(Schema::getColumnListing($model->getTable()),$hiddenColumns);
        $details="";
        foreach($columns as $columnName)
        {
            $details.=$model->$columnName."\n";
        }
        return $details;
    }

    public static function reportDetails($model ,$task)
    {
        Report::create([
            'task'=>class_basename(get_class($model))." ".$task,
            'user'=>auth()->user()->name,
            'details'=>static::makeModelDetails($model),
            'created_at'=>now()->timezone(config('dashboard.time_zone'))
        ]);
    }

}