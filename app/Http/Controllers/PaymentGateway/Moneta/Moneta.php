<?php

namespace App\Http\Controllers\PaymentGateway\Moneta;

use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class Moneta extends Controller

{

    public function getCondition(){
        $user = User::where('id', Auth::id())->select(['id', 'moneta'])->first();
        if($user->moneta == null){
            return [
                'unit_id' => null,
                'document_added' => false,
                'phone_confirmed' => false,
                'identification_status' => 'no_identified',
                'error_str' => null,
                'account_id' => null,
                'asyncId' => null,
                'profile_id' => null
            ];
        }
        return $user->moneta;
    }

    public function createAccount(){
        $user = User::find(Auth::id());
        $CreateAccountRequest = new MonetaRequest([
            'CreateAccountRequest' => [
                'prototypeAccountId' => 45805242,
                'currency' => 'RUB',
                'paymentPassword' => 609278,
                'unitId' => $user->moneta['unit_id'],
                'signature' => 'bKHSguefnjs',
            ]
        ]);
        $req = $CreateAccountRequest->send();

        $user->moneta['account_id'] = $req->Envelope->Body->CreateAccountResponse;
        $user->save();

        return $req;
    }

    public function createProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'passport_series' => 'required',
            'passport_number' => 'required',
            'phone' => 'required',
           // 'user_id'=>'required',
        ]);
        if ($validator->fails()) {
            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }

        $user = User::find(Auth::id());

        if($user->moneta == null){
            $user->moneta = [
                'unit_id' => null,
                'document_added' => false,
                'phone_confirmed' => false,
                'identification_status' => 'no_identified',
                'error_str' => null,
                'account_id' => null,
                'asyncId' => null,
                'profile_id' => null
            ];
            $user->save();
        }

        if($user->moneta['unit_id'] == null){
            $profile = new MonetaModel();
            $profile->setAttribute('last_name', $user->last_name);
            $profile->setAttribute('first_name', $user->first_name);
            $profile->setAttribute('middle_initial_name', $user->father_name);
            $profile->setAttribute('cell_phone', $request->phone);
            $profile->setAttribute('date_of_birth', $user->dob);
            $profile->setAttribute('email_for_notifications', $user->email);

            $CreateProfileRequest = new MonetaRequest([
                'CreateProfileRequest' => [
                    "unitId" => 19178536,
                    'profileType' => 'CLIENT',
                    'profile' => $profile->toArray()
                ]
            ]);
            $response = $CreateProfileRequest->send();
            $monetaProfileId = $response->Envelope->Body->CreateProfileResponse;
            $user->moneta['unit_id'] = $monetaProfileId;
            $user->save();
        }

        if(!$user->moneta['document_added']){
            $passport = new MonetaModel();
            $passport->setAttribute('SERIES', $request->passport_series);
            $passport->setAttribute('NUMBER', $request->passport_number);
            $CreateProfileDocumentRequest = new MonetaRequest([
                'CreateProfileDocumentRequest' => [
                    'type' => 'PASSPORT',
                    'attribute' => $passport->toArray(true),
                    'unitId' => $user->moneta['unit_id'],
                ]
            ]);
            $CreateProfileDocumentRequest->send();

            $user->moneta['document_added'] = true;
            $user->save();
        }

        if($user->moneta['phone_confirmed'] != 'confirmed'){
        $ApprovePhoneSendConfirmationRequest = new MonetaRequest([
            'ApprovePhoneSendConfirmationRequest' => [
                'unitId' => $user->moneta['unit_id'],
            ],
        ]);
        $res = $ApprovePhoneSendConfirmationRequest->send();
            if (isset($res->Envelope->Body->fault) && $res->Envelope->Body->fault->detail->faultDetail == '500.3.2.48'){
                $user->moneta['phone_confirmed'] = 'confirmed';
            }else{
                $user->moneta['phone_confirmed'] = 'sms_send';
            }
            $user->save();
        }

        $obj=["Status"=>true,"success"=>1,"data"=>[],"msg"=>"Пользователь зарегистрирован. Направлен код подтверждения."];

        return response()->json($obj);
    }

    public function checkPhoneCode(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required',
          //  'user_id'=>'required',
        ]);
        if ($validator->fails()) {
            $obj=["Status"=>false,"success"=>0,"errors"=>$validator->errors()];
            return response()->json($obj);
        }
        $user = User::find(Auth::id());

        if($user->moneta['phone_confirmed'] != 'confirmed'){
            $ApprovePhoneApplyCodeRequest = new MonetaRequest([
                'ApprovePhoneApplyCodeRequest' => [
                    'confirmationCode' => $request->code,
                    'unitId' => $user->moneta['unit_id'],
                ]
            ]);
            $ApprovePhoneApplyCodeRequest = $ApprovePhoneApplyCodeRequest->send();
            if($ApprovePhoneApplyCodeRequest->Envelope->Body->ApprovePhoneApplyCodeResponse == []) {
                $user->moneta['phone_confirmed'] = 'confirmed';
                $user->save();
            }elseif (isset($ApprovePhoneApplyCodeRequest->Envelope->Body->fault) && $ApprovePhoneApplyCodeRequest->Envelope->Body->fault->detail->faultDetail == '500.3.2.51'){
                $user->moneta['phone_confirmed'] = 'code_error';
                $user->save();
            }
        }


        $SimplifiedIdentificationRequest = new MonetaRequest([
            'AsyncRequest' => [
                'SimplifiedIdentificationRequest' => [
                    'unitId' => $user->moneta['unit_id'],
                ],
                'callbackUrl' => URL::route('MonetaNotifications'),
            ]
        ]);
        $req = $SimplifiedIdentificationRequest->send();
        $user->moneta['asyncId'] = $req->Envelope->Body->AsyncResponse->asyncId;
        $user->moneta['identification_status'] = 'processing';
        $user->save();

        $obj=["Status"=>true,"success"=>1,"data"=>[],"msg"=>"Номер телефона подтверждён. Заявка на прохождение идентификации направлена."];

        return response()->json($obj);
    }

    public function callbackNotify(Request $request){
        Log::channel('moneta')->debug('CALLBACK: '.json_encode($request->all()));

        if($request->NOTIFICATION){
            switch ($request->NOTIFICATION){
                case 'IDENTIFICATION':
                    $user = User::where('moneta->unit_id', $request->UNIT_ID)->first();
                    $user->moneta['profile_id'] = $request->PROFILE_ID;
                    $user->moneta['identification_status'] = 'identified';
                    $user->moneta['identification_level'] = $request->ACTION;
                    $user->save();


                    if($user->moneta['account_id'] == null){
                        $CreateAccountRequest = new MonetaRequest([
                            'CreateAccountRequest' => [
                                'currency' => 'RUB',
                                'paymentPassword' => 609278,
                                'unitId' => $user->moneta['unit_id'],
                                'signature' => 'bKHSguefnjs',
                            ]
                        ]);
                        $req = $CreateAccountRequest->send();

                        $user->moneta['account_id'] = $req->Envelope->Body->CreateAccountResponse;
                        $user->save();
                    }
                    break;
            }
        }else{
            if ($request->asyncId){
                $AsyncRequest = new MonetaRequest([
                    'AsyncRequest' => [
                        'asyncId' => $request->asyncId
                    ]
                ]);
                $async = $AsyncRequest->send();
                if(!$async->Envelope->Body->AsyncResponse->SimplifiedIdentificationResponse->success){
                    $user = User::where('moneta->asyncId', $request->asyncId)->first();
                    $user->moneta['error_str'] = $async->Envelope->Body->AsyncResponse->SimplifiedIdentificationResponse->error;
                    $user->moneta['identification_status'] = 'identification_failed';
                    $user->save();
                }else{
                    $user = User::where('moneta->asyncId', $request->asyncId)->first();
                    $user->moneta['identification_status'] = 'identified';
                    $user->save();

                    if($user->moneta['account_id'] == null){
                        $CreateAccountRequest = new MonetaRequest([
                            'CreateAccountRequest' => [
                                'currency' => 'RUB',
                                'paymentPassword' => 609278,
                                'unitId' => $user->moneta['unit_id'],
                                'signature' => 'bKHSguefnjs',
                            ]
                        ]);
                        $req = $CreateAccountRequest->send();

                        $user->moneta['account_id'] = $req->Envelope->Body->CreateAccountResponse;
                        $user->save();
                    }

                }
            }
        }
    }

    public function getPaymentFormLink(Request $request){
        $validated = $request->validate([
            'payment_method_code'  => 'required|exists:payment_methods,code|in:moneta',
            'mentee_id'            => 'required|exists:users,id',
            'total'                => 'required|int:min:0',
            'plateForm'            => 'required|string',
            'bookAppointmentId'    => 'required|exists:book_appointment,id',
            'redirectAfterConfirm' => 'required|string',
        ]);

        $bookAppointment = BookAppointment::find($request->bookAppointmentId);
        $mentor = $bookAppointment->mentor;
        $mentorName = $mentor->first_name . ' ' . $mentor->last_name;
        $mentorName = trim($mentorName);

        $attributes = [
            'MNT_ID' => 47005365,
            'MNT_AMOUNT' => $request->total,
            'MNT_TRANSACTION_ID' => $bookAppointment->id,
            'MNT_TEST_MODE' => 1,
            'MNT_DESCRIPTION' => 'Оплата консультации у ' . $mentorName . ' на Timny.ru',
            'MNT_SUBSCRIBER_ID' => $mentor->id,
        ];
        return 'https://www.payanyway.ru/assistant.widget?' . http_build_query($attributes);
    }
}
