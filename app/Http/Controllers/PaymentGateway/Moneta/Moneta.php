<?php

namespace App\Http\Controllers\PaymentGateway\Moneta;

use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
use App\Models\NewTransaction;
use App\Models\User;
use Braintree\Test\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class Moneta extends Controller

{
    private const PROTOTYPE_ACCOUNT_ID = 45805242;
    private const MASTER_PASSWORD = 249729261;

    public function __construct(Request $request)
    {
        //TODO: Это самая настоящая дыра, убрать сразу после реализации нормальной аутентификации!
        if (!Auth::check()) if (isset($request->user_id)) Auth::loginUsingId($request->user_id);
    }

    /**
     * Создаёт счёт пользователя и сохраняет его номер в таблице
     * @param $id int Id пользователя в Timny
     * @return void
     * @throws Exception
     */
    private function createAccount(int $id): void
    {
        $user = User::find($id);
        $CreateAccountRequest = new MonetaRequest([
            'CreateAccountRequest' => [
                'prototypeAccountId' => self::PROTOTYPE_ACCOUNT_ID,
                'currency' => 'RUB',
                'unitId' => $user->moneta['unit_id'],
                'paymentPassword' => self::MASTER_PASSWORD,
                'signature' => 'bKHSguefnjs',
            ]
        ]);
        $req = $CreateAccountRequest->send();

        $user->moneta['account_id'] = $req->Envelope->Body->CreateAccountResponse;
        $user->save();
    }

    /**
     * Возвращает состояние регистрации и идентификации пользователя
     * @return array
     */
    public function getCondition(Request $request)
    {
        if (!Auth::check()) abort(401);
        $user_id = Auth::id() ?? $request->user_id;
        $user = User::where('id', $user_id)->select(['id', 'moneta'])->first();
        if($user->moneta == null){
            return [
                'unit_id' => null,
                'document_added' => false,
                'phone_confirmed' => false,
                'identification_status' => 'no_identified',
                'error_str' => null,
                'account_id' => null,
                'asyncId' => null,
                'profile_id' => null,
                'operation_id' => null,
            ];
        }
        return $user->moneta;
    }

    /**
     * Регистрирует профиль пользователя в Монете, добавляет его данные и отправляет SMS для подтверждения
     * @param Request $request
     * @return array[] Состояние пользователя (getCondition)
     * @throws Exception
     */
    public function createProfile(Request $request){


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
                'profile_id' => null,
                'operation_id' => null,
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


        return ['condition' => $user->moneta];
    }

    /**
     * Проверяет SMS-код и отправляет запрос на упрощённую идентификацию пользователя
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function checkPhoneCode(Request $request){
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

        if (isset($req->Envelope->Body->fault) && $req->Envelope->Body->fault->detail->faultDetail == '500.7.11'){
            $user->moneta['identification_status'] = 'identified';
        }else{
            $user->moneta['asyncId'] = $req->Envelope->Body->AsyncResponse->asyncId;
            $user->moneta['identification_status'] = 'processing';
        }
        $user->save();


        return ['condition' => $user->moneta];
    }

    /**
     * Обрабатывает уведомления Монеты
     * @param Request $request
     * @return string|void
     * @throws Exception
     */
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

//609278
                    if($user->moneta['account_id'] == null){
                        $this->createAccount($user->id);
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
                        $this->createAccount($user->id);
                    }

                }
            }
            if ($request->MNT_COMMAND){
                switch ($request->MNT_COMMAND) {
                    case 'CREDIT':
                        $md = md5($request->MNT_ID.$request->MNT_TRANSACTION_ID.$request->MNT_OPERATION_ID.$request->MNT_AMOUNT.$request->MNT_CURRENCY_CODE.$request->MNT_SUBSCRIBER_ID.$request->MNT_TEST_MODE.'bKHSguefnjs');
                        Log::channel('moneta')->debug('CB_PAYMENT_NOTIFY('.$md.'): '.json_encode($request->all()));

                        if($request->addCardMode != null || $request->addCardMode == 1){
                            Log::channel('moneta')->debug('Режим добавления карты');
                            $user = User::where('moneta->account_id', $request->MNT_ID)->first();
                            $user->moneta['operation_id'] = $request->MNT_OPERATION_ID;
                            $user->save();
                            Moneta::returnByOperationId($request->MNT_OPERATION_ID);
                        }
                        break;
                }
                return 'SUCCESS';
            }
        }
    }

    /**
     * Проводит возврат по операции
     * @param $operation_id int Id операции в системе Монеты
     * @return object
     * @throws Exception
     */
    public static function returnByOperationId(int $operation_id): object
    {
        $SimplifiedIdentificationRequest = new MonetaRequest([
            'RefundRequest' => [
                'transactionId' => $operation_id,
                'paymentPassword' => self::MASTER_PASSWORD,
            ]
        ]);
        return $SimplifiedIdentificationRequest->send();
    }

    /**
     * Создаёт запрос на выплату
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function createWithdrawOrder(Request $request){
        $user = User::find(Auth::id());
        $request->validate([
            'withdrawSum'  => 'required|max:'.$user->balance,
        ]);

        $operationInfo = new MonetaModel();
        $operationInfo->setAttribute('PAYMENTTOKEN', '0'.$user->moneta['operation_id']);


        $PaymentRequest = new MonetaRequest([
            'PaymentRequest' => [
                'payer' => $user->moneta['account_id'],
                'payee' => 'card',
                'amount' => $request->withdrawSum,
                'isPayerAmount' => true,
                'operationInfo' => $operationInfo->toArray(),
                'paymentPassword' => self::MASTER_PASSWORD,
            ]
        ]);
        $response = $PaymentRequest->send();
        $attributes = collect($response->Envelope->Body->PaymentResponse->attribute)->pluck('value', 'key');
        if($attributes['statusid'] == 'SUCCEED'){
            //$user->withdraw($attributes['sourceamounttotal']);

            $transaction = new NewTransaction();
            $transaction->recipient_id = $user->id;
            $transaction->amount = $attributes['sourceamounttotal'];
            $transaction->type = 'withdraw';
            $transaction->status = 'processing';
            $transaction->payment_object = json_encode($response);
            $transaction->operation_id = $response->Envelope->Body->PaymentResponse->id;
            $transaction->comment = 'Выплата ментору';
            $transaction->save();
        }

        return 'SUCCESS';
    }

    /**
     * Возвращает параметры для формирования платёжной формы
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function getPaymentFormLink(Request $request): string
    {
        //try{
            $validated = $request->validate([
                'total'                => 'required|int:min:0',
                'bookAppointmentId'    => 'required|exists:book_appointment,id',
            ]);


            $bookAppointment = BookAppointment::find($request->bookAppointmentId);
            $mentor = $bookAppointment->mentor;
            $mentorName = $mentor->first_name . ' ' . $mentor->last_name;
            $mentorName = trim($mentorName);
            $account = $mentor->moneta['account_id'];
            if($account == null) throw new Exception('Recipient payment account not found');

            $operationInfo = new MonetaModel();
            $operationInfo->setAttribute('SOURCETARIFFMULTIPLIER', '0.17');
            if($request->redirectAfterConfirm){
                $operationInfo->setAttribute('MNT_SUCCESS_URL', $request->redirectAfterConfirm);
            }
            $operationInfo->setAttribute('testMode', 0);



            $PaymentRequest = new MonetaRequest([
                'InvoiceRequest' => [
                    'payee' => $account,
                    'amount' => $request->total,
                    'clientTransaction' => $bookAppointment->id,
                    'description' => 'Оплата консультации у ' . $mentorName . ' на Timny.ru',
                    'mnt_custom1' => $mentor->id,
                    'operationInfo' => $operationInfo->toArray(),
                ]
            ]);

            $response = $PaymentRequest->send();
            $data['operationId'] = $response->Envelope->Body->InvoiceResponse->transaction;

            $transaction = new NewTransaction();
            $transaction->payer_id = $bookAppointment->mentee->id;
            $transaction->recipient_id = $bookAppointment->mentor->id;
            $transaction->amount = $request->total/100*80;
            $transaction->customer_amount = $request->total;
            $transaction->type = 'payment';
            $transaction->status = 'processing';
            $transaction->payment_object = json_encode($response);
            $transaction->book_appointment_id = $bookAppointment->id;
            $transaction->operation_id = $response->Envelope->Body->InvoiceResponse->transaction;
            $transaction->comment = 'Оплата консультации у ' . $mentorName . ' на Timny.ru';
            $transaction->save();

            return 'https://www.moneta.ru/assistant.widget?'.http_build_query($data);


//        return [
//            'account' => 47005365,
//            'amount' => $request->total,
//            'transactionId' => $bookAppointment->id,
//            'testMode' => 0,
//            'description' => 'Оплата консультации у ' . $mentorName . ' на Timny.ru',
//            'customParams' => [
//                'mentor_id' => $mentor->id,
//            ]
//        ];
//        }catch (Exception $e){
//            $response = [];
//            $response['error']['message'] = $e->getMessage();
//            return json_encode($response);
//        }

    }

    public function getAvailableBalance(){
        $user = User::find(Auth::id());

        $PaymentRequest = new MonetaRequest([
            'FindAccountByIdRequest' => [
                'value' => $user->moneta['account_id'],
                'version' => 'VERSION_2',
            ]
        ]);
        $response = $PaymentRequest->send();
        $user->balance = $response->Envelope->Body->FindAccountByIdResponse->account->availableBalance;
        $user->save();

        return $response->Envelope->Body->FindAccountByIdResponse->account->availableBalance;
    }
}
