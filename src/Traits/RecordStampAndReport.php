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

            static::created(function ($model) 
            {
                $this->reportDetails('Created');
            });

            static::updated(function ($model) 
            {
                $this->reportDetails('Updated');
            });

            static::restored(function ($model) 
            {
                $this->reportDetails('Restored');
            });

            static::deleted(function ($model) 
            {
                $this->reportDetails('Deleted');
            });

            static::forceDeleted(function ($model) 
            {
                $this->reportDetails('Forcely Deleted');
            });
        

    }

    public function makeModelDetails($model)
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

    public function reportDetails($model ,$task)
    {
        Report::create([
            'task'=>"{{ model }}  $task",
            'user'=>auth()->name,
            'details'=>$this->makeModelDetails($model),
            'created_at'=>now()->timezone(config('dashboard.time_zone'))
        ]);
    }

}