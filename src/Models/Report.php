<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Contracts\ReportContract;
//use App\Traits\ReportTrait;
use App\Traits\hasStatuses;


class Report extends Model //implements ReportContract
{

    static $searchable = ['task','details','user'];

    protected $fillable=[
        'task','details','user'
    ];

    protected $casts = [
    'created_at' => 'datetime:d-m-Y',
    'updated_at' => 'datetime:d-m-Y',
    'deleted_at' => 'datetime:d-m-Y',
    ];


    public function scopeLastDayReport($query)
    {
        return $query->whereDay('created_at',now()->subDay(1));
    }
    public function scopeTodayReport($query)
    {
        return $query->whereDay('created_at',now());
    }
    public function scopeThisMonthReport($query)
    {
        return $query->whereMonth('created_at',now()->month);
    }
    public function scopeLastMonthReport($query)
    {
        return $query->whereMonth('created_at',now()->subMonth(1));
    }
}
