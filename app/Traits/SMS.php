<?php

namespace App\Traits;


trait SMS
{
    public static function sendSMS($mobile_no, $text)
    {
        try {

            $url = "http://103.84.172.18//api/v2/SendSMS";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $headers = array(
                "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $data = <<<DATA
            {
                "senderId": "8804445602034",
                "is_Unicode": true,
                "message": "text",
                "mobileNumbers": "8801705102555",
                "apiKey": "9MTeT73uudFUMhe6U91NqUodZrtGYBJklqjp8wbnhms=",
                "clientId": "c9768b8e-7609-48ce-896b-60daa0c8c3ec"
            }
            DATA;

            // dd( $data );
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $resp = curl_exec($curl);
            curl_close($curl);
            return $resp ;

        } catch (\Exception $e) {
            return ['sms'=> $e->getMessage() ];
        }
    }


}
