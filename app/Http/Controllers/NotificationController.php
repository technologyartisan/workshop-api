<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class NotificationController extends Controller
{
    public function sendNotification(Request $request){

        $validator=Validator::make($request->all(),[
            'title' => 'required',
            'fcm_token' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon Lengkapi Data'
            ],500);
        }

        $title=$request->title;
        $token=$request->fcm_token;

        $key = 'YOUR_API';
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $banyak_token=[
            'token1',
            'token2',
        ];
        
        $headers = array(
            'Authorization: key='.$key,
            'Content-Type: application/json'
        );

        $fields = array(
            'to' => $token,
            'registration_ids'=>$banyak_token,
            'notification' => array(
                'title' => $title,
                'body' => $request->message,
                'sound'=>'default'
            ),
            'data' => array(
                'id_barang' =>'1'
            )
        );
        
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL,$fcmUrl);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($curl_session);
        curl_close($curl_session);

        return response()->json(['success' => 'Pesan sudah terkirim']);
    }
}
