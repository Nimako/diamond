<?php

namespace App\Http\Controllers;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;

class CardController extends Controller
{
    
    public function GetCustomerCard(Request $request){

        $customer =  DB::table('customer_tbl')->where("email",$request->email)->first();

        if(!empty($customer)){

          $card = Card::where(['customerID'=>$customer->id, 'status'=>'ACTIVE'])->get();

          return response()->json(['statusCode'=>200, "data"=> $card,  'message' => ' success']);

        }else{
            return response()->json(['statusCode'=>500,  'message' => 'Unknown customer']);
        }

    }


    public function AddCard(Request $request){

        $customer =  DB::table('customer_tbl')->where("email",$request->email)->first();

        if(!empty($customer)){

            //Card::where(['customerID'=>$customer->id,'status'=>'ACTIVE']);

            $card = Card::create([
                'id'          => Str::uuid(),
                'customerID'  => $customer->id,
                'cardType'    => $request->cardType,
                'cardCountry' => '',
                //'cardNumber'  => Crypt::encryptString($request->cardNumber),
                'cardNumber'  => self::ccMasking($request->cardNumber),
                'nameOnCard'  => strtoupper($request->nameOnCard),
                'CardExpireDate' => $request->CardExpireDate,
                'status'      =>  'ACTIVE'
            ]);

        if($card){
            return response()->json(['statusCode'=>200, 'message' => 'Success']);
        }else{
            return response()->json(['statusCode'=>500, 'message' => 'Faild to to add customer card']);
        }

        }else{
            return response()->json(['statusCode'=>500, 'message' => 'Unknown customer']);
        }

    }


  public static  function ccMasking($number, $maskingCharacter = 'X') {
        return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
    }


}
