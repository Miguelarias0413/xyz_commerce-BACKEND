<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //

    public function createOrder(Request $request)
    {
        $userOrderCreater = $request->user();

        if (!$userOrderCreater) {
            return response()->json([
                'message' => 'Usuario no autenticado',
                'success' => false
            ], 401);
        }

        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|numeric|exists:products',
            'products.*.stock' => 'required|numeric'
        ]);

        $productsToBeCreated = $request->input('products');

        try {
            DB::transaction(function () use ($productsToBeCreated, $userOrderCreater) {

                $newOrder = Order::create([
                    'user_id' => $userOrderCreater->id
                ]);

                foreach ($productsToBeCreated as $product) {

                    $productToRefresh = Product::find($product['id']);

                    //En caso de que la cantidad de el stock disponible sea menor a la cantidad solicitada tirar exepcion
                    if ($productToRefresh->stock < $product['quantity']) {
                        throw new \Exception('Stock insuficiente para el producto con ID ' . $product['id']);
                    }


                    OrderDetail::create([
                        'order_id' =>  $newOrder['id'],
                        'product_id' => $product['id'],
                        'quantity' => $product['quantity']

                    ]);

                    // Actualiza el stock por el valor restado
                    $productToRefresh->stock = ($productToRefresh->stock - $product['quantity']);
                    $productToRefresh->save();
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'La orden se ha creado satisfactoriamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?? 'Hubo un error con la creacion de la orden'
            ]);
        }
    }
}
