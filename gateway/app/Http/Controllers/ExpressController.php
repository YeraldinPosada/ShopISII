<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ExpressController extends Controller
{
    public function traer_ventas(){
        $response = Http::withHeaders([
            'Authorization' => env("TOKEN_APIS"),
        ])->get(env("ENDPOINT_EXPRESS"));

        return [
            'status' => $response->status(),
            'body' => $response->body(),
        ];
    }

    public function crear_venta(Request $request){
        $user = Auth::user();

        //Llamarse a un metodo en flask que valide si el producto existe y si existe ese stock
        $response_stock = Http::withHeaders([
            'Authorization' => env("TOKEN_APIS")
        ])->get(env("ENDPOINT_FLASK_VALIDAR")."/".$request->producto_id);

        if($response_stock->status() == 404){
            return response()->json(["mensaje" => "producto no existe"]);
        }

        if($response_stock["stock"] < $request->cantidad){
            return response()->json(["mensaje" => "La cantidad de stock solicitada no se encuentra disponible"]);
        }

        $response = Http::withHeaders([
            'Authorization' => env("TOKEN_APIS"),
        ])->post(env("ENDPOINT_EXPRESS"),[
            "producto_id"=> $request->producto_id,
            "cantidad" => $request->cantidad,
            "usuario_id"=> $user->id,
            "total"=> $request->total
        ]);


        $response_resta = Http::withHeaders([
            'Authorization' => env("TOKEN_APIS")
        ])->put(env("ENDPOINT_FLASK_RESTA")."/".$request->producto_id,[
            "cantidad" => $request->cantidad
        ]);

        return [
            'status' => $response->status(),
            'body' => $response->body(),
        ];


    }

    public function actualizar_venta(Request $request, $id){
        $user = Auth::user();

        $response = Http::withHeaders([
            'Authorization' => env("TOKEN_APIS"),
        ])->put(env("ENDPOINT_EXPRESS")."/".$id, [
            "producto_id"=> $request->producto_id,
            "cantidad" => $request->cantidad,
            "usuario_id"=> $user->id,
            "total"=> $request->total
        ]);

        return [
            'status' => $response->status(),
            'body' => $response->body(),
        ];

    } 

    public function eliminar_venta($id){
        $response = Http::withHeaders([
            'Authorization' => env("TOKEN_APIS"),
        ])->delete(env("ENDPOINT_EXPRESS")."/".$id);

        return [
            'status' => $response->status(),
            'body' => $response->body(),
        ];
    }
}
