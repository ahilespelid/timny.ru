<?php

namespace App\Models;

use App\Http\Controllers\MeetingConfirmationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingConfirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_appointment_id'
    ];

    public function bookAppointment(): BelongsTo
    {
        return $this->belongsTo(BookAppointment::class)->with(['mentor', 'mentee']);
    }

    protected static function booted()
    {
        self::updating(function ($mc){
            if(!$mc->customer_confirmation && !$mc->mentor_confirmation){
                MeetingConfirmationController::CancelMeeting(BookAppointment::find($mc->book_appointment_id));
                $mc->delete();
                return false;
            }
            if($mc->customer_confirmation && $mc->mentor_confirmation) {
                MeetingConfirmationController::MeetConfirmed(BookAppointment::find($mc->book_appointment_id));
                $mc->delete();
                return false;
            }
            if($mc->customer_confirmation xor $mc->mentor_confirmation) return MeetingConfirmationController::CreateConflict($mc);
        });
    }
}
