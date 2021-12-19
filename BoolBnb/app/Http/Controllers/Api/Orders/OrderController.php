<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderRequest;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Braintree\Gateway;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function generate(Request $request, Gateway $gateway){
        $clientToken = $gateway->clientToken()->generate();
        $data = [
            'success'=> true,
            'token' => $clientToken
        ];
        return response()->json($data , 200);
    }

    public function makePayment(OrderRequest $request, Gateway $gateway){

        $sponsorship = Sponsorship::find($request->sponsorship);

        $result = $gateway->transaction()->sale([
            'amount' => $sponsorship->price,
            'paymentMethodNonce' => $request->token,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);
        if($result->success){
            $data = [
                'success'=> true,
                'messagge'=>'transazione eseguita con successo'
            ];
            return response()->json($data , 200);

        }else{
            $data = [
                'success'=> false,
                'messagge'=>'transazione fallita'
            ];

            return response()->json($data, 401);
        }
    }
}
