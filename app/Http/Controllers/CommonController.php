<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio;

class CommonController extends Controller
{
	public function send_otp(Request $request) {
		$data['phone'] = $request->phone;
		$newotp = rand(100000,999999);
		$data['message']='Your verify otp number is'.$newotp; 

		$msg_data = $this->send_sms($data);

		if($msg_data == null) {
            return response()->json(['message' => 'Otp send to your mobile successfully ','otp'=>$newotp]);
        } else {
            return response()->json(['error' => $msg_data]);
        }
	}

    public function send_sms($data) {

    	$phone = $data['phone'];
        $message = $data['message'];

       	try {
            $msg=Twilio::message($phone, $message);
            return $msg->error_message;
        } catch(\Services_Twilio_RestException $e) {
            return $e->getMessage(); 
        }

    }
}
