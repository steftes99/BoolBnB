<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use Braintree\Gateway;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function generate(Request $request, Gateway $gateway){
        $clientToken = $gateway->clientToken()->generate();
        $data = [
            'token' => $clientToken
        ];
        return response()->json($data , 200);
    }

    public function makePayment(Request $request){
        return 'make Payments';
    }
}
