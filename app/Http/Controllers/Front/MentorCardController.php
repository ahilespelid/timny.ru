<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MentorCardDetail;
use Illuminate\Support\Facades\Validator;
use App\Models\Mentor;
use App\Models\MentorCategory;
use App\Models\MentorSchedule;
use App\Models\Rating;
use Illuminate\Support\Facades\Http;
use App\Models\MentorAssignCategory;
use Illuminate\Support\Facades\DB;

class MentorCardController extends Controller
{
    //save Mentor Card
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_title'  => 'required|string',
            'account_number' => 'required',
            'bank'           => 'required|string',
            'mentor_id'      => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $account_title = $request->account_title;
            $account_number = $request->account_number;
            $bank = $request->bank;
            $mentor_id = $request->mentor_id;

            //return response()->json($card_number);
            $card = MentorCardDetail::create([
                'account_title'  => $account_title,
                'account_number' => $account_number,
                'bank'           => $bank,
                'mentor_id'      => $mentor_id,

            ]);
            $obj = ["Status" => true, "success" => 1, "data" => ["card" => $card], "msg" => "Mentor Card Added Successfully"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //show Mentor Card
    public function show(Request $request)
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
            $card = MentorCardDetail::where('mentor_id', $request->mentor_id)->first();
            $obj = ["Status" => true, "success" => 1, "data" => ["card" => $card], "msg" => "Mentor Card fetched Successfully"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //update Mentor Card
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_title'  => 'required|string',
            'account_number' => 'required|string',
            'bank'           => 'required|string',
            'mentor_id'      => 'required',
        ]);
        if ($validator->fails()) {
            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $account_title = $request->account_title;
            $account_number = $request->account_number;
            $bank = $request->bank;
            $mentor_id = $request->mentor_id;

            //return response()->json($card_number);
            $card = MentorCardDetail::where('id', $request->mentor_id)->update([
                'account_title'  => $account_title,
                'account_number' => $account_number,
                'bank'           => $bank,
                'mentor_id'      => $mentor_id,
            ]);

            $obj = ["Status" => true, "success" => 1, "data" => ["card" => $card], "msg" => "Данные карты успешно обновлены"];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }


