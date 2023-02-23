<?php

namespace App\Traits;



trait Reportable
{
    protected static function boot()
    {
        parent::boot();

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