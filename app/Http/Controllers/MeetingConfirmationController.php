<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PaymentGateway\Moneta\Moneta;
use App\Models\BookAppointment;
use App\Models\MeetingConfirmation;
use App\Models\MeetingConflict;
use App\Models\NewTransaction;
use App\Models\User;
use Bavix\Wallet\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class MeetingConfirmationController extends Controller
{
    /**
     * Подтверждает завершение сделки со стороны консультанта
     * @param Request $request
     * @return void
     */
    public function MentorConfirm(Request $request){
        $request->validate([
            'BookAppointmentId' => 'required',
            'ConfirmationStatus' => 'required|boolean',
        ]);

        $mc = MeetingConfirmation::firstOrNew([
            'book_appointment_id' => $request->BookAppointmentId,
        ]);
        $mc->mentor_confirmation = $request->ConfirmationStatus;
        $mc->save();
    }

    /** Подтверждает завершение сделки со стороны пользователя
     * @param Request $request
     * @return void
     */
    public function CustomerConfirm(Request $request){
        $request->validate([
            'BookAppointmentId' => 'required',
            'ConfirmationStatus' => 'required|boolean',
        ]);

        $mc = MeetingConfirmation::firstOrNew([
            'book_appointment_id' => $request->BookAppointmentId,
        ]);
        $mc->customer_confirmation = $request->ConfirmationStatus;
        $mc->save();
    }

    /**
     * Разрешает конфликт в пользу клиента или консультанта
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|void
     * @throws Exception
     */
    public function ResolveConflict(Request $request){
        // todo:Сюда надо вставить Gate, когда будет система авторизации. Admin only
        $request->validate([
            'ConflictId' => 'required',
            'Resolution' => 'required',
        ]);
        $conflict = MeetingConflict::find($request->ConflictId);
        $ba = BookAppointment::find($conflict->book_appointment_id);
        if($request->Resolution == 'mentee'){
            self::CancelMeeting($ba);
            $conflict->addLog('Конфликт решён в пользу клиента');
        }elseif($request->Resolution == 'mentor'){
            self::MeetConfirmed($ba);
            $conflict->addLog('Конфликт решён в пользу консультанта');
        }
        $conflict->status = 'done';
        $conflict->save();
        return MeetingConflict::with(['bookAppointment'])->get();
    }

    /**
     * Завершает безопасную сделку, удаляет MeetConfirmation, отмечает встречу как состоявшуюся.
     * Вызывается автоматически из модели MeetConfirmation, если оба участника подтвердили завершение встречи
     * @param BookAppointment $appointment
     * @return void
     */
    public static function MeetConfirmed(BookAppointment $appointment){
        $appointment_exist = $appointment;
        $user = User::find($appointment_exist->mentor_id);
//        $transaction = Transaction::find($appointment_exist->payment_id);
//        $user->confirm($transaction);

        $transaction = NewTransaction::where('book_appointment_id', $appointment->id)->first();
        if($transaction){
            $transaction->status = 'done';
            $transaction->save();
        }

        $appointment_exist->update(['appointment_status'=>2]);
    }

    /**
     * Создает MeetingConflict.
     * Вызывается автоматически из модели MeetConfirmation, если один участник подтвердил встречу, а другой - опроверг
     * @param MeetingConfirmation $meet
     * @param MeetingConfirmation $old
     * @return false
     */
    public static function CreateConflict(MeetingConfirmation $meet){
        $conflict = new MeetingConflict();
        $conflict->book_appointment_id = $meet->book_appointment_id;
        $mentor = $meet->bookAppointment->mentor;
        $mentorName = $mentor->first_name . ' ' . $mentor->last_name;
        $mentorName = trim($mentorName);
        $mentee = $meet->bookAppointment->mentee;
        $menteeName = $mentee->first_name . ' ' . $mentee->last_name;
        $menteeName = trim($menteeName);

        if($meet->getOriginal('customer_confirmation') !== null){
            $log['time'] = $meet->created_at;
        } else{
            $log['time'] = now();
        }
        if($meet->customer_confirmation){
            $log['event'] = 'Клиент '.$menteeName.' подтвердил, что встреча состоялась';
        }else{
            $log['event'] = 'Клиент '.$menteeName.' указал, что встреча не состоялась';
        }
        $logs[] = $log;

        if($meet->getOriginal('mentor_confirmation') !== null){
            $log['time'] = $meet->created_at;
        } else{
            $log['time'] = now();
        }
        if($meet->mentor_confirmation){
            $log['event'] = 'Консультант '.$mentorName.' подтвердил, что встреча состоялась';
        }else{
            $log['event'] = 'Консультант '.$mentorName.' указал, что встреча не состоялась';
        }
        $logs[] = $log;
        $conflict->conflict_log = $logs;
        $conflict->save();

        $meet->delete();
        return false;
    }

    /**
     * Отменяет встречу и проводит возврат связанного с ней платежа
     * @param BookAppointment $appointment
     * @return void
     * @throws Exception
     */
    public static function CancelMeeting(BookAppointment $appointment){
        $transaction = NewTransaction::where('book_appointment_id', $appointment->id)->first();
        if($transaction && $appointment->is_paid && $appointment->payment_id != null){
            Moneta::returnByOperationId($transaction->operation_id);
        $transaction->status = 'returning';
        $transaction->save();
        }

        $appointment->appointment_status = 3;
        $appointment->is_paid = 0;
        $appointment->save();
    }

}
