<?php
use App\Http\Models\Notification;
use Google\Client;
function sendNotificaton($message, $device_tokens,$user_id)
{
    // $allDeviceTokens = HistoryFcmToken::where('user_id', $request->to_user_id)->select('user_id', 'fcm_token')->get();

    $date =  date("F j, Y");
    $title = "style advice ";
    $conclution = "someone gave you style notes!";
    // -----generating access token----
    $credentialsFilePath = public_path() . "/firebase/firebase.json";
    $client = new \Google_Client();
    $client->setAuthConfig($credentialsFilePath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    $accessToken = $client->fetchAccessTokenWithAssertion();
    $access_token = $accessToken['access_token'];

    foreach ($device_tokens as $allDeviceToken) {
        $notification = [
            "message" => [
                "token" => $allDeviceToken['fcm_token'],
                "notification" => [
                    "title" => $title,
                    "body" => $conclution
                ]
            ]
        ];

        $payload = json_encode($notification);
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];
        $apiurl = 'https://fcm.googleapis.com/v1/projects/crowdstyler-8750c/messages:send';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }
    $notify = new Notification();
    $notify->user_id = $user_id;
    $notify->title = $title;
    $notify->notification = $conclution;
    $notify->customdate = $date;
    $notify->save();
    return response()->json(['status' => 'Success', 'message' => 'Commented successfully']);
}
