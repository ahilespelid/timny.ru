<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PaymentMethod;
use App\Http\Controllers\Front\AppointmentBookingController;
use Illuminate\Support\Facades\Log;
use YooKassa\Client as YooKassaClient;

class UKassa extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    /*
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $request;
    public $customer;
    public $access_token;

    public function __construct()
    {
    }
    // Posts
    public function index(Request $request)
    {
    }
    public function setAuthorizationKeys($payment_method)
    {
        foreach ($payment_method as $setting) {
            if ($setting->name == 'secret_key') {
                $secret_key = $setting->value;
            }
            if ($setting->name == 'client_id') {
                $client_id = $setting->value;
                $client_id = base64_encode($client_id);
            }
        }
        $this->headers['Authorization'] = "Basic '$client_id':'$secret_key";
        $this->headers['Accept'] = 'application/json';
        $this->headers['Accept-Language'] = 'en_US';
    }
    public function generateBody($required, $customer)
    {
        $url = url('/');
        $this->headers['Authorization'] = 'Bearer ' . $this->access_token;
          $amnt = $required['total'];
        // $amnt = 10;

        $this->body['intent'] = 'CAPTURE';
        $ammount['currency_code'] = 'USD';
        $ammount['value'] = $amnt;
        $this->body['purchase_units'] = [
            [
                'amount' => $ammount,
            ]
        ];
        $application_context['return_url'] = $url . "/processingPayment";
        $this->body['application_context'] = $application_context;
        return $this->sendRequest();
    }
    public function executePayment($request, $customer)
    {
        $this->request = $request;
        $this->customer = $customer;
        return $this->getAccessToken($request);
    }
    public function getAccessToken($payment_method_info)
    {
        $res = HTTP::withHeaders($this->headers)->asForm()->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);
        if ($res->successful() || $res->ok()) {
            $token = json_decode($res->body());
            $this->access_token = $token->access_token;
            return $this->generateBody($this->request, $this->customer);
        } else {
            $this->Response($res);
        }
    }

    public function sendRequest()
    {
        $res = Http::withHeaders($this->headers)->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $this->body);
        return $this->Response($res);
    }
    public function authorizeWithoutCapture()
    {
    }
    public function authorizeWithCapture()
    {
    }
    public function Response($res)
    {
        $body = json_decode($res->body());
        if ($res->successful() || $res->ok()) {
            $data['receipt_email'] = '';
            $data['metadata'] = '';
            $data['intent_id'] = $body->id;
            $data['capture_id'] = $body->id;
            $data['shipping_details'] = '';
            $response['data'] = $data;
            $response['success'] = true;
            $response['captured'] = false;
            $response['authorization_required'] = true;
            foreach ($body->links as $link) {
                if ($link->rel == 'approve') {
                    $response['authorization_url'] = $link->href;
                }
            }
            $response['return_url'] = '';
            $response['status'] = '200';
            return $response;
        } else {
            if ($body->message) {
                $error['message'] = $body->message;
                $response['data'] = $error;
            }
            $response['success'] = false;
            $response['captured'] = false;
            $response['status'] = $res->status();
            return $response;
        }
    }
    */
    public function verifyPayment(Request $request)
    {

        $validated = $request->validate([
            'bookAppointmentId' => 'required|exists:book_appointment,id',
        ]);

        $bookAppointment = BookAppointment::find($validated['bookAppointmentId']);

        $payment_method_settings = PaymentMethod::with('settings')->where('code', 'ukassa')->first();

        $shopId = $payment_method_settings->settings->where('name', 'shopId')->first()->value;
        $secretKey = $payment_method_settings->settings->where('name', 'secretKey')->first()->value;
        $client = new YooKassaClient();
        $client->setAuth($shopId, $secretKey);

        try {
            $responseUKassa = $client->getPaymentInfo($bookAppointment->payment_response_msg);
        } catch (\Exception $e) {
            $result = $e->getMessage();
            return view('thank-you', compact('result'));
        }

        $metadata = $responseUKassa->getMetadata();
        $platform = "web";
        if (isset($metadata->unknownProperties) && isset($metadata->unknownProperties['platform']) && ($metadata->unknownProperties['platform']=='api')) {
            $platform = "api";
        }

        if ($responseUKassa->getStatus() == 'succeeded') {
            $appointment = new AppointmentBookingController();
            $appointment_res = $appointment->updateAppointmentAfterPayment($bookAppointment->id, $payment_method_settings->id);
            if (isset($metadata->unknownProperties) && isset($metadata->unknownProperties['redirectAfterConfirm'])) {
                return redirect($metadata->unknownProperties['redirectAfterConfirm']);
            }

            if ($platform == 'web') {
                $result = 'Оплата "' . $responseUKassa->getDescription() . '" прошла!';
                return view('thank-you', compact('result'));
            } else {
                return redirect($metadata->unknownProperties['redirectAfterConfirm']);
            }

        }

        if ($platform == 'web') {
            $result = 'Оплата "' . $responseUKassa->getDescription() . '" не прошла!';
            // dd($bookAppointmentId);
            return view('thank-you', compact('result'));
        } else {
            return redirect($metadata->unknownProperties['redirectAfterConfirm']);
        }



    }

    public function webHook()
    {
        try {
            /*
            $validated = $request->validate([
                'type'   => 'required|in:notification',
                'event'  => 'required|string',
                'object' => 'required|string',
            ]);
            */

            $source = file_get_contents('php://input');
            $data = json_decode($source, true);

            $factory = new \YooKassa\Model\Notification\NotificationFactory();
            $notificationObject = $factory->factory($data);
            $responseObject = $notificationObject->getObject();

            $payment_method_settings = PaymentMethod::with('settings')->where('code', 'ukassa')->first();
            $shopId = $payment_method_settings->settings->where('name', 'shopId')->first()->value;
            $secretKey = $payment_method_settings->settings->where('name', 'secretKey')->first()->value;
            $client = new YooKassaClient();
            $client->setAuth($shopId, $secretKey);

            $log = Log::build([
                'driver' => 'daily',
                'path'   => storage_path('logs/ukassa-webhook.log'),
            ]);

            if (!$client->isNotificationIPTrusted($_SERVER['REMOTE_ADDR'])) {
                header('HTTP/1.1 400 Something went wrong');
                $log->warning('Callback from unknown IP ' . $_SERVER['REMOTE_ADDR']);
                exit();
            }

            if ($notificationObject->getEvent() === \YooKassa\Model\NotificationEventType::PAYMENT_SUCCEEDED) {

                $metadata = $responseObject->getMetadata();

                if (isset($metadata)
                    && isset($metadata['bookAppointmentId'])
                ) {
                    if ($bookAppointment = BookAppointment::find($metadata['bookAppointmentId'])) {
                        if ($bookAppointment->is_paid == 1) {
                            $log->info('Payment ' . $responseObject->getId() . ' BookAppointment [' . $bookAppointment->id . '] paid early');
                            exit();
                        }
                        $appointment = new AppointmentBookingController();
                        $appointment->updateAppointmentAfterPayment($bookAppointment->id, $payment_method_settings->id);
                        $log->info('Payment ' . $responseObject->getId() . ' BookAppointment [' . $bookAppointment->id . '] successful paid');
                        exit();

                    } else {
                        $log->warning('Payment ' . $responseObject->getId() . ' BookAppointment [' . $metadata['bookAppointmentId'] . '] not found');
                        exit();
                    }

                } else {
                    $log->warning('Payment ' . $responseObject->getId() . ' not set metadata.bookAppointmentId');
                    exit();
                }
                //$log->info((string)($source));

            } else {
                //header('HTTP/1.1 400 Something went wrong');
                $log->warning('Payment ' . $responseObject->getId() . ' status ' . $notificationObject->getEvent());
                exit();
            }

        } catch (\Throwable $e) {
            $log->error($e->getMessage());
            header('HTTP/1.1 400 Something went wrong');
            exit();
        }

        exit();

    }
}
