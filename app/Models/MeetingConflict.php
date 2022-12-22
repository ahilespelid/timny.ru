<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property mixed $book_appointment_id
 */
class MeetingConflict extends Model
{
    use HasFactory;

    protected $casts = [
      'conflict_log' => AsCollection::class,
    ];

    public function bookAppointment(): BelongsTo
    {
        return $this->belongsTo(BookAppointment::class)->with(['mentor_base', 'mentee_base']);
    }

    public function addLog($event){
        $this->conflict_log->push(['time' => now(), 'event' => $event]);
    }

    protected static function booted()
    {
        self::updating(function($mc){
            if($mc->status != $mc->getOriginal('status')) $mc->addLog('Статус обращения изменён: '.Str::upper($mc->status));
        });

    }
}
