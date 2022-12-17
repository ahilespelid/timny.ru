<?php

namespace App\Http\Controllers\PaymentGateway\Moneta;

class MonetaModel
{
    private $model = [
        'attribute' => []
    ];

    public function setAttribute($key, $value){
        $this->model['attribute'][] = [
            'key' => $key,
            'value' => $value
        ];
    }

    public function toArray($withoutAttribute = false){
        if(!$withoutAttribute) return $this->model;
        return $this->model['attribute'];
    }

}
