<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
use Illuminate\Http\Request;
use App\Models\MentorSchedule;
use Illuminate\Support\Facades\Validator;
use App\Models\MentorHolidayDate;
use App\Models\MentorScheduleSlot;


class MentorScheduleController extends Controller
{
    //get mentor Chat Fee
    public function getChatFee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $appointment_type_id = $request->appointment_type_id;
            $fee = MentorSchedule::where([
                ['mentor_id', $mentor_id],
                ['appointment_type_id', $appointment_type_id],
            ])->first();
            if (is_null($fee)) {
                $obj = ["Status" => true, "success" => 1, "data" => ["chatFee" => ''], "msg" => "Успешно обновлена стоимость"];
            } else {
                $obj = ["Status" => true, "success" => 1, "data" => ["chatFee" => $fee], "msg" => "Успешно обновлена стоимость"];
            }

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //save mentor Chat Fee
    public function saveAppointmentTypeChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
            'fee'                 => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $appointment_type_id = $request->appointment_type_id;
            $fee = $request->fee;
            $already_exist = MentorSchedule::where([
                ['mentor_id', $mentor_id],
                ['appointment_type_id', $appointment_type_id],
            ])->first();
            if ($already_exist) {
                $already_exist->update([
                    'fee' => $fee,
                ]);
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorChatFee" => $already_exist], "msg" => "Успешно обновлена стоимость"];

                return response()->json($obj);

            } else {
                $mentorSchedule = MentorSchedule::create([
                    'mentor_id'           => $mentor_id,
                    'appointment_type_id' => $appointment_type_id,

                    'fee'        => $fee,
                    'day'        => "",
                    'is_holiday' => 0,
                    'is_active'  => 1,


                ]);
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorChatFee" => $mentorSchedule], "msg" => "Успешно обновлена стоимость"];

                return response()->json($obj);
            }

        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);

    }

    //save mentor Schedule
    public function save(Request $request)
    {
        // return response()->json(var_dump($request->slots));
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
            'fee'                 => 'required|min:100|numeric',
            'day'                 => 'required',
            // 'shift'=>'required|string',
            // 'start_time'=>'required',
            // 'end_time'=>'required',
            'slots'               => 'required|array',
            "interval"            => "required",
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $appointment_type_id = $request->appointment_type_id;
            $fee = $request->fee;
            $day = $request->day;
            // $shift=$request->shift;
            // $start_time=$request->start_time;
            // $end_time=$request->end_time;
            $interval = $request->interval;
            // $slots=$request->slots;

            //update fee for all days
            MentorSchedule::where([
                ['mentor_id', $mentor_id]
                , ['appointment_type_id', $appointment_type_id],
            ])->update([
                'fee' => $fee,
            ]);
            $already_exist = MentorSchedule::where([
                ['mentor_id', $mentor_id],
                ['appointment_type_id', $appointment_type_id],
                ['day', $day]
                // ,
                // ['shift',$shift],
                // ['start_time',$start_time]
            ])->first();
            if ($already_exist) {
                $already_exist->update([
                    'fee'                 => $fee,
                    'is_holiday'          => 0,
                    'is_active'           => 1,
                    'appointment_type_id' => $appointment_type_id,
                ]);
                MentorScheduleSlot::where('schedule_id', $already_exist->id)->delete();
                foreach ($request->slots as $slot) {
                    $time = new \DateTime($slot);
                    $time->add(new \DateInterval('PT' . $interval . 'M'));

                    $stamp = $time->format('H:i:s');
                    MentorScheduleSlot::create([
                        'schedule_id'   => $already_exist->id,
                        'start_time'    => date('h:i a', strtotime($slot)),
                        'end_time'      => date('h:i a', strtotime($stamp)),
                        'slot_duration' => $interval,
                        'is_active'     => 1,
                        'shift_id'      => 1,
                    ]);


                }
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedule" => $already_exist], "msg" => "Расписание обновлено"];

                return response()->json($obj);
            } else {

                $newRecord = MentorSchedule::create([
                    'mentor_id'           => $mentor_id,
                    'appointment_type_id' => $appointment_type_id,
                    'day'                 => $day,
                    'fee'                 => $fee,
                    'is_holiday'          => 0,
                    'is_active'           => 1,
                    'appointment_type_id' => $appointment_type_id,
                ]);
                foreach ($request->slots as $slot) {
                    $time = new \DateTime($slot);
                    $time->add(new \DateInterval('PT' . $interval . 'M'));

                    $stamp = $time->format('H:i:s');
                    MentorScheduleSlot::create([
                        'schedule_id'   => $newRecord->id,
                        'start_time'    => date('h:i:s a', strtotime($slot)),
                        'end_time'      => date('h:i:s a', strtotime($stamp)),
                        'slot_duration' => $interval,
                        'is_active'     => 1,
                        'shift_id'      => 1,
                    ]);

                }
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedule" => $newRecord], "msg" => "Расписание сохранено"];

                return response()->json($obj);
            }


            // if(count($already_exist)>0){
            //     $obj=["Status"=>false,"success"=>0,"msg"=>"Cannot Save Same Day and Start time Schedule Again"];
            //     return response()->json($obj);
            // }else {
            //     //Appointment Type is Chat No Need for Schedule
            //     if($appointment_type_id==3)
            //     {
            // $mentorSchedule=MentorSchedule::create([
            //     'mentor_id'=>$mentor_id,
            //     'appointment_type_id'=>$appointment_type_id,

            //     'fee'=>$fee,

            //     'day'=>$day,
            //     'is_holiday'=>0,
            //     'is_active'=>1


            // ]);

            //         $obj=["Status"=>true,"success"=>1,"data"=>["mentorSchedule"=>$mentorSchedule],"msg"=>"Successfully Saved Mentor Schedule"];

            //          return response()->json($obj);
            //     }
            //     else
            //     {
            //         $mentorSchedule=MentorSchedule::create([
            //             'mentor_id'=>$mentor_id,
            //             'appointment_type_id'=>$appointment_type_id,

            //             'fee'=>$fee,

            //             'day'=>$day,
            //             'is_holiday'=>0,
            //             'is_active'=>1


            //             // 'shift'=>$shift,
            //             // 'start_time'=>$start_time,
            //             // 'end_time'=>$end_time,
            //             // 'interval'=>$interval,
            //             // 'slots'=>$slots,


            //         ]);

            //         foreach($request->slots as $slot){
            //             $time = new \DateTime($slot);
            //             $time->add(new \DateInterval('PT' . $interval . 'M'));

            //             $stamp = $time->format('H:i:s');
            //             MentorScheduleSlot::create([
            //                 'schedule_id'=>$mentorSchedule->id,
            //                 'start_time'=>$slot,
            //                 'end_time'=>$stamp,
            //                 'slot_duration'=>$interval,
            //                 'is_active'=>1,
            //                 'shift_id'=>1
            //             ]);

            //         }

            //         $obj=["Status"=>true,"success"=>1,"data"=>["mentorSchedule"=>$mentorSchedule],"msg"=>"Successfully Saved Mentor Schedule"];

            //          return response()->json($obj);
            //     }

            // }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //get mentor Schedule
    public function getMentorSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), ['mentor_id' => 'required',]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::where('mentor_id', $request->mentor_id)->has('schedule_slots')->with([
                'schedule_slots' => function ($q) {
                    $q->orderBy('start_time', 'ASC');
                },
            ])->get();
            $fee = MentorSchedule::where([
                ['mentor_id', $request->mentor_id],
            ])->whereIn('appointment_type_id', [3, 6])->get();

            $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules, 'mentorWithoutSchedule' => is_null($fee) ? [] : $fee], "msg" => "Расписание обновлено"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //Delete Mentor Schedule Slots
    public function deleteMentorSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), ['id' => 'required',]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            if ($request->appointment_type_id == 3) {
                MentorSchedule::destroy($request->id);

            }

            MentorScheduleSlot::where('schedule_id', $request->id)->delete();
            $obj = ["Status" => true, "success" => 1, "msg" => "Расписание удалено"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //Save Holiday against Date
    public function saveHolidayDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'  => 'required',
            'date'       => "required|date",
            'is_holiday' => "required",
            'comment'    => "required",
        ]);

        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $date = $request->date;
            $is_holiday = $request->is_holiday;
            $comment = $request->comment;
            $created = MentorHolidayDate::create([
                'mentor_id'  => $mentor_id,
                'date'       => $date,
                'is_holiday' => $is_holiday,
                'comment'    => $comment,
            ]);
            $obj = ["Status" => true, "success" => 1, "data" => ["mentorHolidayDate" => $created], "msg" => "Выходные обновлены"];

            return response()->json($obj);
        }

        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function getHolidayDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
        ]);

        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $holidayDate = MentorHolidayDate::where('mentor_id', $request->mentor_id)->get();
            $obj = ["Status" => true, "success" => 1, "data" => ["holidayDate" => $holidayDate], "msg" => "Выходные обновлены"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function updateHolidayDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'  => 'required',
            'date'       => "required|date",
            'is_holiday' => "required",
            'comment'    => "required",
        ]);

        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentor_id = $request->mentor_id;
            $date = $request->date;
            $is_holiday = $request->is_holiday;
            $comment = $request->comment;
            $updated = MentorHolidayDate::where('mentor_id', $mentor_id)->update([
                'date'       => $date,
                'is_holiday' => $is_holiday,
                'comment'    => $comment,
            ]);
            $obj = ["Status" => true, "success" => 1, "data" => ["mentorHolidayDate" => $updated], "msg" => "Выходные обновлены"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function getAvailableDaysWeb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::select('day', 'is_holiday')->where([
                ['mentor_id', $request->mentor_id], ['is_holiday', 0],
                ['appointment_type_id', $request->appointment_type_id],
            ])->orderBy('id', 'ASC')->get();
            if (count($mentorSchedules) > 0) {
                foreach ($mentorSchedules as $item){
                    switch ($item->day){
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
                            $day_name = $item->day;
                            break;
                    }
                    $item->day_name = $day_name;
                }
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules], "msg" => "Successfully Found Mentor Schedule Days"];
                return response()->json($obj);
            } else {
                $created = [
                    ['day' => 'Понедельник', 'is_holiday' => 1], ['day' => 'Вторник', 'is_holiday' => 1], ['day' => 'Среда', 'is_holiday' => 1], ['day' => 'Четверг', 'is_holiday' => 1]
                    , ['day' => 'Пятница', 'is_holiday' => 1], ['day' => 'Суббота', 'is_holiday' => 1], ['day' => 'Воскресенье', 'is_holiday' => 1],
                ];
                foreach ($created as $item){
                    $item['day_name'] = $item['day'];
                }
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $created], "msg" => "Successfully Found Mentor Schedule Days"];

                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function getAvailableDays(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::select('day', 'is_holiday')->where([
                ['mentor_id', $request->mentor_id], ['appointment_type_id', $request->appointment_type_id],
            ])->orderBy('id', 'ASC')->get();
            if (count($mentorSchedules) > 0) {
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules], "msg" => "Successfully Found Mentor Schedule Days"];

                return response()->json($obj);
            } else {
                $created = [
                    ['day' => 'monday', 'locale_day' => 'Понедельник', 'is_holiday' => 0], ['day' => 'tuesday', 'locale_day' => 'Вторник', 'is_holiday' => 0], ['day' => 'wednesday','locale_day' => 'Среда', 'is_holiday' => 0], ['day' => 'tuesday', 'locale_day' => 'Четверг', 'is_holiday' => 0]
                    , ['day' => 'friday', 'locale_day' => 'Пятница', 'is_holiday' => 0], ['day' => 'saturday', 'locale_day' => 'Суббота', 'is_holiday' => 0], ['day' => 'sunday', 'locale_day' => 'Воскресенье', 'is_holiday' => 0],
                ];
                $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $created], "msg" => "Successfully Found Mentor Schedule Days"];

                return response()->json($obj);
            }
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function markDayHoliday(Request $request)
    {
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
            // 'day'=>'required',
            // 'is_holiday'=>'required'
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $obj_avail = $request->availability;

            $already = MentorSchedule::where([
                ['mentor_id', $request->mentor_id],
                ['appointment_type_id', $request->appointment_type_id],
            ])->first();
            if ($already) {
                foreach ($obj_avail as $key => $value) {
                    MentorSchedule::where([
                        ['mentor_id', $request->mentor_id], ['day', $key]
                        , ['appointment_type_id', $request->appointment_type_id],
                    ])->update([
                        'day'        => $key,
                        'is_holiday' => $value
                        //  ,'appointment_type_id'=>$request->appointment_type_id
                    ]);
                }
                // $already->update([
                //     'is_holiday'=>$request->is_holiday,

                // ]);
                $obj = ["Status" => true, "success" => 1, "msg" => "Обновлена доступность"];

                return response()->json($obj);
            } else {
                foreach ($obj_avail as $key => $value) {


                    $created = MentorSchedule::create([
                        'mentor_id'           => $request->mentor_id,
                        'appointment_type_id' => $request->appointment_type_id,
                        'fee'                 => 0,
                        'day'                 => $key,
                        'is_holiday'          => $value,
                        'is_active'           => 0,
                    ]);
                }

                $obj = ["Status" => true, "success" => 1, "msg" => "Обновлена доступность"];

                return response()->json($obj);
            }

        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function getMentorDateSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'date'                => 'required',
            'appointment_type_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $timestamp = strtotime($request->date);
            $day = strtolower(date('l', $timestamp));
            $date = $request->date;
            $scheduleSlots = MentorSchedule::where([
                ['mentor_id', $request->mentor_id],
                ['day', $day], ['appointment_type_id', $request->appointment_type_id],
            ])->with([
                'schedule_slots' => function ($q) {
                    $q->orderBy('id', 'ASC');
                },
            ])->first();
            // dd($scheduleSlots);
            if (isset($scheduleSlots->schedule_slots) && count($scheduleSlots->schedule_slots) > 0) {
                foreach ($scheduleSlots->schedule_slots as $scheduleSlot) {
                    $exist = BookAppointment::where([
                        ['mentor_id', $request->mentor_id],
                        ['date', $date], ['appointment_type_id', $request->appointment_type_id]
                        , ['time', $scheduleSlot->start_time],
                    ])->count();
                    $scheduleSlot['is_booked'] = $exist;

                }
            }
            $obj = ["Status" => true, "success" => 1, "data" => ['schedule' => $scheduleSlots], "msg" => "Successfully Got Slots"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function availableMentorAppointmentTypes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id')->where('mentor_id', $request->mentor_id)->with('appointment_type')->distinct()->get();

            $obj = ["Status" => true, "success" => 1, "data" => ['schedule_types' => $schedule_types], "msg" => "Successfully Got Schedule Types for mentor"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function getMentorFeeByAppointmentType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $fee = MentorSchedule::where([['mentor_id', $request->mentor_id], ['appointment_type_id', $request->appointment_type_id]])->first();

            $obj = ["Status" => true, "success" => 1, "data" => ['mentor_fee' => $fee], "msg" => "Successfully Got Appointment Type Fee for mentor"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //get Scheduled Available Days of Mentor
    public function getScheduledAvailableDays(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id'           => 'required',
            'appointment_type_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $mentorSchedules = MentorSchedule::has('schedule_slots')->select('day', 'is_holiday')->where([
                ['mentor_id', $request->mentor_id], ['appointment_type_id', $request->appointment_type_id]
                , ['is_holiday', 0],
            ])->orderBy('id', 'ASC')->get();

            $obj = ["Status" => true, "success" => 1, "data" => ["mentorSchedules" => $mentorSchedules], "msg" => "Successfully Found Mentor Schedule Days"];

            return response()->json($obj);

        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

}
