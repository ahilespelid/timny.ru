<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {

        $allAttributes = [];
        $allAttributes['payment_method_code'] = trans('messages.fields.payment_method');
        $allAttributes['cardInfo.number'] = trans('messages.fields.cardInfo.number');
        $allAttributes['cardInfo.exp_month'] = trans('messages.fields.cardInfo.exp_month');
        $allAttributes['cardInfo.exp_year'] = trans('messages.fields.cardInfo.exp_year');
        $allAttributes['cardInfo.cvc'] = trans('messages.fields.cardInfo.cvc');
        $allAttributes['plateForm'] = trans('messages.fields.plateForm');
        $allAttributes['paytm_mode'] = trans('messages.fields.paytm_mode');
        return $allAttributes;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method_code' => 'required|exists:payment_methods,code',
            'mentee_id'           => 'required|exists:users,id',
            'total'               => 'required|int:min:0',
            'plateForm'           => 'required|string',
            'cardInfo.number'     => 'required_if:payment_method_code,stripe,braintree|nullable|min:16|max:16',
            'cardInfo.exp_month'  => 'required_if:payment_method_code,stripe,braintree|nullable|min:2|max:4',
            'cardInfo.exp_year'   => 'required_if:payment_method_code,stripe,braintree|nullable|min:2|max:4',
            'cardInfo.cvc'        => 'required_if:payment_method_code,stripe,braintree|nullable|min:3|max:3',
            'paytm_mode'          => 'required_if:payment_method_code,paytm',
        ];
    }
}
