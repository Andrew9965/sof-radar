<?php

namespace App\Http\Controllers\Api;

use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Omnipay\Omnipay;

class PaymentController extends Controller
{

    private $gateway = false;

    function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Express');
        $this->gateway->setUsername(config('services.pay-pal.account'));
        $this->gateway->setPassword(config('services.pay-pal.password'));
        $this->gateway->setSignature(config('services.pay-pal.signature'));
        $this->gateway->setTestMode(config('services.pay-pal.testMode'));
        $this->gateway->setLogoImageUrl('http://soft.laraman.ru/images/logo.png');
        $this->gateway->setHeaderImageUrl('http://soft.laraman.ru/images/logo.png');
        $this->gateway->setBorderColor('7440b3');
        $this->gateway->setBrandName(env('APP_NAME'));
    }

    public function index(Request $request)
    {
        if(!\Auth::user()->id) return response(['status' => 'error','message' => 'You no auth!'], 400);
        if(!$request->amount) return response(['status' => 'error','message' => 'You must specify the amount of the replenishment!'], 400);

        $tr = Transactions::create([
            'amount' => $request->amount,
            'user_id' => \Auth::user()->id,
            'status' => Transactions::STATUS_PENDING,
            'type' => Transactions::TYPE_REFILL,
            'hash' => $request->amount
        ]);

        $response = $this->gateway->purchase([
            'cancelUrl' => route('payment_cancel', ['transaction' => $tr->hash]),
            'returnUrl' => route('payment_return', ['transaction' => $tr->hash]),
            'description' => "Deposit for the amount of $ {$request->amount}",
            'amount' => $request->amount,
            'currency' => 'USD'
        ])->send();

        return response(['redirect_url' => $response->getRedirectUrl()]);
    }

    public function return_action(Transactions $transactions, Request $request)
    {
        if(!\Auth::user()->id) abort(404);
        if(!$request->token) abort(404);
        if(!$request->PayerID) abort(404);
        if($transactions->user_id != \Auth::user()->id) abort(404);
        if($transactions->status != Transactions::STATUS_PENDING) return redirect(route('user.index') . '#/status_balance/' . $transactions->id);

        $response = $this->gateway->completePurchase([
            'amount' => $transactions->amount,
            'currency' => 'USD',
            'token' => $request->token,
            'payerid' => $request->PayerID,
        ])->send();

        if ($response->isSuccessful()) {
            $transactions->update([
                'status' => Transactions::STATUS_SUCCESS,
                'response' => $response->getData()
            ]);

            return redirect(route('user.index') . '#/status_balance/' . $transactions->id);
        } else {
            $transactions->update([
                'status' => Transactions::STATUS_ERROR,
                'response' => $response->getData()
            ]);
            // throw new \Exception($response->getMessage());
            return redirect(route('user.index') . '#/status_balance/' . $transactions->id);
        }
    }

    public function cancel(Transactions $transactions, Request $request)
    {
        if($transactions->update(['status' => Transactions::STATUS_FAILED]))
            return redirect(route('user.index') . '#/status_balance/' . $transactions->id);
        else
            return redirect(route('user.index') . '#/status_balance/' . $transactions->id);
    }

    public function hook(Request $request)
    {

    }

}
