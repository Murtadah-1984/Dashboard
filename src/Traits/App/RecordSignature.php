<?php

namespace App\Traits\App;
use Carbon\Carbon;


trait RecordSignature
{
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {

            $model->updated_by = \Auth::User()->id;
            $model->updated_at = Carbon::now()->timezone(config('dashboard.time_zone'));
        });

        static::creating(function ($model) {

            if(is_null(\Auth::User())){
                $model->created_by = 1;
            }else{
                $model->created_by = \Auth::User()->id;
            }

            
            $model->created_at = Carbon::now()->timezone(config('dashboard.time_zone'));
        });

        static::deleting(function ($model) {
            $model->deleted_by = \Auth::User()->id;
        });
        //etc

    }

}