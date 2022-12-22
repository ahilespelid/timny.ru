<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\Product;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AppointmentType;

/**
 * @method static find(mixed $book_appointment_id)
 */
class BookAppointment extends Model
{
    use HasFactory;

    protected $table = "book_appointment";
    protected $fillable = [
        'mentee_id','mentor_id','date','time','payment','is_paid','payment_id','questions','file','file_type','appointment_type_string'
        ,'appointment_type_id','payment_status_code','payment_response_msg','payment_order_ref','refund','appointment_status','notes_consultant'
        ,'file_consultant','filetype_consultant' , 'is_archieve'
    ];
    public function mentee(){
       return $this->hasOne(User::class,'id','mentee_id');
    }
    public function mentor(){
        return $this->hasOne(User::class,'id','mentor_id');
    }
    public function mentee_base(){
        return $this->hasOne(User::class,'id','mentee_id')->select(['id', 'first_name', 'last_name', 'email', 'phone']);
    }
    public function mentor_base(){
        return $this->hasOne(User::class,'id','mentor_id')->select(['id', 'first_name', 'last_name', 'email', 'phone']);
    }
    public function appointmentType(){
        return $this->hasOne(AppointmentType::class,'id','appointment_type_id');
    }
    public function rating(){
        return $this->belongsTo(Rating::class,'id','appointment_id');
    }

    public function getTimeHumanAttribute()
    {
        return $this->tim;
    }

}
