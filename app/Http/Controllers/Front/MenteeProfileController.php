<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Mentee;
use Illuminate\Support\Facades\Storage;
class MenteeProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            // 'email' => 'required|unique:users,email,'.$request->user_id.',id|string',
            // 'phone' => 'required',
            'gender' => 'required|string',
            // 'image' => 'required',
            'country' => 'required',
            'city' => 'required|string',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $file_name = '';
            $user=User::find($request->user_id);
            if ($request->hasFile('picture')) {

                $image = $request->file('picture');
                $file_type =$image->getClientOriginalExtension();
                $image_name = time().'_'.$image->getClientOriginalName();
                $path = public_path('/assets/mentorProfile/');
                $image->move($path,$image_name);
                $file_name = '/assets/mentorProfile/'.$image_name;
                // if($user->image_path){
                //     $ar=explode('/',$user->image_path);
                //     if(isset($ar[3]) &&  isset($ar[4])){
                //         $folder=$ar[3];
                //         $imageName=$ar[4];
                //         Storage::disk('s3')->delete($folder.'/'.$imageName);
                //     }

                // }


                // $path = Storage::disk('s3')->put('menteeProfile',$image,'public-read');
                // $path = Storage::disk('s3')->url($path);
                // $file_name = $path;
            }
            if(!empty($request->email)){
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    // 'phone' => $request->phone,
                    'gender' => $request->gender,
                    'image_path' => !empty($file_name) ? $file_name : $user->image_path,
                    'country' => $request->country,
                    'city' => $request->city,
                    'dob' => date('Y-m-d', strtotime($request->dob))

                ]);
            }else {
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    // 'email' => $request->email,
                    // 'phone' => $request->phone,
                    'gender' => $request->gender,
                    'image_path' => !empty($file_name) ? $file_name : $user->image_path,
                    'country' => $request->country,
                    'city' => $request->city,
                    'dob' => date('Y-m-d', strtotime($request->dob))

                ]);
            }


            $obj = ["Status" => true, "success" => 1, "msg" => "Профиль успешно обновлен"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }
    public function getMenteeProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {

            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $user = User::with('user_country','mentee')->find($request->user_id);
            $obj = ["Status" => true, "success" => 1, "data" => ["user" => $user], "msg" => "Профиль успешно обновлен"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }
    public function toggleIdentityVisiblity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required:int',
            'visibility'=>'required:in:0,1'
        ]);
        if ($validator->fails()) {
            $obj = ["Status" => false, "success" => 0, "errors" => $validator->errors()];
            return response()->json($obj);
        }
        $token = "123";
        if ($request->token == $token) {
            $user = Mentee::where('user_id',$request->user_id)->first();
            $user->identity_hidden = $request->visibility;
            $user->save();
            $obj = ["Status" => true, "success" => 1,"msg" => "Видимость профиля успешно обновлена"];
            return response()->json($obj);
        }
        $obj = ["Status" => false, "success" => 0, "msg" => "Неверный токен"];
        return response()->json($obj);
    }
}
