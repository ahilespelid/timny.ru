<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property mixed $recipient_id
 * @property mixed $amount
 * @property mixed $payer_id
 * @property mixed $type
 * @property mixed|string $status
 * @property false|mixed|string $payment_object
 * @property mixed $operation_id
 * @property mixed|string $comment
 * @property mixed $book_appointment_id
 * @property mixed $customer_amount
 */
class NewTransaction extends Model
{
    use HasFactory;

    protected $hidden = ['payment_object'];

    protected static function booted()
    {

        static::saving(function($tr){
            Log::channel('transactions')->debug('Обновление транзакции: '.json_encode($tr));
            if($tr->status != $tr->getOriginal('status')){
                switch ($tr->status){
                    case 'holding':
                    case 'refused':
                    case 'processing':
                    case 'returned':
                        break;
                    case 'returning':
                        Log::channel('transactions')->debug('Перевод в статус returning');
                        if($tr->getOriginal('status') == 'done'){
                            Log::channel('transactions')->debug('Вычет с баланса пользователя');
                            $user = User::find($tr->recipient_id);
                            $user->balance += $tr->amount * -1;
                            $user->save();
                        }else{
                            Log::channel('transactions')->debug('Вычет с баланса пользователя не требуется');
                        }
                        break;
                    case 'done':
                        Log::channel('transactions')->debug('Зачисление на баланс пользователя');
                        if($tr->type == 'payment'){
                            $user = User::find($tr->recipient_id);
                        }elseif($tr->type == 'withdraw'){
                            $user = User::find($tr->payer_id);
                        }
                        $user->balance += $tr->amount;
                        $user->save();
                        break;
                }
            }



        });
    }
}
