<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function addUserProduct(Request $request)
    {

        $userToBeAttached = User::find($request->get('userID'));

        if ($userToBeAttached->products()->where('product_id', $request->get('productID'))->exists()) {

            return response()->json(['message' => 'El producto ya ha sido asociado','success' => true], 400);
        }


        $userToBeAttached->products()->attach($request->get('productID'));


        return response()->json([
            'message' => 'El producto se asoció correctamente',
            'success' => true
        ],200);
    }

    public function getAllUsers()
    {
        $allUsers = User::all();

        return response()->json([
            'users' => $allUsers,
            'success' => true
        ], 200);
    }
    public function getAllProducts()
    {
        $allProducts = Product::all();

        return response()->json([
            'products' => $allProducts,
            'success' => true
        ], 200);
    }


    public function associateProductsToUser(Request $request){

        $userAuth = $request->user();
        
        if (!$userAuth){
            return  response()->json([
                'message' => 'Usuario no autenticado',
                'success' => false
            ]);
        }

        return  response()->json([
            'products' => $userAuth->products,
            'success' => true
        ]);
    }
}
