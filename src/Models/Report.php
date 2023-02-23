<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Contracts\ReportContract;
//use App\Traits\ReportTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordSignature; 
use App\Traits\Reportable;
use App\Traits\hasStatuses; 


class Report extends Model //implements ReportContract
{
     
    //use ReportTrait;
    use RecordSignature, Reportable, SoftDeletes , hasStatuses;

    protected $fillable=[
        
    ];

    protected $casts = [
    'created_at' => 'datetime:d-m-Y',
    'updated_at' => 'datetime:d-m-Y',
    'deleted_at' => 'datetime:d-m-Y',
    ];
}
