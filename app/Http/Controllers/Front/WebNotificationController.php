<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\UserFcmToken;
use App\Models\Notification;

class WebNotificationController extends Controller{
///*/ ahilespelid ///*/
public function index(){
    $notifications = Notification::where('user_id', auth()->user()->id)
        ->orderBy('id', 'desc')->take(10)
        ->get();

    if(!empty($email = auth()->user()->email) && !empty($notifications)){foreach($notifications as $notification){
            $mess='';
            if(0 == $notification->send){
                mail($email, 'timny.ru new notification: ', $mess = $email.' Dear '.auth()->user()->first_name.' '. auth()->user()->last_name.PHP_EOL.'your invisible notification on the site timny.ru: '.$notification->title.PHP_EOL.$notification->body);
                $notification->send = 1; $notification->save();
            } ///*/ $ret[] = ['id' => $notification->id, 'send' => $notification->send, 'title' => $notification->title, 'body' => $notification->body, 'mess' => (!empty($mess) ? $mess : '')]; ///*/
    }}
return ($notifications); /*/// ($ret); ///*/ }
///*/ ahilespelid ///*/

    public function getUserToken(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',

        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $tokens=UserFcmToken::where('user_id',$request->user_id)->get();
            $obj=["Status"=>true,"success"=>1,"data"=>["tokens"=>$tokens],"msg"=>" Successfully Got User Tokens"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }
    public function storeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'device_id' => 'required|string',
            'fcm_token' => 'required|string',


        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $device=$request->device_id;

            $oldTokens=UserFcmToken::where('device_id',$device)->delete();

            UserFcmToken::create(['user_id'=>$request->user_id,'device_key'=>$request->fcm_token,'device_id'=>$device]);
            $obj=["Status"=>true,"success"=>1,"msg"=>"Token stored Successfully"];

            return response()->json($obj);
        }
        $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
        return response()->json($obj);
    }

    public function sendWebNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title'=>'required|string',
            'body'=>'required|string',


        ]);
        if ($validator->fails()) {

            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $token="123";
        if ($request->token==$token){
            $notification = Notification::create([
                'token'      => $request->token,
                'user_id'    => $request->user_id,
                'body'       => $request->body,
                'title'      => $request->title,
                'link'       => $request->link,
                'created_at' => request('name'),
            ]);


            $url = 'https://fcm.googleapis.com/fcm/send';
            $FcmToken = UserFcmToken::where('user_id',$request->user_id)->whereNotNull('device_key')->pluck('device_key')->toArray();
            //old
            $serverKey = config('services.firebase.server_key');
            // $serverKey =$_ENV['FIREBASE_SERVER_KEY'];
            // dd($serverKey);

            //'AAAAzbp8oYc:APA91bFdJUSDhhvlyuryxb0Gg9wStY85gsqqQarJrR3Cx1bmL2mGewaR6TVcnlG_2IvK885eQF74ufNjVpR-pXMHjpZIWickj19CMTcit4pacdZ1MzVgbAWK_R6EmJTG4P4pMN8Dmwd7';

            if($request->call_type == 'audio')
            {
                $data = [
                    "registration_ids" => $FcmToken,
                    "notification" => [
                        "title" => $request->title,
                        "body" => $request->body,
                        'data'=>$request->link

                    ],
                    "data" => [
                        "routeApp" => "/audioCall",
                        "channel" => "$request->channel_name",
                        "channel_token" => "$request->channel_token"
                    ]
                ];
            }
            else if($request->call_type == 'video')
            {
                $data = [
                    "registration_ids" => $FcmToken,
                    "notification" => [
                        "title" => $request->title,
                        "body" => $request->body,
                        'data'=>$request->link

                    ],
                    "data" => [
                        "routeApp" => "/videoCall",
                        "channel" => "$request->channel_name",
                        "channel_token" => "$request->channel_token"
                    ]
                ];
            }
            else if($request->link)
            {
                $data = [
                    "registration_ids" => $FcmToken,
                    "notification" => [
                        "title" => $request->title,
                        "body" => $request->body,
                        'data'=>$request->link

                    ]
                ];
            }
            else
            {
                $data = [
                    "registration_ids" => $FcmToken,
                    "notification" => [
                        "title" => $request->title,
                        "body" => $request->body,
                    ]
                ];
            }

            $encodedData = json_encode($data);
            //var_dump($encodedData);
            //exit;
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

            // Execute post
            $result = curl_exec($ch);

            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);

            // FCM response
            return response()->json($result);
       }
       $obj=["Status"=>false,"success"=>0,"msg"=>"Token Incorrect"];
       return response()->json($obj);
    }
}
