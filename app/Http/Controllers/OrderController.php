<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function createOrder(Request $request){
        $userOrderCreater = $request->user();


        if (!$userOrderCreater){
            return response()->json([
                'message' => 'Usuario no autenticado',
                'success'=> false
            ], 401);
        }


        
    }
}
