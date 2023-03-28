<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentType;
use App\Models\User;
use App\Models\Mentor;

use App\Models\MentorScheduleSlot;
class MentorSchedule extends Model
{
    use HasFactory;
    protected $table = "mentor_schedules";
    protected $fillable = [
        "mentor_id","appointment_type_id","fee",'day','is_holiday','is_active'
    ];

    public $appends = ['locale_day'];

    public  function appointment_type()
    {
        return $this->hasOne(AppointmentType::class,'id','appointment_type_id');
    }
    public  function mentor_user()
    {
        return $this->hasOne(User::class,'id','mentor_id');
    }
    public  function mentor()
    {
        return $this->hasOne(Mentor::class,'user_id','mentor_id');
    }
    public function schedule_slots(){
        return $this->hasMany(MentorScheduleSlot::class,'schedule_id','id');
    }

    public function getDayAttribute($day)
    {
        switch ($day) {
            case 'Воскресенье':
                $day_name = 'sunday';
                break;
            case 'Понедельник':
                $day_name = 'monday';
                break;
            case 'Вторник':
                $day_name = 'tuesday';
                break;
            case 'Среда':
                $day_name = 'wednesday';
                break;
            case 'Четверг':
                $day_name = 'thursday';
                break;
            case 'Пятница':
                $day_name = 'friday';
                break;
            case 'Суббота':
                $day_name = 'saturday';
                break;
            default:
                $day_name = $day;
                break;
        }
        return $day_name;
    }

    public function getLocaleDayAttribute(){
        switch ($this->day){
            case 'sunday':
                $day_name = 'Воскресенье';
                break;
            case 'monday':
                $day_name = 'Понедельник';
                break;
            case 'tuesday':
                $day_name = 'Вторник';
                break;
            case 'wednesday':
                $day_name = 'Среда';
                break;
            case 'thursday':
                $day_name = 'Четверг';
                break;
            case 'friday':
                $day_name = 'Пятница';
                break;
            case 'saturday':
                $day_name = 'Суббота';
                break;
            default:
                $day_name = $this->day;
                break;
        }
        return $day_name;
    }
}
