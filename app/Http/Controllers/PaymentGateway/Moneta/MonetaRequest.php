<?php

namespace App\Http\Controllers\PaymentGateway\Moneta;

use Exception;
use Illuminate\Support\Facades\Log;

class MonetaRequest
{
    private $login = 'kalmykov@timny.ru';
    private $password = 'Yre,fhzljv23';
    private $request;

    /**
     * @param $body array Тело запроса в соответствии с документацией Монеты
     */
    public function __construct(array $body)
    {
        $this->request = [
            'Envelope' => [
                'Header' => [
                    'Security' => [
                        'UsernameToken' => [
                            'Username' => $this->login,
                            'Password' => $this->password,
                        ]
                    ]
                ],
                'Body' => $body,
            ]
        ];
    }

    /**
     * Отправить запрос
     * @return object Ответ от Монеты
     * @throws Exception Если сервис вернёт ошибку, то будет выброшен Exception
     */
    public function send(): object
    {
        $data = $this->request;

        Log::channel('moneta')->debug('ЗАПРОС: '.json_encode($this->request, JSON_UNESCAPED_UNICODE));

        $ch = curl_init('https://service.moneta.ru/services');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        if(curl_errno($ch)){
            Log::channel('moneta')->debug('ОШИБКА: '.curl_errno($ch).' '.curl_strerror(curl_errno($ch)));
        }
        curl_close($ch);

        Log::channel('moneta')->debug('ОТВЕТ: '.$res);
        $ret = json_decode($res);
        if (isset($ret->Envelope->Body->fault)){
            if ($ret->Envelope->Body->fault->detail->faultDetail == '500.3.2.48'){
                return $ret;
            }else {
                throw new Exception($ret->Envelope->Body->fault->faultstring);
            }
        }

        return $ret;
    }
}
