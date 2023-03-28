<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\Product;
use Bavix\Wallet\Traits\HasWallet;
use Carbon\Carbon;
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

    protected $appends = ["receipt_url"];

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
    public function transaction(){
        return $this->hasOne(NewTransaction::class);
    }
    public function operation_id(){
        return $this->hasOne(NewTransaction::class)->select(['id', 'operation_id']);
    }
    public function getReceiptUrlAttribute()
    {
        if($this->transaction() != null && isset($this->transaction()->operation_id)){
            return 'https://www.moneta.ru/report/receipt.htm?operationId='.$this->transaction()->operation_id.'&transactionId='.$this->id.'&format=pdf';
        }
        else return null;
    }

    public function getTimeHumanAttribute()
    {
        return $this->tim;
    }

    public function getDateAttribute($date)
    {
        return Carbon::parse($date)->locale('ru_RU')->format('d.m.Y');
    }
    public function getTimeAttribute($time)
    {
        return $time ?? '-';
    }


}
