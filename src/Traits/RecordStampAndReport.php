<?php

namespace App\Traits;
use App\Models\Report;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Traits\ForwardsCalls;


trait RecordStampAndReport
{
    protected static function boot()
    {
        /**
         * Boot the parent Model.
         */
        parent::boot();

            /**
             * Apply logic while creating a new instance of parent model.
             */
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
            /**
             * Apply logic while updating a new instance of parent model.
             */

            static::updating(function ($model)
            {
                $model->updated_by = auth()->user()->id;
                $model->updated_at = now()->timezone(config('dashboard.time_zone'));
            });

            /**
             * Apply logic while deleting a new instance of parent model.
             */

            static::deleting(function ($model)
            {
                $model->deleted_by = auth()->user()->id;
            });

            /**
             * Apply logic after a new instance of parent model is created .
             */

            static::created(function ($model)
            {
                static::reportDetails($model,'Created');
            });

            /**
             * Apply logic after a new instance of parent model is updated .
             */

            static::updated(function ($model)
            {
                static::reportDetails($model,'Updated');
            });
            /**
             * Apply logic after an instance of parent model is restored .
             */
            static::restored(function ($model)
            {
                static::reportDetails($model,'Restored');
            });

            /**
             * Apply logic while after an instance of parent model is deleted .
             */

            static::deleted(function ($model)
            {
                static::reportDetails($model,'Deleted');
            });

            /**
             * Apply logic after an instance of parent model is forcefully deleted .
             */

            static::forceDeleted(function ($model)
            {
                static::reportDetails($model,'Forcefully Deleted');
            });


    }
    /**
     * generates a fresh detail of the parent instance to be reported .
     */
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
    /**
     * generate a new report instance and save it to database.
     */
    public static function reportDetails($model ,$task)
    {
        Report::create([
            'task'=>class_basename(get_class($model))." ".$task,
            'user'=>auth()->user()->name,
            'details'=>static::makeModelDetails($model),
            'created_at'=>now()->timezone(config('dashboard.time_zone'))
        ]);
    }
    /**
     * generate methods at runtime.
     */
    use ForwardsCalls;

    public static function addDynamicMethod($methodName, $methodClosure)
    {
        // Define the dynamic method
        $method = function () use ($methodClosure) {
            return $methodClosure(...func_get_args());
        };

        // Add the method to the model
        static::macro($methodName, $method);
    }


}
