<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderitemController extends Controller
{
    public function index(){
        // echo "welcome to create bot page";
        $orders =OrderItem::orderBy('created_at','DESC')->get();

        return response()->json([
            'status' => true,
            'data' => $orders
        ],401);
    }


    public function store(Request $request){

        $rules= [
            "quantity" => "numeric",
            "rate" => "numeric",
            "total" => "numeric"

        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator -> failed()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ],401);
        }

        $order = new OrderItem();
        $order->product_id = $request->product_id;
        $order->quantity = $request->quantity;
        $order->rate = $request->rate;
        $order->total = $request->total;
        $order -> save();

        return response()->json([
            'status' => true,
            'message' => "The order was placed Successfully"
        ],401);




    }

    public function update(Request $request, $id){

        $order = OrderItem::find($id);

        if($order == null){
            return response()->json([
                'status' => false,
                'message' => "Order was not found"
            ],401);

        }


        $rules= [
            "quantity" => "numeric",
            "rate" => "numeric",
            "total" => "numeric"

        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator -> failed()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ],401);
        }

    
        $order->product_id = $request->product_id;
        $order->quantity = $request->quantity;
        $order->rate = $request->rate;
        $order->total = $request->total;
        $order->save();
    

        return response()->json([
            'status' => true,
            'message' => "The order updation is successfull"
        ],401);




    }

    public function delete($id){

        $order = OrderItem::find($id);

        if($order == null){
            return response()->json([
                'status' => false,
                'message' => "The order was not found"
            ],401);
        }

        $order->delete();

        return response()->json([
            'status' => true,
            'message' => "The was deleted successfully"
        ],401);
    }

    public function show($id){
        $order = OrderItem::find($id)->get()->first();

        if($order == null){
            return response()-> json([
                'status' => false,
                'message' => "The order was found"
            ],401);
        }

        return response()->json([
            'status' => true,
            'data' => $order
        ],401);

    }


}
