<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlaskController extends Controller
{
    public function traer_productos(){
        $response = Http::withHeaders([
        'Authorization' => env("TOKEN"),
        ])->get(env("ENDPOINT_FLASK"));
        return [
        'status' => $response->status(),
        'body' => $response->body(),
        ];
    }

    public function crear_producto(Request $request){
        $response = Http:: withHeaders([
        'Authorization' => env("TOKEN"),
        ])->post(env("ENDPOINT_FLASK"),[
            "name"=> $request->name,
            "price" => $request->price,
            "color"=> $request->color,
            "stock"=> $request->stock
        ]);
        return [
        'status' => $response->status(),
        'body' => $response->body(),
        ];
        
    }

    public function actualizar_producto(Request $request, $id){
    $response = Http::withHeaders([
        'Authorization' => env("TOKEN"),
    ])->put(env("ENDPOINT_FLASK")."/".$id, [
        "name" => $request->name,
        "price" => $request->price,
        "color" => $request->color,
        "stock" => $request->stock
    ]);

    return [
        'status' => $response->status(),
        'body' => $response->body(),
    ];

    } 
    public function eliminar_producto($id){

    $response = Http::withHeaders([
        'Authorization' => env("TOKEN"),
    ])->delete(env("ENDPOINT_FLASK")."/".$id);

    return [
        'status' => $response->status(),
        'body' => $response->body(),
    ];

}

}
