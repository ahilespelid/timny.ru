<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MentorSchedule;
class MentorScheduleSlot extends Model
{
    use HasFactory;
    protected $table = "mentor_schedule_slots";
    public $timestamps = false;
    protected $fillable = [
        "schedule_id","start_time","end_time",'slot_duration','is_active','shift_id'
    ];


    public function getStartTimeAttribute($time)
    {
        return $time ? (Carbon::createFromFormat('h:i a', $time))->format('H:i') : '-';
    }
    public function getEndTimeAttribute($time)
    {
        return $time ? (Carbon::createFromFormat('h:i a', $time))->format('H:i') : '-';
    }

    public function schedule(){
        return $this->belongsTo(MentorSchedule::class,'schedule_id','id');
    }

}
