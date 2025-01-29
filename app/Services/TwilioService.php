<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function sendOtp($to, $otp)
    {
        try {
            $message = $this->twilio->messages->create(
                $to,
                [
                    "body" => "Your OTP code is: $otp",
                    "from" => env('TWILIO_PHONE_NUMBER')
                ]
            );

            return $message->sid;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