    //Search Mentor
    public function searchMentor(Request $request)
    {

        $token = "123";
        $category = $request->category_id;
        $search = $request->search;

        if ($request->token == $token) {

            $mentor_cat_ids = MentorAssignCategory::select('mentor_id')->where('category_id', $category)->get();
            $mentor_ids = [];
            foreach ($mentor_cat_ids as $mentor) {
                array_push($mentor_ids, $mentor->mentor_id);

            }
            $mentors = Mentor::whereIn('user_id', $mentor_ids)->where('status', 1)->with([
                'user' => function ($q) use ($search) {
                    $q->orWhere('first_name', 'like', '%{$search}%');
                    $q->orWhere('last_name', 'like', '%{$search}%');
                },
            ])->paginate(10);
            foreach ($mentors as $mentor) {
                $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', 'fee')->where('mentor_id', $mentor->user_id)->with('appointment_type')->distinct()->get();
                $mentor['schedule_types'] = $schedule_types;
                $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where([['mentor_id', $mentor->user_id], ['appointment_type_id', 3]])->with('appointment_type')->get();
                $mentor['without_schedule_types'] = $chat_type;
                $mentor_category = MentorAssignCategory::where('mentor_id', 62)->with('category')->orderBy('id', 'ASC')->first();
                $mentor['category'] = $mentor_category->category;

            }

            $obj = ["Status" => true, "success" => 1, "data" => ["mentors" => $mentors], "msg" => "Got Successfully Mentors"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];

        return response()->json($obj);
    }

    //search categories with mentor count
    public function searchcategory(Request $request)
    {

        $token = "123";
        if ($request->token == $token) {
            $search = $request->search;
            $categories = MentorCategory::where('parent_id', 0)->where(function ($q) use ($search) {
                $q->orWhere('name', 'like', "%{$search}%");
                $q->orWhere('slug', 'like', "%{$search}%");
            })->get();
            foreach ($categories as $category) {
                $mentors = MentorAssignCategory::select('mentor_id')->where('category_id', $category->id)->get();

                $mentor_ids = [];
                foreach ($mentors as $mentor) {
                    array_push($mentor_ids, $mentor->mentor_id);

                }


                $mentorCount = Mentor::has('schedule')->where('status', 1)->whereIn('user_id', $mentor_ids)->count();

                $category['mentor_p_count'] = $mentorCount;


            }
            $obj = ["Status" => true, "success" => 1, "data" => ["results" => $categories], "msg" => " Successfully got Category "];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    //featured Search for mentors
    public function searchFeaturedMentors(Request $request)
    {
        $token = "123";
        if ($request->token == $token) {
            $search = $request->search;
            $mentors = Mentor::has('schedule')
                ->where('status', 1)
                ->where('is_featured', 1)
                ->with([
                    'user' => function ($q) use ($search) {
                        $q->where('first_name', 'like', '%' . $search . '%');
                        $q->orWhere('last_name', 'like', '%' . $search . '%');
                        $q->orWhere('description', 'like', '%' . $search . '%');
                    },
                ])->get();

            $newMentors = [];
            foreach ($mentors->toArray() as $mentor) {

                if (is_null($mentor['user'])) {


                    unset($mentor);
                    continue;

                }

                $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', 'fee')->where('mentor_id', $mentor['user_id'])->with('appointment_type')->distinct()->get();
                $mentor['schedule_types'] = $schedule_types;
                $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where([['mentor_id', $mentor['user_id']], ['appointment_type_id', 3]])->with('appointment_type')->get();
                $mentor['without_schedule_types'] = $chat_type;
                $category_id = MentorAssignCategory::select('category_id', 'id')->where('mentor_id', $mentor['user_id'])->orderBy('id', 'desc')->first();
                $mentorCategory = '';
                if ($category_id) {
                    $mentorCategory = MentorCategory::where('id', $category_id->category_id)->first();
                }

                $mentor['category'] = $mentorCategory;
                if ($chat_type->isEmpty()) {
                    $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : 0;
                } else if ($schedule_types->isEmpty()) {
                    $minFee = count($chat_type) > 0 ? $chat_type[0]->fee : 0;
                } else {

                    $minFee = (count($schedule_types) > 0 ? $schedule_types[0]->fee : (count($chat_type) > 0 ? $chat_type[0]->fee : 0));
                }
                foreach ($schedule_types as $schedule_type) {
                    if ($minFee > $schedule_type->fee)
                        $minFee = $schedule_type->fee;
                }
                foreach ($chat_type as $chat) {
                    if ($minFee > $chat->fee)
                        $minFee = $chat->fee;
                }
                $mentor['fee'] = $minFee;
                array_push($newMentors, $mentor);
            }


            $obj = ["Status" => true, "success" => 1, "data" => ["results" => $newMentors], "msg" => " Successfully got Category "];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function searchMentorWeb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'search' => 'required|string',
            'slug' => 'required|string',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }

        $token = "123";
        if ($request->token == $token) {
            $search = $request->search;
            $city = $request->city;
            $country = $request->country;
            $mentorCategory = MentorCategory::where('slug', $request->slug)->first();
            if (is_null($mentorCategory)) {
                $obj = ["Status" => true, "success" => 1, "data" => ["results" => []], "msg" => "No Category found with provided slug"];
                return response()->json($obj);
            }
            $mentor_cat_ids = MentorAssignCategory::select('mentor_id')->where('category_id', $mentorCategory->id)->get();
            $mentor_ids = [];
            foreach ($mentor_cat_ids as $mentor) {
                array_push($mentor_ids, $mentor->mentor_id);

            }
            $mentors = Mentor::has('schedule')->whereIn('user_id', $mentor_ids)
                // ->orWhere('mentor_category_id','=',$mentorCategory->id)
                //->where('status', 1)
                ->where(function ($q) use ($search, $city, $country) {
                    $q->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($q) use ($search, $city, $country) {
                            $q->when($city, function ($q, $city) {
                                $q->where('city', $city);
                            });
                            $q->Where(function ($q) use ($search, $city) {
                                $q->orWhere('first_name', 'like', '%' . $search . '%');
                                $q->orWhere('last_name', 'like', '%' . $search . '%');
                            });
                            $q->with([
                                'user_country' => function ($q) use ($country) {
                                    // $q->select('name');
                                    $q->orWhere('name', $country);
                                },
                            ]);
                        });
                })
                ->get();
            $newMentors = [];
            foreach ($mentors as $mentor) {
                if (is_null($mentor->user)) {

                    // $mentors = [];
                    unset($mentor);
                    continue;
                }

                $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', DB::raw('min(fee) as fee'))->where('mentor_id', $mentor->user_id)->with('appointment_type')->groupBy('appointment_type_id')->get();
                $mentor['schedule_types'] = $schedule_types;
                $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where([['mentor_id', $mentor->user_id], ['appointment_type_id', 3]])->with('appointment_type')->get();
                $mentor['without_schedule_types'] = $chat_type;
                if ($chat_type->isEmpty()) {
                    $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : 0;
                } else if ($schedule_types->isEmpty()) {
                    $minFee = count($chat_type) > 0 ? $chat_type[0]->fee : 0;
                } else {

                    $minFee = (count($schedule_types) > 0 ? $schedule_types[0]->fee : (count($chat_type) > 0 ? $chat_type[0]->fee : 0));
                }
                foreach ($schedule_types as $schedule_type) {
                    if ($minFee > $schedule_type->fee)
                        $minFee = $schedule_type->fee;
                }
                foreach ($chat_type as $chat) {
                    if ($minFee > $chat->fee)
                        $minFee = $chat->fee;
                }
                $mentor['fee'] = $minFee;
                $mentor['category'] = $mentorCategory;
                $rating = Rating::where('mentor_id', $mentor->user_id)->avg('rating');
                $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();

                $mentor['rating'] = round($rating);
                $mentor['ratingCount'] = $ratingCount;
                array_push($newMentors, $mentor);
            }
            //    dd($mentors);

            $obj = ["Status" => true, "success" => 1, "data" => ["results" => $newMentors], "msg" => " Successfully got Mentors "];

            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }

    public function searchMentorMobile(Request $request)
    {


        $search = $request->search;

        $mentors = Mentor::has('schedule')
            // ->whereIn('user_id',$mentor_ids)
            // ->orWhere('mentor_category_id','=',$mentorCategory->id)
            ->where('status', 1)->with([
                'user' => function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%');
                    // $q->where('city',$city);
                    $q->orWhere(function ($q) use ($search) {

                        // $q->where('city',$city);
                        $q->where('last_name', 'like', '%' . $search . '%');
                    });


                },
            ])->get();


        $newMentors = [];
        foreach ($mentors as $mentor) {
            if (is_null($mentor->user)) {


                unset($mentor);
                continue;
            }

            // $schedule_types = MentorSchedule::has('schedule_slots')->select('appointment_type_id', DB::raw('min(fee) as fee'))->where('mentor_id', $mentor->user_id)->with('appointment_type')->groupBy('appointment_type_id')->get();
            // $mentor['schedule_types'] = $schedule_types;
            // $chat_type = MentorSchedule::select('appointment_type_id', 'fee')->where([['mentor_id', $mentor->user_id], ['appointment_type_id', 3]])->with('appointment_type')->get();
            // $mentor['without_schedule_types'] = $chat_type;
            // if ($chat_type->isEmpty()) {
            //     $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : 0;
            // } else if ($schedule_types->isEmpty()) {
            //     $minFee = count($chat_type) > 0 ? $chat_type[0]->fee : 0;
            // } else {

            //     $minFee = count($schedule_types) > 0 ? $schedule_types[0]->fee : count($chat_type) > 0 ? $chat_type[0]->fee : 0;
            // }
            // foreach ($schedule_types as $schedule_type) {
            //     if ($minFee > $schedule_type->fee)
            //         $minFee = $schedule_type->fee;
            // }
            // foreach ($chat_type as $chat) {
            //     if ($minFee > $chat->fee)
            //         $minFee = $chat->fee;
            // }
            $cat_id = MentorAssignCategory::select('category_id')->where('mentor_id', $mentor->user_id)
                ->orderBy('id', 'DESC')
                ->first();
            $mentorCategory = MentorCategory::where('id', $cat_id->category_id)->first();
            // $mentor['fee'] = $minFee;
            $mentor['category'] = $mentorCategory;
            $rating = Rating::where('mentor_id', $mentor->user_id)->avg('rating');
            $ratingCount = Rating::where('mentor_id', $mentor->user_id)->count();

            $mentor['ratingAvg'] = round($rating);
            $mentor['ratingCount'] = $ratingCount;
            array_push($newMentors, $mentor);
        }
        //    dd($mentors);

        $obj = ["Status" => true, "success" => 1, "data" => ["results" => $newMentors], "msg" => " Successfully got Mentors "];

        return response()->json($obj);

    }

    //get user Location by IP (Trail)
    public function getUserLocation()
    {
        $response = Http::withoutVerifying()->get('https://www.cloudflare.com/cdn-cgi/trace');
        $res = $response->body();
        $resArr = explode("\n", $res);
        $ipArr = explode("=", $resArr[2]);

        $resCount = Http::withoutVerifying()->get('https://freegeoip.app/json/' . $ipArr[1]);
        $result = json_decode($resCount->body());
        $country = $result->country_name;
        $city = $result->city;
        $data = ['city' => $city, 'country' => $country];
        return response()->json($data);
    }
}
